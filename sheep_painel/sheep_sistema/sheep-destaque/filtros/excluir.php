<div class="main-content">

    <!-- INICIO TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <?php include_once('./token.php'); ?>
    <!-- FIM TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

    <?php
    //proteção para formulario com sessão de login
    require_once('sheep-filtros/valida.php');
    $excuir = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (isset($excuir)) {
        $remover = new Banners();
        $remover->excluirBanner($excuir);
        if ($remover->getResultado()) {
            header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-destaque/index&sucesso=true&token={$_SESSION['timeWT']}");
        } else {
            header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-destaque/index&erro=true&token={$_SESSION['timeWT']}");
        }
    }
    ?>

</div>