<?php

class Produtos
{

    private array $data; // Dados do produto a serem criados ou atualizados ou excluídos recebidos do filtro, o qual recebeu esse id do formulário
    private int $id; // id do produto recebido do filtro, o qual recebeu esse id do formulário
    private $resultado; // Resultado da operação (sucesso ou falha)
    private $erro; // Mensagem de erro, se houver

    private const BD = 'produto';

    // Função que cria um novo produto
    public function criarProduto(array $data): bool //criarProduto:Função que recebe como parâmetro os dados($data) que vieram do filtro criar
    {
        $this->data = $data; //data recebe os dados do produto a serem criados

        // --- BLOQUEIO: já existe capa para esta transação? ---
        if (!empty($this->data['transacao'])) {
            $ler = new Ler();
            $ler->Leitura(self::BD, "WHERE transacao = :t AND capa IS NOT NULL AND capa != ''", "t={$this->data['transacao']}");
            if ($ler->getResultado()) {
                //Verifica se na tabela produto_cliente já existe uma capa correspondente a essa transação contida em data
                $this->resultado = false; // Se for false - não existe
                return false; // Retorna false e continua
            }
        }
        // ------------------------------------------------------

        $seguranca = 2;

        if ($seguranca == 1) { //Como segurança é igual a 2 pula pra verificaCampos
            if (!$this->data) { // Só verifica se data está vazia
                return $this->resultado = false; //Se data estiver vazia retorna false e o código não continua mesmo com dados vazios em data
            }
        } else {
            if ($this->verificaCampos($this->data)) { //verificaCampos verifica se há campos vazios no array data com os dados do formulário
                return $this->resultado = false; //Se não houver campos vazios retorna false e o código continua
            }
        }

        $this->filtroBanco(); //Função que Filtra os dados antes de salvar
        $this->enviaCapa(); //Função que envia a capa do produto
        return $this->salvarNoBanco(); //Função que salva os dados no banco
    }



    public function atualizarProduto(int $id, array $data): bool
    {
        $this->id = $id; // id recebe o ID do produto a ser atualizado
        $this->data = $data; // data recebe os novos dados do produto a ser atualizado

        if (!$this->data) { // Verifica se data está vazia
            return $this->resultado = false;
            exit(); // Encerra a execução
        }

        $this->filtroBanco();
        $this->atualizaCapa();
        return $this->atualizarNoBanco();
    }


    public function vamosExcluir(int $id): bool
    {
        $this->id = $id;

        // Valida se o ID é positivo
        if ($this->id <= 0) {
            $this->resultado = false;
            $this->erro = 'ID inválido para exclusão.';
            return false;
        }

        // Obtém a conexão PDO
        $pdo = Conexao::getConectar();

        try {
            // Inicia a transação
            $pdo->beginTransaction();

            // Passo 1: Remove do banco
            $sucessoBanco = $this->removeBancoDeDados();

            if (!$sucessoBanco) {
                $pdo->rollBack();//Rollback cancela a transação
                $this->resultado = false;
                $this->erro = 'Erro ao excluir o produto no banco de dados.';
                return false;
            }

            // Passo 2: Remove a capa (se existir)
            $sucessoCapa = $this->removeCapa();

            if (!$sucessoCapa) {
                $pdo->rollBack(); //Rollback cancela a transação
                $this->resultado = false;
                $this->erro = 'Erro ao excluir a capa do produto.';
                return false;
            }

            // Se tudo deu certo → confirma a transação
            $pdo->commit(); //Commit confirma a transação
            return $this->resultado = true;
        } catch (Exception $e) {
            // Em caso de erro inesperado → cancela tudo
            $pdo->rollBack();
            $this->resultado = false;
            $this->erro = "Erro inesperado: " . $e->getMessage();
            return false;
        }
    }


    public function getResultado()
    {
        return $this->resultado;
    }



    private function verificaCampos(array $data)
    {
        return in_array('', $data);
    }




    /*Boa prática de design
    
Métodos que apenas executam efeitos colaterais (como salvar arquivos, atualizar propriedades, enviar e-mails, logar algo) devem ser void.
Métodos que calculam algo e precisam fornecer um resultado para outro lugar devem retornar um valor (int, string, array, etc.).
No caso do enviaCapa():

Ela só “executa” → valida, renomeia, move a imagem.

O resultado é guardado em $this->data['capa'].

Não faz sentido retornar nada → void é perfeito. */


