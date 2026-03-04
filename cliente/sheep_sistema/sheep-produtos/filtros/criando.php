<!-- INICIO TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<?php include_once('./token.php'); ?>
<!-- FIM TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

<?php
require_once('sheep-filtros/valida.php');

$criar = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (isset($criar['sendSheep'])) {
    unset($criar['sendSheep']);

    $criar['capa'] = $_FILES['capa']['tmp_name'] ? $_FILES['capa'] : null;
    //'capa' é o arquivo(imagem) enviado pelo usuário
    //tmp_name é o nome temporário do arquivo antes de ser enviado para o servidor

   // proteção de formulário
    if ($criar['sheep_firewall'] != $_SESSION['_sheep_firewall']) {// Proteção contra requisições inválidas
        header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . FILTROS . "sheep-produtos/index_errordefirewall&erro=firewall&token={$_SESSION['timeWT']}");
        exit();// Se o firewall recebido do formulário não for igual ao firewall da sessão atual, redireciona para a página de erro
    }

    // Verifica se já existe capa para esta transação
    $sheep->Leitura(
        'produto_cliente',
        "WHERE transacao = :t AND capa IS NOT NULL AND capa != ''",
        "t={$criar['transacao']}"
    );
    $jaEnviado = Formata::Resultado($sheep);// Verifica se já existe uma capa enviada

    if (!empty($jaEnviado)) {// Se já existe uma capa enviada
        // Redireciona o usuário para a página de erro
        header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . FILTROS . "sheep-produtos/index_error&erro=capa_ja_enviada&token={$_SESSION['timeWT']}");
        exit();
    }

    // Inicia o processo de cadastro do produto
    $salvar = new ProdutosClientes();// Instancia a classe de manipulação de produtos do cliente
    $salvar->criarProduto($criar);// Cadastra o produto com os dados do formulário
    if ($salvar->getResultado()) {// Se o produto foi cadastrado com sucesso
        $_SESSION['_sheep_firewall'] = hash('sha512', random_int(100, 5000));
        // Gera um novo token de segurança para a próxima requisição
        if (!empty($_FILES['capa']['tmp_name'])) {// Verifica se o upload da imagem foi feito corretamente
            $_SESSION[SHEEP_IMG_PRODUTOS] = $salvar->getResultado();// Armazena o ID do produto na sessão para vincular a imagem depois
        }
         //Se tudo der certo redireciona o usuário pra pagina de sucesso
        header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . FILTROS . "sheep-produtos/imagens_enviadas&sucesso=true&token={$_SESSION['timeWT']}");
    } else {
        header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . FILTROS . "sheep-produtos/index_error&erro=true&token={$_SESSION['timeWT']}");
         //Se algo der errado, redireciona para a página de erro
    }
}
