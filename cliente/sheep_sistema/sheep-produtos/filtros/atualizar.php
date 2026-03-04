<!-- INICIO TOKEN MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA---> 
<!-- Main Content -->
<div class="main-content" >          
             
<!-- INICIO TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<?php include_once('./token.php'); ?>
<!-- FIM TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

<?php
require_once('sheep-filtros/valida.php');
$atualizar = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if(isset($atualizar['sendSheep'])){
   unset($atualizar['sendSheep']);

   $atualizar['capa'] = $_FILES['capa']['tmp_name'] ? $_FILES['capa'] : null;

  if($atualizar['sheep_firewall'] != $_SESSION['_sheep_firewall']){
     header("Locarion: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-produtos/index&erro=true&token={$_SESSION['timeWT']}");
     exit();
  } 

  $salvar = new Produtos();
  $salvar->atualizarProduto($atualizar['id'], $atualizar);
  if($salvar->getResultado()){

     //envia galerias 
     if(!empty($_FILES['fotos']['tmp_name'])){
          Formata::galeriaImagens('produto', SHEEP_IMG_PRODUTOS, $_FILES['fotos'], $atualizar['id'], $atualizar['tipo']);
     }

    $_SESSION['_sheep_firewall'] = hash('sha512', random_int(100, 5000));
    header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-produtos/index&sucesso=true&token={$_SESSION['timeWT']}");
  }else{
    header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-produtos/index&erro=true&token={$_SESSION['timeWT']}");
  }
}

?>
</div>