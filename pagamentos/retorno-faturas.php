<?php 

$sheep->Leitura('faturas', "WHERE transacao = :id", "id={$charge_id}");
$faturasRetorno = Formata::Resultado($sheep);
if($faturasRetorno){
foreach($sheep->getResultado() as $fatura);
$fatura = (object) $fatura;
}


//retorna o status atual do pagamento
if($statusAtual){
   
    //atualiza status da fatura 
    $dadosFaturas = ['status' => $statusAtual];
    $atualizarStatusFatura->Atualizando('faturas', $dadosFaturas, "WHERE transacao = :id", "id={$charge_id}");
    
    //atualiza status das minhas compras
    $dadosMinhasCompras = ['status' => $statusAtual];
    $atualizarStatusCompras->Atualizando('minhas_compras', $dadosMinhasCompras, "WHERE transacao = :id", "id={$charge_id}");

  
    //Envia e-mail com informações do status de pagamento 
    $assuntoStatus = "Status Atual do Pagamento " . $fatura->cliente_nome . " Transação: " . $fatura->transacao;
    $empresaStatus = SITENAME; 
    $emailEmpresa = EMAIL;
    $headers = 'MIME-Vesion: 1.0' . "\r\n"; 
    $headers = 'Content-Type: text/html; charset=UTF8' . "\r\n"; 
    $dataEmail = date('d/m/Y');
    $valorEmail = Formata::vr($fatura->valor_total);
    $mensagem = 
     "<p>Status Atual do Pagamento: {$status}</p>" 
    ."<p>Transação: {$fatura->transacao} </p>"  
    ."<p>Cliente: {$fatura->cliente_nome} </p>"   
    ."<p>Valor: R$ {$valorEmail} </p>"   
    ."<p>CPF: {$fatura->cliente_cpf} </p>"  
    ."<p>Data {$dataEmail} Empresa: {$empresaStatus}  E-mail: {$emailEmpresa}</p>";  
    
    mail($emailEmpresa, $assuntoStatus, $mensagem, $headers);

}


?>