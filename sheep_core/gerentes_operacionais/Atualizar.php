<?php

/***********************************************************************************************************************
 * *********************************************************************************************************************
 * GERENTE DE ATUALIZAÇÃO GERAL
 *
 * *********************************************************************************************************************
 ***********************************************************************************************************************/
class Atualizar extends Conexao
{

    private $Tabela;
    private $Termos;
    private $Dados;
    private $Locais;
    private $Resultado;


    /*    @var PDOStantement  */
    private $Atualizar;

    /*    @var PDO  */
    private $Conexao;

    // Método principal de atualização
    public function Atualizando($Banco, array $Dados, $SQL, $Adicionais)
    {
        $this->Tabela = (string) $Banco;
        // $Banco é o nome da tabela no banco de dados
        $this->Dados = $Dados;
        /* $Dados
        São os valores do SET (ex: ["nome" => "Maria"]). */
        $this->Termos = (string) $SQL;
        /*  $this->Termos - Sempre é texto SQL (ex: "WHERE id = :id LIMIT :limit").
        Ele define a cláusula WHERE, ORDER, LIMIT, OFFSET… mas apenas o texto da query.
        Termos é preenchido pelos adicionais */

        /* $Adicionais
        Sempre é valores no formato query string (ex: "id=5&limit=1").
        Ele vira array ["id" => 5, "limit" => 1] e serve só para preencher os placeholders usados dentro de $Termos.*/

        // parse_str Converte query string (id=5&limit=1) em array associativo ["id" => 5, "limit" => 1]
        parse_str($Adicionais, $this->Locais);

        $this->getSyntax();
        $this->Execute();

        /*
        $dados = ["nome" => "Maria"];
        $termos = "WHERE id = :id LIMIT :limit"; // TEXTO da query
        $adicionais = "id=5&limit=1";             // VALORES para o bind

        Query gerada:
        UPDATE clientes SET nome = :set_nome WHERE id = :id LIMIT :limit

        Parâmetros enviados:
        [
        ":set_nome" => "Maria",  // vem de $Dados
        ":id"       => 5,        // vem de $Adicionais, mas é usado no WHERE
        ":limit"    => 1         // vem de $Adicionais, mas é usado no LIMIT
        ]

        */
    }

    // Retorna resultado do update (true, null em caso de erro)
    public function getResultado()
    {
        return $this->Resultado;
    }

    // Retorna quantas linhas foram afetadas
    public function getContaLinhas()
    {
        return $this->Atualizar->rowCount();
    }


    /*
        Atualiza apenas os parâmetros extras (WHERE, LIMIT, OFFSET etc.)
     */
    public function setLocais($Adicionais)
    {
        parse_str($Adicionais, $this->Locais);
        $this->getSyntax();
        $this->Execute();

        /*
        Serve para definir novos parâmetros e reexecutar a query já preparada.
        */
    }


    /** @var gera a syntax do mysql dinamicamente */
    private function getSyntax()
    {
        $Campos = []; // array para armazenar os pares campo = :campo

        foreach ($this->Dados as $key => $value):
            /* Prefixo set_ evita conflito de placeholders(Ex: variaveis com mesma chave idade= 40 - idade= 18)com p prefixo set_
            corre risco de setar o errado */
            $Campos[] = $key . ' = :set_' . $key;
        endforeach;

        $Campos = implode(', ', $Campos);
        // implode transforma o array em uma string separada por vírgulas

        // Query final
        $this->Atualizar = "UPDATE {$this->Tabela} SET {$Campos} {$this->Termos}"; //Campos é a string que contém os Campos a serem atualizados
        //Termos é a condição que limita a atualização (WHERE id = :id)

        // Exemplo gerado:
        // UPDATE tabela SET nome = :nome, email = :email WHERE id = :id
    }


    /**
     * Faz a conexão com o banco
     */
    private function Preparar()
    {
        $this->Conexao = parent::getConectar(); //É a função que pega a função(Conectar()) com o método de conexão PDO com o banco de dados
        $this->Atualizar = $this->Conexao->prepare($this->Atualizar); //Atualizar é a instrução SQL preparada que será executada
    }



    /**
     * Executa a query preparada
     */
    private function Execute()
    {
        $this->Preparar(); //Função de conexão

        try {
            // Prepara binds do SET
            $bindSet = [];
            foreach ($this->Dados as $key => $value) {
                $bindSet['set_' . $key] = $value;
            }
            // Une os binds do SET ($Dados) com os valores extras ($Adicionais)que servem para preencher os placeholders do $Termos(:id, :limit, :offset).

            // [($Dados":set_nome" => "Maria",) + ($Adicionais":id" => 5, ":limit" => 1 ":offset" => 3)];

            //$Termos é preenchido pelos adicionais ("WHERE id = :id  LIMIT :limit"  OFFSET :offset) => ("WHERE id => 5 LIMIT=> 1  OFFSET=> 3")

            $parametros = array_merge($bindSet, $this->Locais); //array_merge une os arrays[($Dados) + ($Adicionais)]-($bindSet, $this->Locais)

            $this->Atualizar->execute($parametros); /*Executa a query("UPDATE {$this->Tabela} SET {$Campos} {$this->Termos}";) com os
            parâmetros que foram unidos integrados nela*/
            $this->Resultado = true;    // Se tudo der certo, retorna true
        } catch (Exception $wt) {   // Captura exceções
            $this->Resultado = null;  // Se der erro, retorna null
            echo "<b>Erro ao Atualizar: {$wt->getMessage()}</b> - Código: {$wt->getCode()}"; // Exibe mensagem de erro
        }
    }
}
