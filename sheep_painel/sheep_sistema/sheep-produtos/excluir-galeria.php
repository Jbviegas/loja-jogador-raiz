<!-- INICIO TOKEN MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<!-- Main Content -->
<div class="main-content">

    <?php
    require_once('sheep-filtros/valida.php');

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (isset($id)) {
        Formata::removeImagemGaleria($id, SHEEP_IMG_PRODUTOS, 'produto');
    } else {
        header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-produtos/index&erro=true&token={$_SESSION['timeWT']}");
    }

    ?>

</div>