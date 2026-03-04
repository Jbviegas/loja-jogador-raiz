<?php

/**********************************************************************
 * ********************************************************************
 * GERENTE DE TAGS E GOOGLE FACEBOOK E OUTROS MAYKONSILVEIRA.COM.BR E MAYKON SILVEIRA
 * 
 * ********************************************************************
 * MAYKONSILVEIRA.COM.BR DEREICIONANDO VOCÊ PARA O CAMINHO DO SUCESSO #*
 * *************MAYKON***SILVEIRA**************************************
 * *************sheep**TECHNOLOGIES***********************************
 * ********************************************************************
 * TUDO AQUI FOI CRIADO NO DIA 28-09-2021 POR MAYKON SILVEIRA EAD 
 * TODOS OS DIREITOS RESERVADOS E CÓDIGO FONTE RASTREADO COM ARQUIVOS 
 * CRIADO POR MAYKONSILVEIRA.COM.BR DESDE 2007 *********
 * TODA SABEDORIA PARA CRIAR ESTES SISTEMAS VEM DO SANTO E ETERNOR PAI
 * O SANTO SENHOR DEUS DE ABRAÃO, ISSAC E JACÓ E DO MEU ÚNICO SENHOR 
 * O MESSIAS NOSSO SALVADOR, POIS A GLROIA É DO PAI E DO FILHO PARA SEMPRE
 * ********************************************************************
 * ********************************************************************
 */
class Google
{

    private $File;
    private $Link;
    private $Data;
    private $Tags = [];

    /* DADOS POVOADOS */
    private $seoTags;
    private $seoData;

    function __construct($File, $Link) // <--- Construtor da classe Google responsável por inicializar os atributos recebidos da classe Link
    {
        $this->File = strip_tags(trim($File)); //<--- Remove tags HTML e espaços em branco do nome do arquivo
        $this->Link = strip_tags(trim($Link)); //<--- Remove tags HTML e espaços em branco do link
    }

    /**
     * <b>Obter MetaTags:</b> Execute este método informando os valores de navegação para que o mesmo obtenha
     * todas as metas como title, description, og, itemgroup, etc.
     * 
     * <b>Deve ser usada com um ECHO dentro da tag HEAD!</b>
     * @return HTML TAGS =  Retorna todas as tags HEAD
     */
    public function getTags()
    {
        $this->checkData();
        return $this->seoTags;
    }

