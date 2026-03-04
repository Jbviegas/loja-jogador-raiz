<?php
/**
 * Arquivo de inclusão geral do sistema.
 * Ele é responsável por carregar as configurações, classes e conexões necessárias para o funcionamento do sistema.
 */

//PASTA GERAL DE IMAGENS E ARQUIVOS CAMINHO DO PAINEL A MODELOS######################
define('SHEEP_IMG', './sheep-imagens/');
//CAMINHO PASTA IMAGEM PARA TEMAS 
define('SHEEP_IMG_URL', '/sheep_painel/sheep-imagens/');

//PASTA GERAL DE USUARIOS 
define('SHEEP_IMG_USUARIOS', '../uploads/fotos-usuarios/');

define('SHEEP_IMG_LOGOMARCA', '../uploads/img-logo/');

define('SHEEP_IMG_BANNERS', '../uploads/img-banners/');

define('SHEEP_IMG_PRODUTOS', '../uploads/img-produtos/');

define('SHEEP_IMG_LOGO', '../../../sheep_temas/sheep-imagens-logo/');

//IMAGENS PARA O LAYUT EXTERNO GERAL DE IMAGENS E ARQUIVOS CAMINHO DO PAINEL A MODELOS######################
define('SHEEP_IMG_PAINEL', './sheep_temas/sheep-imagens/');

//PASTA GERAL DE vídeos CAMINHO DO PAINEL A MODELOS######################
define('SHEEP_AUDIO', '../../../sheep_temas/sheep-midias/');

//AQUI IREI ADICIONAR VERSÃO E MODELO######################
define('SHEEP_VERSAO', 'Versão: [ 3.0.0 ] - <b>Atualizado dia: 13/11/2023</b>');

//AQUI TEXTO DA VERSÃO VERSÃO E MODELO######################
define('busca', '<center><h2>Atenção!</h2></center><br>'
    . 'Este código de fonte é registrado e todos os direitos são reservados a empresa:<br> '
    . '<b>Maycon Silveira</b><br>'
    . '<p>Framework maykonsilveira.com.br e o código de fonte são patenteados. </p>');

/**********************************************************************
 * ********************************************************************
 *
 * 
 * ********************************************************************
 * ********************************************************************
 */

//Essa função serve para carregar automaticamente classes PHP de dentro dos diretórios diretor, funcionarios, gerentes_operacionais e gerentes
/*Ela é chamada toda vez que você tenta usar uma classe que ainda não foi definida ou incluída, e ela tenta localizar o arquivo correspondente 
à classe dentro desses diretórios e inclui-lo.*/
//Ela é uma forma de organizar o código e evitar ter que incluir manualmente cada arquivo de classe que você precisa usar.
function sheep_classes($sheepClasses)

{

    $sheepDiretorio = ['diretor', 'funcionarios',  'gerentes_operacionais', 'gerentes'];
    //Esses são os diretórios dentro da pasta atual (__DIR__) onde o sistema vai procurar o arquivo da classe.
    $sheepFiscaliza = null;

    foreach ($sheepDiretorio as $sheepNomeDiretorio):
        if (
            !$sheepFiscaliza
            && file_exists(__DIR__ . '/' . $sheepNomeDiretorio . '/' . $sheepClasses . '.php') //Verifica se existe um diretório
            && !is_dir(__DIR__ . '/' . $sheepNomeDiretorio . '/' . $sheepClasses . '.php') //Verifica se não é um diretório
        ):
            include_once(__DIR__ . '/' . $sheepNomeDiretorio . '/' . $sheepClasses . '.php'); //Inclui o arquivo da classe(ou seja, carrega a definição da classe) 
            $sheepFiscaliza = true; //Define que o arquivo foi encontrado e incluído
        endif;
    endforeach;


    if (!$sheepFiscaliza): //Se não achou em nenhum dos diretórios, exibe erro e encerra a execução do script
        echo "Não foi possível incluir {$sheepClasses}.php";
        exit();
    endif;
}

spl_autoload_register("sheep_classes");
//Diz ao PHP:
/*"Quando alguém tenta usar uma classe que ainda não foi carregada,
chame a função sheep_classes para tentar localizar e incluir o arquivo correspondente." */



/**********************************************************************
 * ********************************************************************
 * DADOS DO SITE 
 * 
 * 
 * ********************************************************************
 */
$lerConfig = new Ler();
$lerConfig->Leitura('dados', "WHERE id = '57101'");
if ($lerConfig->getResultado()) {
    foreach ($lerConfig->getResultado() as $config);
    $config = (object) $config;
}


$lerConfig->Leitura('app_estados', "WHERE estado_id  = :idEstado", "idEstado={$config->estado}");
$estadoConfig = Formata::Resultado($lerConfig);
if ($estadoConfig) {
    foreach ($lerConfig->getResultado() as $estado);
    $estado = (object) $estado;
}

