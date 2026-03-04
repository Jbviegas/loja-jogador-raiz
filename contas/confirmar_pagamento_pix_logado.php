<?php
session_start();
ob_start();
//conexao 
require_once('../sheep_core/config.php');
//chama o efi banco digital
require_once('./vendor/autoload.php');

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$sheep = new Ler();

$pagamento = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

//para cadastrar cliente na loja 
$cadastrarUsuario = new Criar();
//cria fatura de compra
$cadastrarFatura = new Criar();
//criar minhas compras
$cadastrarMinhasCompras = new Criar();

//data atual
$dataCartao = date('Y-m-d');
$dataDia = date('d');
$dataMes = date('m');
$dataAno = date('Y');

//token de proteção do site 
$tokenPagamentoSistema = filter_input(INPUT_GET, 'tokenPagamento', FILTER_SANITIZE_SPECIAL_CHARS);
if ($_SESSION['token_pagamentos'] != $tokenPagamentoSistema):
    header("Location: " . HOME);
    exit();
endif;

if ($tokenPagamentoSistema == null):
    header("Location: " . HOME);
    exit();
endif;

if ($_SESSION['token_pagamentos'] === $tokenPagamentoSistema):
    null;
else:
    header("Location: " . HOME);
    exit();
endif;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //ler para logar
    $ler = new Ler();
    $ler->Leitura('usuarios', "WHERE id = :id", "id={$_SESSION['sheep_user']['id']}");
    if ($ler->getResultado()) {
        foreach ($ler->getResultado() as $cliente);
        $cliente = (object) $cliente;
    }

    //Formatação do valor
    $pagamento['total_valor'] = Formata::vr($pagamento['total_valor']); // 76,88
    $valorOriginal = $pagamento['total_valor'];
    $valorModificado = str_replace([",", "."], "", $valorOriginal); // 7688
    $valorFinal = (int) $valorModificado; // 7688

    $cpf = preg_replace('/[^0-9]/', '', $cliente->cpf);
    $fone = preg_replace('/[^0-9]/', '', $cliente->whatsapp);
    $cep = preg_replace('/[^0-9]/', '', $cliente->cep);
    //$valor = $pagamento['total_valor'];

    //ESTADO DO CLIENTE
    $sheep->Leitura('app_estados', "WHERE estado_id = :idEstado", "idEstado={$cliente->estado}");
    $estadoDoCliente = Formata::Resultado($sheep);
    if ($estadoDoCliente) {
        foreach ($sheep->getResultado() as $estado);
        $estado = (object) $estado;
    }


    //CIDADE DO CLIENTE
    $sheep->Leitura('app_cidades', "WHERE cidade_id = :idCidade", "idCidade={$cliente->cidade}");
    $cidadeDoCliente = Formata::Resultado($sheep);
    if ($cidadeDoCliente) {
        foreach ($sheep->getResultado() as $cidade);
        $cidade = (object) $cidade;
    }


    $lerIdsessao = new Ler();
    $lerIdsessao->LeituraCompleta("SELECT id_sessao FROM carrinho ORDER BY id_sessao DESC");

    // Verifica se o resultado é válido
    if ($lerIdsessao->getResultado()):
        // Obtém o array associativo completo
        $resultado = $lerIdsessao->getResultado()[0];

        // Acessa diretamente o valor da chave 'id_sesao'
        $idsessao = $resultado['id_sessao'];

    // Converte o valor para string
    //$idSessaoString = strval($idsessao);
    endif;


    // LEITURA DO CARRINHO
    $contaCarrinho = 0;
    $items = []; // Inicializa array de itens

    $sheep->Leitura('carrinho', "WHERE id_sessao = :idSes AND dia = :dia AND mes = :mes AND ano = :ano", "idSes={$pagamento['id_sessao']}&dia={$dataDia}&mes={$dataMes}&ano={$dataAno}");
    $carrinhoDoCliente = Formata::Resultado($sheep);

    if ($carrinhoDoCliente) {
        $contaCarrinho = $sheep->getContaLinhas();

        foreach ($sheep->getResultado() as $carrinho) {
            $carrinho = (object) $carrinho;

            // Remover pontos e vírgulas e converter para inteiro
            $valorFormatado = (int)str_replace([',', '.'], '', $carrinho->valor_total);

            // Adiciona cada item ao array de itens dentro do loop
            $items[] = [
                'name' => $carrinho->titulo,
                'amount' => intval($carrinho->qtde), // Quantidade do item
                'value' => $valorFormatado, // Valor formatado sem vírgulas
            ];
        }
    }

    // CONEXÃO COM BANCO EFI NO NOSSO SISTEMA
    include_once('config.php');

    $options = [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'sandbox' => $statusBanco,
    ];

    // URL DE RETORNO 
    $urlRetorno =  HOME . '/pagamentos/retorno.php';
    //$urlRetorno = 'https://maykonsilveira.com.br';

    // URL de notificação
    $metadata = ["notification_url" => $urlRetorno];

    $costumer = [
        'name' => $cliente->nome . ' ' . $cliente->sobrenome,
        'cpf' => $cpf,
    ];

    $bankingBillet = [
        'expire_at' => date("Y-m-d", strtotime(" + 3 days")),
        'message' => $contaCarrinho > 1 ? ' +' . $contaCarrinho . ' Produtos' : 'nenhuma',
        'customer' => $costumer,
    ];

    $payment = [
        'banking_billet' => $bankingBillet
    ];

    $body = [
        'items' => $items,
        'metadata' => $metadata,
        'payment' => $payment
    ];



    try {
        $api = new Gerencianet($options);
        $response = $api->createOneStepCharge($params = [], $body);


        $dadosFatura = [
            'cliente' => $cliente->id,
            'cliente_nome' => $cliente->nome . ' ' . $cliente->sobrenome,
            'cliente_email' => $cliente->email,
            'cliente_cpf' => $cliente->cpf,
            'transacao' => $response['data']['charge_id'],
            'valor_total' => $_SESSION['total_valor'],
            'idSessao' => $pagamento['id_sessao'],
            'status' => 'waiting',
            'data' => date('Y-m-d H:i:s'),
            'dia' => date('d'),
            'mes' => date('m'),
            'ano' => date('Y'),
        ];


        //cria fatura de compra
        $cadastrarFatura->Criacao('faturas', $dadosFatura);

        //Leitura carrinho para minhas compras
        $sheep->Leitura('carrinho', "WHERE id_sessao = :idSes AND dia = :dia AND mes = :mes AND ano = :ano", "idSes={$pagamento['id_sessao']}&dia={$dataDia}&mes={$dataMes}&ano={$dataAno}");
        $carrinhoDoClienteCompras = Formata::Resultado($sheep);
        if ($carrinhoDoClienteCompras) {
            foreach ($sheep->getResultado() as $carrinhoCompras) {
                $carrinhoCompras = (object) $carrinhoCompras;

                $dadosMinhasCompras = [
                    'id_cliente' => $cliente->id,
                    'id_produto' => $carrinhoCompras->id_produto,
                    'produto' => $carrinhoCompras->titulo,
                    'capa' => $carrinhoCompras->capa,
                    'valor_produto' => $carrinhoCompras->valor_total,
                    'quantidade' => $carrinhoCompras->qtde,
                    'tamanho' => $carrinhoCompras->tamanho,
                    'personaliza_foto' => $carrinhoCompras->personaliza_foto,
                    'nome_camisa' => $carrinhoCompras->nome_camisa,
                    'numero_camisa' => $carrinhoCompras->numero_camisa,
                    'valor_total' => $_SESSION['total_valor'],
                    'nome_cliente' => $cliente->nome . ' ' . $cliente->sobrenome,
                    'whatsapp' =>  $cliente->whatsapp,
                    'email' => $cliente->email,
                    'cpf' => $cliente->cpf,
                    'endereco' => $pagamento['endereco'],
                    'numero' => $pagamento['numero'] ? $pagamento['numero'] : 0,
                    'cep' => $pagamento['cep'],
                    'bairro' => $pagamento['bairro'],
                    'estado' => $estado->estado_nome,
                    'uf' => $estado->estado_uf,
                    'cidade' => $cidade->cidade_nome,
                    'status' => 'waiting',
                    'transacao' => $response['data']['charge_id'],
                    'id_sessao' => $carrinhoCompras->id_sessao,
                    'data' => date('Y-m-d H:i:s'),
                    'dia' => date('d'),
                    'mes' => date('m'),
                    'ano' => date('Y'),
                ];

                //cria minhas compras
                $cadastrarMinhasCompras->Criacao('minhas_compras', $dadosMinhasCompras);
                if ($cadastrarMinhasCompras->getResultado()) {

                    //remove do carrinho após a conclusão da compra
                    $removerDoCarrinho = new Excluir();
                    $removerDoCarrinho->Remover('carrinho', "WHERE id_sessao = :idSes AND dia = :dia AND mes = :mes AND ano = :ano", "idSes={$pagamento['id_sessao']}&dia={$dataDia}&mes={$dataMes}&ano={$dataAno}");
                }
            }
        }

        
        //e-mail de alerta de pagamento 
        $horaAtual = date('H:i');
        $assunto = "INTENÇÃO DE PAGAMENTO BOLETO / PIX " . $cliente->nome . " CPF:" . $cliente->cpf;
        $empresaNome = SITENAME; 
        $emailEmpresa = EMAIL; 
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF8' . "\r\n";
        $produtoEmail = $carrinho->titulo . $contaCarrinho > 1 ? ' +' .$contaCarrinho : null;
        $valorEmail = Formata::vr($_SESSION['total_valor']);
        $dataEmail = date('d/m/Y');
        $mensagem = "
        <p>INTENÇÃO DE PAGAMENTO BOLETO / PIX - AGUARDANDO</p>
        <p>Nome: {$cliente->nome} {$cliente->sobrenome}</p>
        <p>E-mail: {$cliente->email}</p>
        <p>CPF: {$cliente->cpf}</p>
        <p>Fone: {$cliente->whatsapp}</p>
        <p>Produto: {$carrinho->titulo}</p>
        <p>Valor: R$ {$valorEmail}</p>
        <p>Transação: {$response['data']['charge_id']}</p>
        <p>Data: {$dataEmail} Empresa {$empresaNome} - E-mail da Empresa: {$emailEmpresa}</p>
        ";
        mail($emailEmpresa, $assunto, $mensagem, $headers);
         


        //REDIRECIONA PARA A URL DO BOLETO E PIX
        $urlBoletoPix = $response['data']['link'];
        header("Location: " . $urlBoletoPix);
    } catch (GerencianetException $e) {
        print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
} else {
    header("Location: " . HOME);
    exit();
}