    /**
     * <b>Obter Dados:</b> Este será automaticamente povoado com valores de uma tabela single para arquivos
     * como categoria, artigo, etc. Basta usar um extract para obter as variáveis da tabela!
     * 
     * @return ARRAY = Dados da tabela
     */
    public function getData() //<--- Obter Dados
    {
        $this->checkData(); //<--- Verifica e obtém os dados SEO
        return $this->seoData; //<--- Retorna os dados SEO
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Verifica o resultset povoando os atributos
    private function checkData() // <--- Verifica se os dados já foram obtidos
    {
        if (!$this->seoData): //<--- Se não houver dados SEO
            $this->getSeo(); //<--- Obtém os dados SEO
        endif;
    }


    //Identifica o arquivo e monta o SEO de acordo
    private function getSeo() // Faz a consulta no banco e monta o array Data (com título, descrição, link, imagem).
    {
        $sheep = new Ler; //<--- Instancia a classe Ler

        switch ($this->File): // <--- Verifica o arquivo atual para definir o SEO (ex:indice 0 - ver-produto.php, etc)

                //SEO:: VER PRODUTO
            case 'ver-produto':
                $sheep->Leitura('produto', "WHERE id = :link", "link={$this->Link}"); //Link igual a 15 
                // $sheep->Leitura('produto', "WHERE id = :link", "link=15"); - consulta no banco produto com id = 15

                if (!$sheep->getResultado()): //<--- Se não houver resultado
                    $this->seoData = null; //<--- Limpa os dados SEO
                    $this->seoTags = null; //<--- Limpa as tags SEO
                else:
                    $extract = extract($sheep->getResultado()[0]); //<--- Extrai as variáveis do resultado
                    $this->seoData = $sheep->getResultado()[0]; //Pega as variáveis do resultado
                    /*  $id        = 15;
                        $titulo    = "Camisa Barcelona 24/25";
                        $capa      = "barcelona-2025.jpg";
                        $valor     = 299.90;
                        $descricao = "Camisa oficial do FC Barcelona 24/25";
                        $visitas   = 48;
                    */
                    $this->Data = [$titulo . ' - ' . SITENAME, SITEDESC, HOME . "/ver-produto/{$url}", HOME . "/img-produtos/{$capa}"]; //<--- Monta os dados para a página
                    //Preenche os meta dados da página ver-produto (Title, Content, Link, Image)
                    //$titulo = Camisa Barcelona 24/25 -  SITENAME = Loja Jogador Raiz...
                    /*
                    Array limpo so com os valores que irão preencher os meta dados
                    $this->Data = [
                        "Camisa Barcelona 24/25 - Loja Jogador Raiz",
                        "Camisa oficial do FC Barcelona 24/25",
                        "https://seudominio.com/ver-produto/barcelona-2025",
                        "https://seudominio.com/img-produtos/barcelona-2025.jpg"
                    ];
                    */

                    $contaVisitasSite = ['visitas' => $visitas + 1];
                    $atualizaVisitasSite = new Atualizar();
                    $atualizaVisitasSite->Atualizando('produto', $contaVisitasSite, "WHERE id = :id", "id={$id}");
                endif;
                break;


            //SEO:: VER PRODUTO JOGADOR
            case 'ver-produto-jogador':
                $sheep->Leitura('produto', "WHERE id = :link", "link={$this->Link}");

                if (!$sheep->getResultado()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    $extract = extract($sheep->getResultado()[0]);
                    $this->seoData = $sheep->getResultado()[0];
                    $this->Data = [$titulo . ' - ' . SITENAME, SITEDESC, HOME . "/ver-produto-jogador/{$url}", HOME . "/img-produtos/{$capa}"];

                    $contaVisitasSite = ['visitas' => $visitas + 1];
                    $atualizaVisitasSite = new Atualizar();
                    $atualizaVisitasSite->Atualizando('produto', $contaVisitasSite, "WHERE id = :id", "id={$id}");
                endif;
                break;

            //SEO:: VER PRODUTO Personalizavel
            case 'ver-produto-personalizavel':
                $sheep->Leitura('produto', "WHERE id = :link", "link={$this->Link}");

                if (!$sheep->getResultado()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    $extract = extract($sheep->getResultado()[0]);
                    $this->seoData = $sheep->getResultado()[0];
                    $this->Data = [$titulo . ' - ' . SITENAME, SITEDESC, HOME . "/ver-produto-personalizavel/{$url}", HOME . "/img-produtos/{$capa}"];

                    $contaVisitasSite = ['visitas' => $visitas + 1];
                    $atualizaVisitasSite = new Atualizar();
                    $atualizaVisitasSite->Atualizando('produto', $contaVisitasSite, "WHERE id = :id", "id={$id}");
                endif;
                break;


            //SEO:: VER PRODUTO INFANTIL
            case 'ver-produto-infantil':
                $sheep->Leitura('produto', "WHERE id = :link", "link={$this->Link}");

                if (!$sheep->getResultado()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    $extract = extract($sheep->getResultado()[0]);
                    $this->seoData = $sheep->getResultado()[0];
                    $this->Data = [$titulo . ' - ' . SITENAME, SITEDESC, HOME . "/ver-produto-infantil/{$url}", HOME . "/img-produtos/{$capa}"];

                    $contaVisitasSite = ['visitas' => $visitas + 1];
                    $atualizaVisitasSite = new Atualizar();
                    $atualizaVisitasSite->Atualizando('produto', $contaVisitasSite, "WHERE id = :id", "id={$id}");
                endif;
                break;


            //SEO:: VER PRODUTO FEMININO
            case 'ver-produto-feminino':
                $sheep->Leitura('produto', "WHERE id = :link", "link={$this->Link}");

                if (!$sheep->getResultado()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    $extract = extract($sheep->getResultado()[0]);
                    $this->seoData = $sheep->getResultado()[0];
                    $this->Data = [$titulo . ' - ' . SITENAME, SITEDESC, HOME . "/ver-produto-feminino/{$url}", HOME . "/img-produtos/{$capa}"];

                    $contaVisitasSite = ['visitas' => $visitas + 1];
                    $atualizaVisitasSite = new Atualizar();
                    $atualizaVisitasSite->Atualizando('produto', $contaVisitasSite, "WHERE id = :id", "id={$id}");
                endif;
                break;


            //SEO:: VER PRODUTO TREINO INVERNO
            case 'ver-produto-treino-inverno':
                $sheep->Leitura('produto', "WHERE id = :link", "link={$this->Link}");

                if (!$sheep->getResultado()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    $extract = extract($sheep->getResultado()[0]);
                    $this->seoData = $sheep->getResultado()[0];
                    $this->Data = [$titulo . ' - ' . SITENAME, SITEDESC, HOME . "/ver-produto-treino-inverno/{$url}", HOME . "/img-produtos/{$capa}"];

                    $contaVisitasSite = ['visitas' => $visitas + 1];
                    $atualizaVisitasSite = new Atualizar();
                    $atualizaVisitasSite->Atualizando('produto', $contaVisitasSite, "WHERE id = :id", "id={$id}");
                endif;
                break;


            //SEO:: VER  PRODUTO NBA
            case 'ver-produto-nba':
                $sheep->Leitura('produto', "WHERE id = :link", "link={$this->Link}");

                if (!$sheep->getResultado()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    $extract = extract($sheep->getResultado()[0]);
                    $this->seoData = $sheep->getResultado()[0];
                    $this->Data = [$titulo . ' - ' . SITENAME, SITEDESC, HOME . "/ver-produto-nba/{$url}", HOME . "/img-produtos/{$capa}"];

                    $contaVisitasSite = ['visitas' => $visitas + 1];
                    $atualizaVisitasSite = new Atualizar();
                    $atualizaVisitasSite->Atualizando('produto', $contaVisitasSite, "WHERE id = :id", "id={$id}");
                endif;
                break;


            //SEO:: VER RETRÔ
            case 'ver-produto-retro':
                $sheep->Leitura('produto', "WHERE id = :link", "link={$this->Link}");

                if (!$sheep->getResultado()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    $extract = extract($sheep->getResultado()[0]);
                    $this->seoData = $sheep->getResultado()[0];
                    $this->Data = [$titulo . ' - ' . SITENAME, SITEDESC, HOME . "/ver-produto-retro/{$url}", HOME . "/img-produtos/{$capa}"];

                    $contaVisitasSite = ['visitas' => $visitas + 1];
                    $atualizaVisitasSite = new Atualizar();
                    $atualizaVisitasSite->Atualizando('produto', $contaVisitasSite, "WHERE id = :id", "id={$id}");
                endif;
                break;


            //SEO:: CATEGORIAS DO SITE 
            case 'categorias':
                $sheep->Leitura('categorias', "WHERE id = :link", "link={$this->Link}"); //Link igual a 1
                // $sheep->Leitura('categorias', "WHERE id = :link", "link=1");

                if (!$sheep->getResultado()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    $extract = extract($sheep->getResultado()[0]);
                    $this->seoData = $sheep->getResultado()[0];
                    $this->Data = [$nome . ' - ' . SITENAME, SITEDESC, HOME . "/categorias/{$url}", HOME . SHEEP_IMG_LOGO];

                    $contaVisitasSite = ['visitas' => ((int) $visitas) + 1];
                    $atualizaVisitasSite = new Atualizar();
                    $atualizaVisitasSite->Atualizando('categorias', $contaVisitasSite, "WHERE id = :id", "id={$id}");
                endif;
                break;


            //SEO:: PRODUTOS
            case 'produtos':
                $this->Data = ['Produtos da Loja' . ' - ' . SITENAME, SITEDESC, HOME, CAMINHO_TEMAS, SHEEP_IMG_LOGO];
                break;

            //SEO:: CARRINHO
            case 'carrinho':
                $this->Data = ['Carrinho de Compras' . ' - ' . SITENAME, SITEDESC, HOME, CAMINHO_TEMAS, SHEEP_IMG_LOGO];
                break;// Carrinho de Compras - Loja Jogador Raiz - Loja de Artigos Esportivos - "https://localhost/loja-finalizada"...
                      //Preenche os meta dados da página do carrinho (Title, Content, Link, Image)

            //SEO:: FAVORITOS
            case 'favoritos':
                $this->Data = ['Produtos Favoritos' . ' - ' . SITENAME, SITEDESC, HOME, CAMINHO_TEMAS, SHEEP_IMG_LOGO];
                break;


            //SEO:: INDEX
            case 'index':
                //$this->Data = [GOOGLE_TITULO . ' - '.GOOGLE_DESC, GOOGLE_TAGS, HOME, CAMINHO_TEMAS . SHEEP_IMG_LOGO];
                $this->Data = [SITENAME . '', SITEDESC, HOME, SHEEP_IMG_URL];


                //SEO:: 404
            default:
                $this->Data = [SITENAME . '', SITEDESC, HOME . '/404', CAMINHO_TEMAS  . SHEEP_IMG_LOGO];

        endswitch;

        if ($this->Data):
            $this->setTags();
        endif;
    }

    //Monta e limpa as tags para alimentar as tags
    private function setTags()
    {
        $this->Tags['Title'] = $this->Data[0];
        $this->Tags['Content'] = Formata::LimitaTextos(html_entity_decode($this->Data[1]), 45);
        $this->Tags['Link'] = $this->Data[2];
        $this->Tags['Image'] = $this->Data[3];


        $this->Tags = array_map('trim', $this->Tags); //Tags → array com os valores crus (Title, Content, Link, Image).

        $this->Data = null;

        //seoTags → string final com todo o HTML de SEO.

        // NORMAL PAGE
        $url = $this->Tags['Link'] ?? HOME; // Garante que sempre haja uma URL válida
        if ($url === HOME . '/404') {
            // Caso seja realmente 404, deixa como está
            $canonical = $url;
            $ogUrl     = $url;
            $itemUrl   = $url;
        } else {
            // Para páginas válidas, usamos a URL real
            $canonical = $url;
            $ogUrl     = $url;
            $itemUrl   = $url;
        }

        $this->seoTags = '<title>' . $this->Tags['Title'] . '</title>' . "\n";// Titulo - Loja Jogador Raiz
        $this->seoTags .= '<meta name="description" content="' . $this->Tags['Content'] . '"/>' . "\n";// Descrição - Loja de Artigos Esportivos
        $this->seoTags .= '<meta name="keywords" content="' . GOOGLE_DESC . '" />' . "\n";
        $this->seoTags .= '<meta name="robots" content="index, follow" />' . "\n";
        $this->seoTags .= '<meta name="url" content="' . HOME . '" />' . "\n";
        $this->seoTags .= '<meta name="author" content="Webtec Technologies" />' . "\n";
        $this->seoTags .= '<meta name="company" content="' . SITENAME . '" />' . "\n";
        $this->seoTags .= '<meta name="revisit-after" content="1 week" />' . "\n";
        $this->seoTags .= '<meta name="reply-to" content="mailto:' . EMAIL . '" />' . "\n";
        $this->seoTags .= '<meta name="copyright" content="' . RODAPE . date("Y") . '" />' . "\n";
        $this->seoTags .= '<meta name="made" content="mailto:contato@webtecpr.com.br" />' . "\n";
        $this->seoTags .= '<meta name="google-site-verification" content="' . GOOGLE_VERIFY . '" />' . "\n";
        $this->seoTags .= '<link rel="canonical" href="' . $canonical . '">' . "\n";

        // FACEBOOK / OG
        $this->seoTags .= '<meta property="og:site_name" content="' . SITENAME . '" />' . "\n";
        $this->seoTags .= '<meta property="og:locale" content="pt_BR" />' . "\n";
        $this->seoTags .= '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";
        $this->seoTags .= '<meta http-equiv="content-type" content="text/html; charset=utf-8">' . "\n";
        $this->seoTags .= '<meta property="og:title" content="' . $this->Tags['Title'] . '" />' . "\n";
        $this->seoTags .= '<meta property="og:description" content="' . $this->Tags['Content'] . '" />' . "\n";
        $this->seoTags .= '<meta property="og:image" content="' . $this->Tags['Image'] . '" />' . "\n";
        $this->seoTags .= '<meta property="og:image:width" content="600" />' . "\n";
        $this->seoTags .= '<meta property="og:image:height" content="600" />' . "\n";
        $this->seoTags .= '<meta property="og:url" content="' . $ogUrl . '" />' . "\n";
        $this->seoTags .= '<meta property="fb:app_id" content="' . $ogUrl . '" />' . "\n";
        $this->seoTags .= '<meta property="article:author" content="' . $ogUrl . '" />' . "\n";
        $this->seoTags .= '<meta property="article:publisher" content="' . $ogUrl . '" />' . "\n";
        $this->seoTags .= '<meta name="author" content="' . SHEEP_IMG . '">' . "\n";
        $this->seoTags .= '<meta property="og:type" content="article" />' . "\n";

        // ITEMPROP (TWITTER / Rich Snippets)
        $this->seoTags .= '<meta itemprop="name" content="' . $this->Tags['Title'] . '">' . "\n";
        $this->seoTags .= '<meta itemprop="description" content="' . $this->Tags['Content'] . '">' . "\n";
        $this->seoTags .= '<meta itemprop="url" content="' . $itemUrl . '">' . "\n";

        $this->Tags = null;
    }
}