    private function enviaCapa(): void
    {
        if (isset($this->data['capa'])) { //Verifica se existe uma imagem (capa):
            // Se a imagem foi enviada, cria uma instância da classe Uploads para gerenciar o upload da imagem
            // A classe Uploads é responsável por validar, redimensionar e salvar a imagem no servidor
            $enviaCapa = new Uploads(SHEEP_IMG_PRODUTOS); // SHEEP_IMG_PRODUTOS constante que define o diretório onde as imagens dos produtos serão salvas
            //Uploads:
            /*Valida extensão (só JPG, PNG, GIF) - Verifica MIME type(JPG, PNG, GIF) - Bloqueia extensões perigosas (.php, .js, etc.) - Redimensiona a imagem (máx. 2000px)
Gera nome limpo com Formata::Name - Salva em /images/ano/mes/ -Se tudo ok → retorna o caminho seguro:images/2025/08/camisa-barcelona-jogador-raiz-1692345678.png
Se der erro → capa é removida (unset).*/

            $urlCapa =  Formata::Name($this->data['titulo']) . '-jogador-raiz-' . time() . '-' . rand();
            // Usa a função Name para transformar o título em algo amigável para URL.
            // Adiciona -jogador-raiz- + timestamp + número aleatório (rand()) para garantir que cada arquivo seja único.
            $enviaCapa->Image($this->data['capa'], $urlCapa);
            // Passa a imagem original ($this->data['capa']) e o novo nome ($urlCapa) para a classe Uploads.
            //O que a classe Uploads faz na função Image() (que é a usada no enviaCapa):
            // A classe Uploads vai cuidar de validar o tipo de imagem, redimensionar, gerar nome único e salvar na pasta correta.
            // Se a imagem for válida, ela será salva em SHEEP_IMG_PRODUTOS
            // Aqui ocorre o salvamento físico da imagem no servidor.
        }

        if (isset($enviaCapa) && $enviaCapa->getResult()) { // Se $enviaCapa foi instanciado e a imagem foi enviada corretamente
            $this->data['capa'] = $enviaCapa->getResult(); //Se deu tudo certo, atualiza $this->data['capa'] com o novo nome da imagem salva
        } else {
            unset($this->data['capa']); //Se falhou, remove a entrada de capa do array $this->data para evitar salvar um valor inválido no banco.
        }
    }

    private function atualizaCapa(): void
    {
        if (isset($this->data['capa'])) { //Verifica se existe uma imagem (capa):

            $ler = new Ler(); // Instancia a classe Ler
            $ler->Leitura(self::BD, "WHERE id = :id", "id={$this->id}"); //Busca pelo id na tabela produtos qual produto terá a capa atualizada
            if ($ler->getResultado()) { // Se houver na tabela produtos um produto com id correspondente ao que foi pesquisado
                $urlImagem = SHEEP_IMG_PRODUTOS . $ler->getResultado()[0]['capa'];
                // Verifica na pasta img-produtos se a imagem buscada no banco através do id existe e não é um diretório vazio
                if (file_exists($urlImagem) && !is_dir($urlImagem)) {
                    // Se a imagem existe e não é um diretório, remove a imagem antiga
                    unlink($urlImagem); //Remove a imagem antiga
                    // unlink() é usado para excluir o arquivo do sistema de arquivos.
                    // Isso garante que a imagem antiga seja removida antes de salvar a nova.
                }
            }
        }
        $this->enviaCapa(); // Envia a nova imagem (capa) usando a função enviaCapa()
    }


    /**
     * Remove a capa do produto, se existir
     */
    private function removeCapa(): bool
    {
        $ler = new Ler();
        $ler->Leitura(self::BD, "WHERE id = :id", "id={$this->id}");

        if ($ler->getResultado()) {
            $capa = $ler->getResultado()[0]['capa'];

            // Se não há capa definida → sucesso
            if (empty($capa)) {
                return true;
            }

            $urlImagem = SHEEP_IMG_PRODUTOS . $capa;

            // Se o arquivo existe e não é diretório → tenta remover
            if (file_exists($urlImagem) && !is_dir($urlImagem)) {
                if (!unlink($urlImagem)) {
                    // Falhou ao remover a capa
                    return false;
                }
            }
        }

        // Se não encontrou produto ou não tinha capa → sucesso
        return true;
    }



