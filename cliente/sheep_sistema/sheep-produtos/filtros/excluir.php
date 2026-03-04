<!-- INICIO TOKEN MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA---> 
<!-- Main Content -->
<div class="main-content" >          
             
<!-- INICIO TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<?php include_once('./token.php'); ?>
<!-- FIM TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

<?php
require_once('sheep-filtros/valida.php');
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if(isset($id)){

    $excluir = new ImagemCompra();
    $excluir->vamosExcluir($id);
    if($excluir->getResultado()){
       Formata::removeVariasImagensGaleria($id, SHEEP_IMG_PRODUTOS);
       header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-produtos/index&sucesso=true&token={$_SESSION['timeWT']}");
    }else{
        header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-produtos/index&erro=true&token={$_SESSION['timeWT']}");
    }
}

?>
</div>