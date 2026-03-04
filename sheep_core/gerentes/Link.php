<?php

/**
 * Link [ MODEL ]
 * Classe responsável por organizar o SEO do sistema e realizar a navegação!
 */
class Link
{

    private $File;// Armazena o nome do arquivo a ser carregado
    private $Link;// Armazena o link a ser carregado

    /** DATA */
    private $Local;// Armazena a URL dividida em índices
    private $Patch;// Caminho do arquivo a ser carregado
    private $Tags;// Armazena as meta tags do Google
    private $Data;// Armazena os dados de SEO (título, descrição, imagem, etc)

    /** CLASSE Google */
    private $Google;// Instância da classe Google

    function __construct()
    {
        $this->Local = strip_tags(trim(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))); //Pega a url do link em Home ou nas categorias
        $this->Local = ($this->Local ? $this->Local : 'index'); // Se não houver url, define como index(página inicial)
        $this->Local = explode('/', $this->Local)?:'index'; // Separa a url em índices (ex: ver-produto/15 = [0]=>ver-produto e [1]=>15)
        $this->File = (isset($this->Local[0]) ? $this->Local[0] : 'index'); //Define o arquivo a ser carregado(ex:indice 0 - ver-produto.php, etc)
        $this->Link = (isset($this->Local[1]) ? $this->Local[1] : null); // Define o link a ser carregado(ex: indice 1 - link com id = 15)
        /*
        Define os parâmetros para a classe Google
        $this->Local = ['ver-produto', '15', 'camisa-do-barcelona'];
        $this->File  = 'ver-produto';
        $this->Link  = '15';

        */

        $this->Google = new Google($this->File, $this->Link);
        // Instancia a classe Google com os parâmetros definidos, manda o link com id = 15(ver-produto/15) para o construtor da classe Google
    }

    public function getTags()
    {
        $this->Tags = $this->Google->getTags();
        echo $this->Tags;
    } //            Pega os dados para as meta tags
    /*
                    $this->Data = [
                        "Camisa Barcelona 24/25 - Loja Jogador Raiz",
                        "Camisa oficial do FC Barcelona 24/25",
                        "https://seudominio.com/ver-produto/barcelona-2025",
                        "https://seudominio.com/img-produtos/barcelona-2025.jpg"
                    ];
                    // Exemplo de array Data com título, descrição, link e imagem.
                    $this->Data = [
                        "Camisa Barcelona 24/25 - Loja Jogador Raiz",
                        "Camisa oficial do FC Barcelona 24/25",
                        "https://seudominio.com/ver-produto/barcelona-2025",
                        "https://seudominio.com/img-produtos/barcelona-2025.jpg"
                    ];

        Exemplos de meta tags:
        $this->seoTags = '<title>' . $this->Tags['Title'] . '</title> ' . "\n";
        $this->seoTags .= '<meta name="description" content="' . $this->Tags['Content'] . '"/>' . "\n";

        Elas vão todas para o head através de <?php
   
<?php
   $sheep = new Ler();

   $Link = new Link;
   $Link->getTags();

   ?>

    */

    public function getData()
    {
        $this->Data = $this->Google->getData();
        return $this->Data;
    } //Pega as variáveis com o resultado de SEO (ex: $id, $titulo, $capa, $valor, $descricao, $visitas) - (BD:: 'produtos' - ver-produto/15)
    /*      $id = 15;
            $titulo = "Camisa Barcelona 24/25";
            $capa   = "barcelona-2025.jpg";
            $valor  =  299.90;
            $descricao = "Camisa oficial do FC Barcelona 24/25";
            $visitas   = 48;           
    */

    public function getLocal()
    {
        return $this->Local;
    }

    //getPatch() -> É o método que você usa para saber qual arquivo PHP deve ser incluído/renderizado baseado na URL.
    public function getPatch()//Primeiro chama o método privado setPatch() (que decide qual arquivo deve ser carregado).
    {
        $this->setPatch();
        return $this->Patch;//Depois Retorna o caminho do arquivo a ser carregado.
    }

    //Decide qual arquivo físico do sistema será carregado, baseado em $File e $Link (que vieram da URL).
    private function setPatch()//<-- Este método decide qual arquivo deve ser carregado com base na estrutura de pastas.
    {
        //MODELO = 'sheep_temas' . '/' . SHEEP_LAYOUT ->    SHEEP_LAYOUT = 'site' ->     Resultado: sheep_temas/site
        //File = 'ver-produto'
        //Link = '15'


        if (file_exists(MODELO . '/' . $this->File . '.php'))://Se existir um arquivo com o nome do primeiro trecho da URL ($File), ele usa esse
            //if (file_exists(MODELO . '/ver-produto.php'))
            $this->Patch = MODELO . '/' . $this->File . '.php';
            //Se existir esse arquivo sheep-temas/site/ver-produto.php, carrega ele

        elseif (file_exists(MODELO . '/' . $this->File . '/' . $this->Link . '.php'))://Se não tenta
            //if (file_exists(MODELO . '/ver-produto/15.php'))
            $this->Patch = MODELO . '/' . $this->File . '/' . $this->Link . '.php';
            //Se existir esse arquivo sheep-temas/site/ver-produto/15.php, carrega ele 
        else:
            $this->Patch = MODELO . '/' . '404.php';//Se não existir nenhum dos arquivos, carrega o 404(Erro)
        endif;
    }
}
