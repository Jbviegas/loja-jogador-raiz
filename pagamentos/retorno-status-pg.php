<?php 
$status = '';
switch($statusAtual){
   case $statusAtual == 'new':
    $status = 'Novo';
   break;
   case $statusAtual == 'waiting':
    $status = 'Pendente';
   break;
   case $statusAtual == 'identified':
    $status = 'identificado';
   break;
   case $statusAtual == 'approved':
    $status = 'Aguardando operador do cartão';
   break;
   case $statusAtual == 'canceled':
    $status = 'Pedido Cancelado';
   break;
   case $statusAtual == 'paid':
    $status = 'Pagamento Aprovado';
   break;
   case $statusAtual == 'unpaid':
    $status = 'Não pago ou Recusado';
   break;
   case $statusAtual == 'refunded':
    $status = 'Pagamento Devolvido';
   break;
   case $statusAtual == 'contested':
    $status = 'Pagamento Contestado';
   break;
   case $statusAtual == 'settled':
    $status = 'Marcado como pago';
   break;
   case $statusAtual == 'expired':
    $status = 'Expirado';
   break;
}

?>