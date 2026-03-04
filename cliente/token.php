
<?php 
//O filter_input pega o parâmetro token da URL (?token=12345) e garante que ele seja um inteiro válido.
$token = filter_input(INPUT_GET, 'token', FILTER_VALIDATE_INT);
if(!$token){//Se não existir ou for inválido (null, false, vazio ou não numérico), cai nesse if
?>

        <!-- INICIO TOKEN MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA --->
        <div class="alert alert-danger alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">Erro!</div>
            Seu token de sessão expirou!
          </div>
        </div>
        <!-- FIM ALERTA ERRO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<?php exit(); } ?>


<?php 
//Verifica se o comprimento do token (número convertido em string) é menor que 10 dígitos
if(mb_strlen($token) < 10){//Se tiver menos de 10 dígitos, é considerado inválido
//Aqui é um bloqueio de segurança contra tokens curtos/forjados
?>
 <!-- INICIO ALERTA ERRO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
 <div class="alert alert-danger alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">Erro!</div>
            Seu token de sessão é inválido!
          </div>
        </div>
        <!-- FIM ALERTA ERRO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

<?php  exit(); }?>


<?php 
  if($token > time() - 1){
//time() retorna a data/hora atual em timestamp UNIX (número de segundos desde 01/01/1970).
//Se o token recebido for maior que o tempo atual (menos 1 segundo), significa que o token está no futuro.
//Isso geralmente acontece quando o usuário clica muito rápido em algum botão que gera o token e o sistema identifica como tentativa de duplicidade
//Aqui é um bloqueio de segurança contra cliques rápidos/duplicados fora do intervalo permitido
?>
 <!-- INICIO ALERTA ERRO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
 <div class="alert alert-danger alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">Erro!</div>
            O que está tentando fazer? Dê um clique por vez
          </div>
        </div>
        <!-- FIM ALERTA ERRO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

<?php exit(); }?>




<?php 
$sucessoMensagem = filter_input(INPUT_GET, 'sucesso', FILTER_VALIDATE_BOOLEAN);
if($sucessoMensagem){
//Sempre que na URL vier uma mensagem de sucesso essa mensagem é exibida ao usuário no arquivo onde token.php é chamado
?>
 <!-- INICIO ALERTA SUCESSO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
 <div class="alert alert-success alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">Sucesso!</div>
            Tudo certo!
          </div>
        </div>
        <!-- FIM ALERTA SUCESSO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<?php }?>


<?php 
$erroMensagem = filter_input(INPUT_GET, 'erro', FILTER_VALIDATE_BOOLEAN);
if($erroMensagem){
  //Sempre que na URL vier uma mensagem de erro essa mensagem é exibida ao usuário no arquivo onde token.php é chamado
?>
<!-- INICIO ALERTA ERRO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<div class="alert alert-danger alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">Erro!</div>
            Ocorreu um erro!
          </div>
        </div>
<!-- FIM ALERTA ERRO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
     
<?php }?>


