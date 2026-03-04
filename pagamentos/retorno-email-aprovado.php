<?php 
//enviar um e-mail para o cliente
$assunto = "Pagamento Aprovado " . $fatura->cliente_nome . " Transação: " . $fatura->transacao;
$empresaStatus = SITENAME; 
$emailEmpresa = EMAIL;
$dataEmail = date('d/m/Y');
$valorEmail = Formata::vr($fatura->valor_total);
$olaAprovado = Formata::Comprimento(date('H'));
$mensagemAprovado = 
 "<p>Prezado(a), cliente: {$fatura->cliente_nome} {$olaAprovado}</p>"   
."<p>Estamos preparando o seu produto para entrega, em breve vai receber o código de rastreio em seu painel.</p>"   
."<p>Valor: R$ {$valorEmail} </p>"   
."<p>Status Atual do Pagamento: {$status}</p>" 
."<p>Transação: {$fatura->transacao} </p>";

Formata::EnviaEmailHome($assunto, $mensagemAprovado, 'contatos', $fatura->cliente_email, $fatura->cliente_nome);
?>