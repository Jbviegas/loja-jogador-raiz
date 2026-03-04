<!-- INICIO TOKEN MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<!-- Main Content -->
<div class="main-content">

    <!-- INICIO TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <?php include_once('./token.php'); ?>
    <!-- FIM TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

    <?php
    require_once('sheep-filtros/valida.php');


    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);//Recebe o id do produto a ser excluído via POST do formulário
    if (isset($id)) {// Verifica se o id foi recebido

        $excluir = new Produtos();// instancia a classe Produtos
        $excluir->vamosExcluir($id);// Chama o método Excluir da classe Produtos
        if ($excluir->getResultado()) {// Verifica se a exclusão foi bem-sucedida
            Formata::removeVariasImagensGaleria($id, SHEEP_IMG_PRODUTOS);// Remove as imagens da galeria do produto
            header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-produtos/index&sucesso=true&token={$_SESSION['timeWT']}");
            // Redireciona para a página de produtos do painel e mostra a mensagem de sucesso

        } else {// Se a exclusão não foi bem-sucedida
            header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-produtos/index&erro=true&token={$_SESSION['timeWT']}");
             // Redireciona para a página de produtos do painel e mostra a mensagem de erro
            exit();// Encerra a execução do script
        }
    }

    ?>
</div>