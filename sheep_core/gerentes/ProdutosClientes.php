<?php

class ProdutosClientes
{

    private array $data;
    private int $id;
    private $resultado;
    private const BD = 'produto_cliente';

    // Função que cria um novo produto
    public function criarProduto(array $data): bool //criarProduto:Função que recebe como parâmetro os dados($data) que vieram do filtro criando
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
        $this->id = $id;
        $this->data = $data;

        if (!$this->data) {
            return $this->resultado = false;
            exit();
        }

        $this->filtroBanco();
        $this->atualizaCapa();
        return $this->atualizarNoBanco();
    }

    public function vamosExcluir(int $id): bool
    {
        $this->id = $id;
        if (!$this->id) {
            return $this->resultado = false;
            exit();
        }

        $this->removeCapa();
        return $this->removeBancoDeDados();
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

            $enviaCapa = new Uploads(SHEEP_IMG_PRODUTOS); //Instancia a classe Uploads que é responsável por enviar arquivos para o servidor
        // Uploads:
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
        if (isset($this->data['capa'])) {

            $ler = new Ler();
            $ler->Leitura(self::BD, "WHERE id = :id", "id={$this->id}");
            if ($ler->getResultado()) {
                $urlImagem = SHEEP_IMG_PRODUTOS . $ler->getResultado()[0]['capa'];
                if (file_exists($urlImagem) && !is_dir($urlImagem)) {
                    unlink($urlImagem);
                }

                $enviaCapa = new Uploads(SHEEP_IMG_PRODUTOS);
                $urlCapa =  Formata::Name($this->data['titulo']) . '-msflix-' . time() . '-' . rand();
                $enviaCapa->Image($this->data['capa'], $urlCapa);
            }
        }

        if (isset($enviaCapa) && $enviaCapa->getResult()) {
            $this->data['capa'] = $enviaCapa->getResult();
        } else {
            unset($this->data['capa']);
        }
    }

    private function removeCapa(): void
    {
        $ler = new Ler();
        $ler->Leitura(self::BD, "WHERE id = :id", "id={$this->id}");
        if ($ler->getResultado()) {
            $urlImagem = SHEEP_IMG_PRODUTOS . $ler->getResultado()[0]['capa'];
            if (file_exists($urlImagem) && !is_dir($urlImagem)) {
                unlink($urlImagem);
            }
        }
    }


    // Filtra todos os dados que serão inseridos no banco de dados
    private function filtroBanco(): void
    {
        // Guarda a capa antes de limpar
        $capa = $this->data['capa'];

        // Remove campos que não devem ir para o banco
        unset(
            //unset($this->data['capa'],Remove e evita que a capa seja modificada pelo array_map e pelos filtros (htmlspecialchars, preg_replace).
            $this->data['capa'],
            $this->data['descricao'],
            $this->data['id'],
            $this->data['sheep_firewall']
        );

        // Remove espaços extras
        $this->data = array_map('trim', $this->data);

        // Protege contra XSS
        $this->data = array_map('htmlspecialchars', $this->data);

        // Remove caracteres não alfanuméricos (mantendo @)
         preg_replace('/[^[:alnum:]@]/', '', $this->data);

        // Gera URL única
        /// Através da função Formata::Name modifica o título retirando caracteres especiais, espaços, deixando minusculo e etc..
        $this->data['url'] = Formata::Name($this->data['titulo'])
            . '-jogador-raiz-' . time() . '-' . rand();
        // Cria uma URL única para o produto, usando o título, timestamp e um número aleatório para que a url seja única.
        //Exemplo: camisa-do-barcelona-jogador-raiz-1692345678-12345
        
        // Força tipos de dados para que só envie dados do tipo certo do dado recebido(string,int,float,booleano)
        $this->data['transacao']     = (string) $this->data['transacao'];
        $this->data['titulo']        = (string) $this->data['titulo'];
        $this->data['titulo_b']        = (string) $this->data['titulo_b'];
        $this->data['capa']          = $capa;
        $this->data['tipo']          = (string) $this->data['tipo'];
        $this->data['tipo_cadastro'] = (string) $this->data['tipo_cadastro'];
        $this->data['usuario']       = (int) $this->data['usuario'];

        // Se for cadastro novo, adiciona data completa e fragmentada
        if ($this->data['tipo_cadastro'] === 'criar') {//Novo cadastro do tipo criar com a data da criação
            $this->data['data'] = date('Y-m-d H:i:s');
            $this->data['dia']  = date('d');
            $this->data['mes']  = date('m');
            $this->data['ano']  = date('Y');
        }
    }

    // Faz a inserção dos dados no banco de dados 
    private function salvarNoBanco(): bool
    {
        $salvar = new Criar();//Instancia a classe Criar
        $salvar->Criacao(self::BD, $this->data);// BD é a tabela 'produtos_clientes' e $this->data são os dados filtrados do formulário
        //Criação() É a função da classe Criar com o método responsável por criar um registro no banco de dados

        if ($salvar->getResultado()) {//Caso a criação do registro seja bem-sucedida
            $this->resultado = $salvar->getResultado();//Armazena o ID do último registro inserido em $this->resultado
            return true;//Retorna verdadeiro indicando que a inserção foi bem-sucedida
        }

        return false;//Caso a inserção falhe, retorna falso indicando que a inserção falhou
    }


    private function atualizarNoBanco(): bool
    {
        $atualizar = new Atualizar();
        $atualizar->Atualizando(self::BD, $this->data, "WHERE id = :id", "id={$this->id}");
        if ($atualizar->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }


    private function removeBancoDeDados(): bool
    {
        $excluir = new Excluir();
        $excluir->Remover(self::BD, "WHERE id = :id", "id={$this->id}");
        if ($excluir->getResultado()) {
            return $this->resultado = true;
        }
        return false;
    }
}
