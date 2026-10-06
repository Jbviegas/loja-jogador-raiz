<?php

/***********************************************************************************************************************
 * *********************************************************************************************************************
 * GERENTE DE EXCLUSÃO GERAL
 *
 * *********************************************************************************************************************
 ***********************************************************************************************************************/

class Excluir extends Conexao
{

    private $Banco;
    private $SQL;
    private $Locais;
    private $Resultado;
    private $Excluir;
    private $Conexao;


    public function Remover($Banco, $SQL, $Adicionais = null)
    {
        $this->Banco = (string) $Banco;
        $this->SQL = (string) $SQL;

        parse_str($Adicionais, $this->Locais); // transforma a string de adicionais em um array associativo
        //As strings de adicionais são transformadas em chaves e valores no array associativo
        // Exemplo: "id=1&nome=teste" se torna array("id" => 1, "nome" => "teste") no array associativo Locais
        //Então Locais será executado na função Execute() e irá preencher os campos da query SQL que está em "Excluir"

        $this->getSyntax(); // gera a syntax do mysql automaticamente
        $this->Execute(); // executa a query

    }

    /** @var Retorna um Resultadoado de cadastro ou não :: por Maykon Silveira - MaykonSilveira.com.br */
    public function getResultado()
    {
        return $this->Resultado;
    }

    /** @var FAZ A CONTAGEM DOS CAMPOS DA TABLEA :: por Maykon Silveira - MaykonSilveira.com.br */
    public function getContaLinhas()
    {
        return $this->Excluir->rowCount();
    }


    public function setLocais($Adicionais)
    {
        parse_str($Adicionais, $this->Locais); // transforma a string de adicionais em um array associativo
        $this->getSyntax(); // gera a syntax do mysql automaticamente
        $this->Execute(); // executa a query

        /*
        Serve para definir novos parâmetros e reexecutar a query já preparada.
        */
    }

    /**
     *
     * **************** PRIVATE METHODS ****************
     * **********************************
     */

    /** @var Faz a coneção com banco de dados por */
    private function Preparar()
    {

        $this->Conexao = parent::getConectar();
        $this->Excluir = $this->Conexao->prepare($this->Excluir);
    }

    /** @var gera a syntax do mysql automaticamente por Maykon Silveira */
    private function getSyntax()
    {
        $this->Excluir = "DELETE FROM {$this->Banco} {$this->SQL}"; //Excluir é a query de exclusão

    }

    /** @var Executa o PDO  por Maykon Silveira */
    private function Execute()
    {
        $this->Preparar();

        try {
            $this->Excluir->execute($this->Locais); // Locais é um array associativo que preenche os parâmetros da query SQL
            //Execute executa Locais que tem o valor a ser excluido que irá preencher os campos da query SQL
            $this->Resultado = true; // indica que a exclusão foi bem-sucedida
        } catch (Exception $wt) { // captura exceções
            $this->Resultado = null; // indica que a exclusão falhou
            print "<b>Erro ao Deletar: {$wt->getMessage()}</b> - {$wt->getCode()}"; // exibe mensagem de erro
        }
    }
}