$lerConfig->Leitura('app_cidades', "WHERE cidade_id  = :idCidade", "idCidade={$config->cidade}");
$cidadeConfig = Formata::Resultado($lerConfig);
if ($cidadeConfig) {
    foreach ($lerConfig->getResultado() as $cidade);
    $cidade = (object) $cidade;
}

define('SITENAME',  $config->nome ? $config->nome : null);
define('SITEDESC', $config->descricao ? $config->descricao : null);
define('LOGO_HOME', $config->logo ? $config->logo : null);
define('LOGO_ICONE', $config->icone ? $config->icone : null);
define('FONE', $config->fone ? $config->fone : null);
define('CNPJ', $config->cnpj ? $config->cnpj : null);
define('CELULAR', $config->whatsapp ? $config->whatsapp : null);
define('EMAIL', $config->email ? $config->email : null);
define('SENHA_EMAIL', $config->senha_email ? $config->senha_email : null);
define('ENDERECO', $config->endereco ? $config->endereco : null);
define('NUMERO', $config->numero ? $config->numero : null);
define('CEP', $config->cep ? $config->cep : null);
define('CIDADE', $cidade->cidade_nome);
define('ESTADO', $estado->estado_nome);
define('CORREIOS_TOKEN', $config->token_correios ? $config->token_correios : null);




/**********************************************************************
 * ********************************************************************
 * PHPMAILER E SEND GRIND 
 *
 * 
 * ********************************************************************
 */



define('EMAIL_PHPMAILER_SECURE', 'tls');
define('EMAIL_PHPMAILER_CHARSET', 'utf-8');
define('EMAIL_PHPMAILER_HOST', 'smtp-pulse.com');
define('EMAIL_PHPMAILER_USERNAME', EMAIL);
define('EMAIL_PHPMAILER_PASS', SENHA_EMAIL);
define('EMAIL_PHPMAILER_PORT', '587');
define('EMAIL_PHPMAILER_QUEM_ENVIA', EMAIL);
define('EMAIL_PHPMAILER_QUEM_ENVIA_NOME', SITENAME);
define('GOOGLE_TITULO', 'titulo do google');
define('GOOGLE_DESC', 'Descrição do google');
define('GOOGLE_TAGS', 'Descrição do google aqui');
define('RODAPE', 'Corporation dsdsd');
define('GOOGLE_VERIFY', 'verificador do google');



// verifica se e http ou https por  ####################
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    //if( isset(filter_input(INPUT_SERVER, 'HTTPS', FILTER_SANITIZE_STRIPPED)) && filter_input(INPUT_SERVER, 'HTTPS', FILTER_SANITIZE_STRIPPED) == 'on' ) {
    $https = 'https://';
} else {
    $https = 'http://';
}

// DEFINE A URL DO SITE por  ####################
define('HOME', $https . SHEEP_URL);
define('PASTA_DO_PAINEL', '/sheep_painel/');
define('PASTA_DO_PAINEL_CLIENTE', '/cliente/');
define('URL_CAMINHO_PAINEL', HOME . '/' . PASTA_DO_PAINEL);
define('URL_CAMINHO_PAINEL_CLIENTE', HOME . '/' . PASTA_DO_PAINEL_CLIENTE);
define('SHEEP_LAYOUT', 'site');

//LOGO DO SITE PARA TEMAS 
define('SITELOGO', HOME . SHEEP_IMG_URL);
define('FAVICON', HOME . SHEEP_IMG_URL);


// PASTA DO MODELO E CHAMADAS 
//INCLUDE_PATCH = CAMINHO_TEMAS;
//REQUIRE_PATH = SOLICITAR_TEMAS;
define('CAMINHO_TEMAS', HOME . '/' . 'sheep_temas' . '/' . SHEEP_LAYOUT);
define('SOLICITAR_TEMAS', 'sheep_temas' . '/' . SHEEP_LAYOUT);
define('MODELO', 'sheep_temas' . '/' . SHEEP_LAYOUT);


//CONTROLE DE URLS SHEEP PHP
define('FILTROS', 'sheep.php?m=');

//ICONE DO SITE SHEEP PHP 
define('SHEEP_ICONE', 'assets/img-logo/images/2025/02/nome2025-02-26-21-19-icone-1740615569.png');

// LOGO DO PAINEL SHEEP PHP
define('SHEEP_LOGO', 'assets/img-logo/images/2025/02/nome2025-02-26-21-21-04-logo-1740615664.png');

// TITULO PAINEL SHEEP PHP 
define('SHEEP_TITULO_PAINEL', 'Painel de Controle');

// RODAPE TEXTO PAINEL SHEEP PHP 
define('SHEEP_RODAPE_PAINEL', 'Loja Jogador Raiz');



/**
 * AQUI VERIFICA SE O IP TEM LINCEÇA PARA USAR ESTE SISTEMA
 *  
 */
