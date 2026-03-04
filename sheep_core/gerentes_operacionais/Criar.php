<?php

/**********************************************************************
 * ********************************************************************
 * GERENTE DE CRIAÇÃO GERAL MAYKONSILVEIRA.COM.BR E MAYKON SILVEIRA
 * 
 * ********************************************************************
 * MAYKONSILVEIRA.COM.BR DEREICIONANDO VOCÊ PARA O CAMINHO DO SUCESSO #*
 * *************MAYKON***SILVEIRA**************************************
 * *************sheep**PHP***********************************
 * ********************************************************************
 * TUDO AQUI FOI CRIADO NO DIA 01-10-2021 POR MAYKON SILVEIRA
 * TODOS OS DIREITOS RESERVADOS E CÓDIGO FONTE RASTREADO COM ARQUIVOS 
 * CRIADO POR MAYKONSILVEIRA.COM.BR DESDE 2007 *********
 * TODA SABEDORIA PARA CRIAR ESTES SISTEMAS VEM DO SANTO E ETERNOR PAI
 * O SANTO SENHOR DEUS DE ABRAÃO, ISSAC E JACÓ E DO MEU ÚNICO SENHOR 
 * O MESSIAS NOSSO SALVADOR, POIS A GLÓRIA É DO PAI E DO FILHO PARA SEMPRE
 * ********************************************************************
 */
class Criar extends Conexao
{

    private $Tabela;
    private $Dados;
    private $Resultado;
    private $Criar;
    private $Conexao;

    /**
     * <b>ExeCriar</b> Executa um cadastro simplificado no banco de dados com prepared statements
     * Basta informar o nome da tabela e um array atribuitivo com o nome da coluna e valor.
     * @param STRING $Tabela INFORME O NOME DA TABELA
     * @param ARRAY  $Dados INFORME UM ARRAY ATRIBUITIVO ( 'NOME DA COLUNA' => 'VALOR' )
     * 
     * NÃO ACEITAMOS PIRATARIA É CRIME 
     * <b>Webtecpr.com.br</b>
     * CONTATO: (41) 3088-4418
     * <b>por Maykon Silveira</b>
     *  <b>Este código poderá ser rastreado!</b>
     *
     *  */


    // Função com o método responsável por criar um registro no banco de dados, insere os dados nas tabelas do banco de dados
    public function Criacao($Tabela, array $Dados)
    {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;


        $this->getLogica();
        $this->Execute();
    }

    /** @var Retorna um resultado de cadastro ou não */

    public function getResultado()
    {
        return $this->Resultado;
    }

    
    /** @var Faz a conexão com banco de dados*/
    private function Conectar()
    {
        $this->Conexao = parent::getConectar();//É a função que pega a função(Conectar()) com o método de conexão PDO com o banco de dados
        $this->Criar = $this->Conexao->prepare($this->Criar);
    }

    /** @var gera a syntax da query de forma automática */
    private function getLogica()
    {
        // Pega as chaves do array $this->Dados (que seriam os nomes das colunas da tabela)
        $Fileds = implode(', ', array_keys($this->Dados));// array_keys($this->Dados) - Retorna -> Nomes das colunas Ex: [id, nome, email]
        //$Fileds = implode(', ', array_keys($this->Dados)); -Isso transforma o array em uma string separada por vírgula: "nome, email, idade"

        $Places = ':' . implode(', :', array_keys($this->Dados));//Faz o mesmo, mas colocando : antes de cada nome de coluna(para ser usado como placeholder do PDO):
        // Ex: ":id, :nome, :email"

        //Com isso, a query final fica:
        $this->Criar = "INSERT IGNORE INTO {$this->Tabela} ({$Fileds}) VALUES ({$Places})";
        //INSERT IGNORE INTO tabela (nome, email, idade) VALUES (:nome, :email, :idade)

    }

    /** @var Executa o PDO */
    private function Execute()
    {
        $this->Conectar();//Conecta com o banco de dados

        try {
            $this->Criar->execute($this->Dados);//Query com os placeholders que executa os dados
            $this->Resultado = $this->Conexao->lastInsertId();//Retorna o ID do último registro inserido
        } catch (Exception $wt) {//Caso não retorne um último registro de id é porque houve erro e não houve registro
            $this->Resultado = null;//Se houver erro, armazena null e mostra a mensagem
            print "<b>Erro ao cadastrar: {$wt->getMessage()} {$wt->getCode()}</b> ";
        }
    }
}
