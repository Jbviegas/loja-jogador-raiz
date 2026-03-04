<?php 


$sheep->Leitura('minhas_compras', "WHERE transacao = :tr", "tr={$fatura->transacao}");
$pagamentoAprovadoCompras = Formata::Resultado($sheep);
if($pagamentoAprovadoCompras){
foreach($sheep->getResultado() as $compraKangu);
$compraKangu = (object) $compraKangu;
}


$cepOrigem = CEP; 
$token = CORREIOS_TOKEN; 
$cepDestino = preg_replace('/[^0-9]/', '', $compraKangu->cep);


$totalPeso = $compraKangu->peso;
$totalAltura = $compraKangu->altura;
$totalLargura = $compraKangu->largura;
$totalComprimento = $compraKangu->comprimento;
$totalValor = $compraKangu->valor_total;
$totalQuantidade = $compraKangu->quantidade;

 //verifica o limite máximo de peso que é 30KG
 if($totalPeso > 30 ){
    $totalPeso = 30;
 }

 //Verifica as dimensões totais em altura, largura e comprimento sendo que o máx 200cm
 //https://ajuda.kangu.com.br/hc/pt-br/articles/4402884212119-Quais-s%C3%A3o-as-dimens%C3%B5es-e-pesos-permitidos
 $dimensoes = $totalAltura + $totalLargura + $totalComprimento;
 if($dimensoes > 200){
  $totalAltura = 65;
  $totalLargura = 65;
  $totalComprimento = 65;
  //total de 195
 }


// Constrói o array de dados
$data = [
    "pedido" => [
    "tipo" => 'D', //Tipo do Documento, D - Declaração, N - Nota Fiscal
    "vlrMerc" => $totalValor,
    "pesoMerc" => $totalPeso,
    ],
    "remetente" => [
    "nome" => SITENAME,
    "cnpjCpf" => CNPJ,
    "endereco" => [
    "logradouro" => ENDERECO,
    "numero" => NUMERO ? NUMERO : 0,
    "bairro" => 'NOVA AURORA',
    "cep" => $cepOrigem,
    "cidade" => CIDADE,
    "uf" => 'RJ',
    ],
    "contato" => [
    "email" => EMAIL,
    "celular" => CELULAR
    ],
    ],
    "destinatario" => [
    "nome" => $compraKangu->nome_cliente,
    "cnpjCpf" => $compraKangu->cpf,
    "endereco" => [
    "logradouro" => $compraKangu->endereco,
    "numero" => $compraKangu->numero ? $compraKangu->numero : 0,
    "bairro" => $compraKangu->bairro,
    "cep" => $cepDestino, // Ajuste o CEP de destino para o correto
    "cidade" => $compraKangu->cidade,
    "uf" => $compraKangu->uf,
    ],
    "contato" => [
    "email" => $compraKangu->email,
    "telefone" => $compraKangu->whatsapp,
    "celular" => $compraKangu->whatsapp
    ],
    ],
    "produtos" => [
    [
    'produto' => $compraKangu->produto,
    'peso' => $totalPeso,
    'altura' => $totalAltura,
    'largura' => $totalLargura,
    'comprimento' => $totalComprimento,
    'valor' => $totalValor,
    'quantidade' => $totalQuantidade,
    ],
    ],
    "pontoPostagem" => "", 
    "pontoEntrega" => "",
    "transportadora" => $compraKangu->transportadora,
    "referencia" => $compraKangu->transacao,
    "servicos" => ["X"],
      
    ];
    
    
    
    // Converte os dados para JSON
    $jsonData = json_encode($data);
    
    // Inicia o cURL
    $ch = curl_init('https://portal.kangu.com.br/tms/transporte/solicitar');
    
    // Configura o cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    'token: ' . $token,
    ]);
    
    // Executa a requisição e obtém a resposta
    $response = curl_exec($ch);
    
    // Verifica por erros
    if (curl_error($ch)) {
    echo 'Erro: ' . curl_error($ch);
    } else {
    // Decodifica a resposta JSON
    $decodedResponse = json_decode($response, true);
    
    // Verifica se há erros na resposta da API
    if (isset($decodedResponse['error'])) {
    echo 'Erro na API: ' . $decodedResponse['error']['mensagem'];
    } else {
    // Processa a resposta
    print_r($decodedResponse);
    }
    }
    
    // Fecha a sessão cURL
    curl_close($ch);

?>