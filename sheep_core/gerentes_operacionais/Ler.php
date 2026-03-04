<?php

class Ler extends Conexao/* A classe Ler é responsável por realizar consultas de leitura no banco de dados. Ela herda da classe Conexao,
que gerencia a conexão com o banco.*/
{

    private $Seleciona;
    private $Locais;
    private $Resultado;
    private $Ler;
    private $Conectar;


    //Essa função monta automaticamente a query SQL no formato: SELECT * FROM {tabela} {condição}
    public function Leitura($BD, $SQL = null, $Adicionais = null)
    {    // Se Adicionais não estiver vazio 
        if (!empty($Adicionais)):
            if (is_array($Adicionais)) { // Verifica se Adicionais é um array
                $this->Locais = $Adicionais; // Se for um array, atribui diretamente a Locais
            } else {
                parse_str($Adicionais, $this->Locais); // Se não for um array, transforma a string em array
            }
        endif;

        // Monta a consulta SQL no formato: SELECT * FROM {tabela} {condição}
        $this->Seleciona = "SELECT * FROM {$BD} {$SQL}";
        $this->Execute();

        /* 
        Sempre vai buscar todas as colunas (*).

        Sempre parte de uma tabela que você informa.

        O $SQL é apenas um complemento (WHERE, ORDER BY, etc.).

        Os parâmetros ($Adicionais) servem para os bindValues.
        */
    }


    public function getResultado()
    {
        return $this->Resultado;
    }


    public function getContaLinhas()
    {
        return $this->Ler->rowCount();
    }


    //Essa função recebe o SQL inteiro já pronto.
    //Você tem liberdade total para escrever a query do jeito que quiser.
    public function LeituraCompleta($Sql, $Adicionais = null)
    {

        $this->Seleciona = $Sql; // Atribui a consulta SQL à variável Seleciona
        if (!empty($Adicionais)): // Se Adicionais não estiver vazio
            if (is_array($Adicionais)) { // Verifica se Adicionais é um array
                $this->Locais = $Adicionais; // Se for um array, atribui diretamente a Locais
            } else {
                parse_str($Adicionais, $this->Locais); // Se não for um array, transforma a string em array
            }
        endif;

        $this->Execute(); // Executa a consulta

        //Aqui a função LeituraCompleta atribui Seleciona diretamente ao SQL que você passar e não a "SELECT * FROM {$BD} {$SQL}" igual Leitura()
        //Você tem total liberdade para escrever a query do jeito que quiser.

        //Exemplo:
        //LeituraCompleta("SELECT u.nome, p.produto FROM usuarios u JOIN pedidos p ON u.id=p.usuario_id WHERE u.id=:id", "id=15")
        //Isso busca o pedido do usuário com id igual a 15
        
        //Nem todas as buscas são tão complexas, você pode fazer buscas mais simples, como:
        //LeituraCompleta("SELECT * FROM produtos WHERE categoria_id=:categoria_id", "categoria_id=2")
    }



    /*
        setLocais($Adicionais)

        Serve para definir novos parâmetros e reexecutar a query já preparada.

        Exemplo:

        $ler->Leitura("produtos", "WHERE id = :id");
        $ler->setLocais("id=20"); // troca o id e executa de novo
         */
    public function setLocais($Adicionais) // Função que define os locais para a consulta (bindValues)
    {
        if (is_array($Adicionais)) { // Verifica se Adicionais é um array
            $this->Locais = $Adicionais; // Se for um array, atribui diretamente a Locais
        } else {
            parse_str($Adicionais, $this->Locais); // Se não for um array, transforma a string em array
        }

        $this->Execute(); // Executa a consulta

    }



    private function Conectar() // Função que estabelece a conexão com o banco de dados
    {

        $this->Conectar = parent::getConectar(); // Obtém a conexão PDO
        $this->Ler = $this->Conectar->prepare($this->Seleciona); // Prepara a consulta SQL e atribui query Seleciona a Ler
        $this->Ler->setFetchMode(PDO::FETCH_ASSOC); // Define o modo de busca como associativo
    }


    private function getSheep()
    {
        
        if ($this->Locais):
            foreach ($this->Locais as $sheep => $ms):// $sheep → é a chave (o nome do parâmetro, tipo "id", "email", "limit")
                if ($sheep == 'limit' || $sheep == 'offset')://$ms → é o valor do parâmetro (tipo 15, "teste@teste.com", 10)
                    $ms = (int) $ms;// Garante que limit e offset sejam valores inteiros
                endif;      //bindValue: Substitui o :param da query pelo valor certo.
                $this->Ler->bindValue(":{$sheep}", $ms, (is_int($ms) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;/*Se for número (int), usa PDO::PARAM_INT, se for string, usa PDO::PARAM_STR. */
        endif;//"id" => 15   → bindValue(":id", 15, PDO::PARAM_INT) "nome" => "Messi" → bindValue(":nome", "Messi", PDO::PARAM_STR)


/*       O que é $this->Locais? 
$this->Locais é o array de parâmetros que você passa na hora de chamar Leitura ou LeituraCompleta.
Pode vir de:
um array direto: ["id" => 15, "ativo" => 1] ou de uma string do tipo query: "id=15&ativo=1" (isso é convertido em array pelo parse_str).

 
 Verificação especial para limit e offset:
   Se o parâmetro for limit ou offset (muito usados em paginação), ele força o valor a ser inteiro.
   Exemplo:
   "limit" => "10"   → bindValue(":limit", 10, PDO::PARAM_INT)
   "offset" => "5"   → bindValue(":offset", 5, PDO::PARAM_INT)


Exemplo prático:

$this->Locais = [
    "id" => 15,
    "email" => "teste@teste.com",
    "limit" => "10"
];

Vai gerar os binds:

:id     → 15          (PDO::PARAM_INT)
:email  → "teste@teste.com" (PDO::PARAM_STR)
:limit  → 10          (forçado para int, PDO::PARAM_INT)

Isso evita problemas de SQL Injection e também garante que o PDO entenda corretamente que o bind é numérico.
*/
    }


    private function Execute()
    {
        $this->Conectar();

        try {
            $this->getSheep();// Faz o bindValue de cada parâmetro da consulta
            $this->Ler->execute();// Executa a consulta
            $this->Resultado = $this->Ler->fetchAll();// Retorna todos os resultados da consulta
        } catch (Exception $ms) {// Captura exceções
            $this->Resultado = null;// Se der erro, atribui null a Resultado
            print "<b>Erro ao ler: {$ms->getMessage()}</b> ";// Imprime a mensagem de erro
        }
    }

    /*
    Execute()

        Chama Conectar().

        Faz os binds (getSheep()).

        Executa a query.  $this->Seleciona = $Sql; ->   $this->Ler = $this->Conectar->prepare($this->Seleciona); - $this->Ler->execute();

        Salva os resultados em $this->Resultado.  $this->Resultado = $this->Ler->fetchAll();

        Se der erro, captura com try/catch e imprime.
     */
}