    private function filtroBanco(): void
    {
        $capa = $this->data['capa'];
        $descricao = $this->data['descricao'];

        unset($this->data['capa'], $this->data['descricao'], $this->data['id'], $this->data['sheep_firewall']);

        $this->data = array_map('trim', $this->data);
        $this->data = array_map('htmlspecialchars', $this->data);
        preg_replace('/[^[:alnum:]@]/', '', $this->data);

        $this->data['url'] = Formata::Name($this->data['titulo']) . '-jogador-raiz-' . time() . '-' . rand();
        $this->data['titulo'] = (string) $this->data['titulo'];
        $this->data['name_l'] = (string) $this->data['name_l'];
        $this->data['name_ll'] = (string) $this->data['name_ll'];
        $this->data['name_lll'] = (string) $this->data['name_lll'];
        $this->data['name_lll_l'] = (string) $this->data['name_lll_l'];
        $this->data['name_lll_ll'] = (string) $this->data['name_lll_ll'];
        $this->data['name_lll_lll'] = (string) $this->data['name_lll_lll'];
        $this->data['capa'] = $capa;
        $this->data['descricao'] = $descricao;
        $this->data['id_categoria'] = (int) $this->data['id_categoria'];
        $this->data['valor'] = $this->data['valor'];
        $this->data['tags'] = (string) $this->data['tags'];
        $this->data['status'] = (string) $this->data['status'];
        $this->data['tamanho_p'] = (string) $this->data['tamanho_p'];
        $this->data['tamanho_m'] = (string) $this->data['tamanho_m'];
        $this->data['tamanho_g'] = (string) $this->data['tamanho_g'];
        $this->data['tamanho_gg'] = (string) $this->data['tamanho_gg'];
        $this->data['tamanho_xg'] = (string) $this->data['tamanho_xg'];
        $this->data['tamanho_lllxl'] = (string) $this->data['tamanho_lllxl'];
        $this->data['tamanho_llll_xl'] = (string) $this->data['tamanho_llll_xl'];
        $this->data['lancamentos'] = (string) $this->data['lancamentos'];
        $this->data['peso_correio'] = $this->data['peso_correio'];
        $this->data['diametro_correios'] = $this->data['diametro_correios'];
        $this->data['comprimento_correios'] = $this->data['comprimento_correios'];
        $this->data['largura_correios'] = $this->data['largura_correios'];
        $this->data['altura_correios'] = $this->data['altura_correios'];
        $this->data['tipo'] = (string) $this->data['tipo'];
        $this->data['tipo_cadastro'] = (string) $this->data['tipo_cadastro'];
        $this->data['estoque'] = (int) $this->data['estoque'];
        $this->data['usuario'] = (int) $this->data['usuario'];

        if ($this->data['tipo_cadastro'] == 'criar') {
            $this->data['data'] = date('Y-m-d H:i:s');
            $this->data['dia'] = date('d');
            $this->data['mes'] = date('m');
            $this->data['ano'] = date('Y');
        }
    }

    private function salvarNoBanco()
    {
        $salvar = new Criar();
        $salvar->Criacao(self::BD, $this->data);// data recebe os dados a serem salvos vindo do formulário
        if ($salvar->getResultado()) {
            return $this->resultado = $salvar->getResultado();
            return true;
        }
    }


    private function atualizarNoBanco(): bool
    {
        $atualizar = new Atualizar();
        $atualizar->Atualizando(self::BD, $this->data, "WHERE id = :id", "id={$this->id}");
        if ($atualizar->getResultado()) {                               // Esse id é o id que veio do filtro como parâmetro de atualizarProduto()
            return $this->resultado = true;                             // ele foi chamado aqui na classe Produtos na função atualizarProduto()
        }
        return false;
    }


    private function removeBancoDeDados(): bool
    {
        $excluir = new Excluir();                                       // Esse id é o id que veio do filtro como parâmetro de vamosExcluir()
        $excluir->Remover(self::BD, "WHERE id = :id", "id={$this->id}"); // ele foi chamado aqui na classe Produtos na função vamosExcluir()
        if ($excluir->getResultado()) {         //Ele é a string que preenche Adicionais que por sua vez cria um array associativo em Locais
            return $this->resultado = true;     //Locais é executado na funçao Execute() como parâmetro de execute() que preenche                   
        }                                       // os campos da query SQL "Excluir" que está na função Execute()  que é executada em Remover()
        return false;
    }
}
