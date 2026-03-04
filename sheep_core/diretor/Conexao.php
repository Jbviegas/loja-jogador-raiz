<?php

class Conexao
{


    private static $host = SHEEP_HOST;
    private static $user = SHEEP_USER;
    private static $password = SHEEP_SENHA;
    private static $dbName = SHEEP_BD;
    private static $dbType = SHEEP_TIPO_BANCO; // Exemplo: 'mysql', 'pgsql', 'sqlite'

    /** @var PDO */
    private static $Conectar = null;

    /**
     * Estabelece uma conexão com o banco de dados usando o padrão singleton.
     * Retorna um objeto PDO.
     */
    private static function Conectar()
    {
        if (self::$Conectar === null) {
            try {
                $dsn = self::getDsn();


                //  Aqui você está instanciando a classe PDO, que é a API de conexão genérica do PHP para vários bancos de dados.
                self::$Conectar = new PDO($dsn, self::$user, self::$password, [
                    // Configurações adicionais do PDO
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Define o modo de erro do PDO para Exceção
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Define o modo de busca do PDO para Associativo
                ]);

                if (self::$dbType === 'mysql') { // Se o tipo de banco de dados for MySQL
                    self::$Conectar->exec("SET NAMES 'UTF8'"); // Define o conjunto de caracteres para UTF-8
                }
            } catch (PDOException $e) {
                // Em um ambiente real, não exponha os detalhes do erro. Logar o erro seria uma abordagem melhor.
                die('Connection Error: ' . $e->getMessage());
            }
        }

        return self::$Conectar;
    }

    /**
     * Retorna um DSN baseado no tipo de banco de dados configurado.
     */
    private static function getDsn()
    {
        switch (self::$dbType) {
            case 'mysql':
                return 'mysql:host=' . self::$host . ';port=' . SHEEP_PORT . ';dbname=' . self::$dbName . ';charset=utf8';
            case 'pgsql':
                return 'pgsql:host=' . self::$host . ';port=5432;dbname=' . self::$dbName . ';user=' . self::$user . ';password=' . self::$password;
            case 'sqlite':
                return 'sqlite:' . self::$dbName; // Aqui, dbName seria o caminho para o arquivo do SQLite
            default:
                throw new Exception('Tipo de banco de dados não suportado: ' . self::$dbType);
        }
    }

    /**
     * getConectar() Retorna um objeto PDO usando o padrão singleton.
     */
    public static function getConectar() //função que pega a conexão com o banco de dados
    {
        return self::Conectar(); //Função que contém o método de conexão com o banco de dados
    }
}

// As constantes DB_HOST, DB_USER, etc., devem ser definidas em outro lugar no seu código, 
// provavelmente em um arquivo de configuração.
