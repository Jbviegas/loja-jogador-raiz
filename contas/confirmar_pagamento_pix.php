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

    //VERIFICA SE O E-MAIL JÁ EXISTE NO SISTEMA
    $sheep->Leitura('usuarios', "WHERE email = :email", "email={$pagamento['email']}");
    $verificaEmail = Formata::Resultado($sheep);
    if ($verificaEmail) {
        header("Location: " . HOME . "/pagamentos/index.php?token={$_SESSION['token_pagamentos']}&email=true");
        exit();
    }

    //VERIFICA SE O CPF JÁ EXISTE NO SISTEMA
    $sheep->Leitura('usuarios', "WHERE cpf = :cpf", "cpf={$pagamento['cpf']}");
    $verificaCpf = Formata::Resultado($sheep);
    if ($verificaCpf) {
        header("Location: " . HOME . "/pagamentos/index.php?token={$_SESSION['token_pagamentos']}&cpf=true");
        exit();
    }

    //Formatação do valor
    $pagamento['total_valor'] = Formata::vr($pagamento['total_valor']); // 76,88
    $valorOriginal = $pagamento['total_valor'];
    $valorModificado = str_replace([",", "."], "", $valorOriginal); // 7688
    $valorFinal = (int) $valorModificado; // 7688

    $cpf = preg_replace('/[^0-9]/', '', $pagamento['cpf']);
    $fone = preg_replace('/[^0-9]/', '', $pagamento['whatsapp']);
    $cep = preg_replace('/[^0-9]/', '', $pagamento['cep']);
    //$valor = $pagamento['total_valor'];

    //ESTADO DO CLIENTE
    $sheep->Leitura('app_estados', "WHERE estado_id = :idEstado", "idEstado={$pagamento['estado']}");
    $estadoDoCliente = Formata::Resultado($sheep);
    if ($estadoDoCliente) {
        foreach ($sheep->getResultado() as $estado);
        $estado = (object) $estado;
    }


    //CIDADE DO CLIENTE
    $sheep->Leitura('app_cidades', "WHERE cidade_id = :idCidade", "idCidade={$pagamento['cidade']}");
    $cidadeDoCliente = Formata::Resultado($sheep);
    if ($cidadeDoCliente) {
        foreach ($sheep->getResultado() as $cidade);
        $cidade = (object) $cidade;
    }

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
            $valorFormatado = (int) str_replace([',', '.'], '', $carrinho->valor_total);

            // Adiciona cada item ao array de itens
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


    //URL DE RETORNO 
    $urlRetorno =  HOME . '/pagamentos/retorno.php';
    //$urlRetorno = 'https://maykonsilveira.com.br';

    //url de notificação
    $metadata = ["notification_url" => $urlRetorno];

    $costumer = [
        'name' => $pagamento['nome'] . ' ' . $pagamento['sobrenome'],
        'cpf' => $cpf,
    ];

    $bankingBillet = [
        'expire_at' => date("Y-m-d", strtotime(" + 3 days")),
        'message' => $contaCarrinho > 1 ? ' +' . $contaCarrinho . ' Produtos' : 'nenhuma',
        //'message' => $carrinho->titulo . $contaCarrinho > 1 ? ' +' . $contaCarrinho : null,
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

        $dadosUsuario = [
            'nome' => $pagamento['nome'],
            'sobrenome' => $pagamento['sobrenome'],
            'cpf' => $pagamento['cpf'],
            'nascimento' => $pagamento['nascimento'],
            'email' => $pagamento['email'],
            'senha' => password_hash($pagamento['senha'], PASSWORD_DEFAULT, ['const' => 10]),
            'whatsapp' => $pagamento['whatsapp'],
            'endereco' => $pagamento['endereco'],
            'numero' => $pagamento['numero'],
            'cep' => $pagamento['cep'],
            'status' => 'S',
            'estado' => $pagamento['estado'],
            'cidade' => $pagamento['cidade'],
            'bairro' => $pagamento['bairro'],
            'nivel' => 'C',
            'tipo' => 'usuario',
            'tipo_cadastro' => 'criar',
            'data' => date('Y-m-d H:i:s'),
            'dia' => date('d'),
            'mes' => date('m'),
            'ano' => date('Y'),
        ];


        //para cadastrar cliente na loja 
        $cadastrarUsuario->Criacao('usuarios', $dadosUsuario);

        //ler para logar
        $ler = new Ler();
        $ler->Leitura('usuarios', "WHERE email = :email", "email={$pagamento['email']}");
        if ($ler->getResultado() && password_verify($pagamento['senha'], $ler->getResultado()[0]['senha'])) {
            $_SESSION['sheep_user'] = $ler->getResultado()[0];
        }



        $dadosFatura = [
            'cliente' => $cadastrarUsuario->getResultado(),
            'cliente_nome' => $pagamento['nome'] . ' ' . $pagamento['sobrenome'],
            'cliente_email' => $pagamento['email'],
            'cliente_cpf' => $pagamento['cpf'],
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
                    'id_cliente' => $cadastrarUsuario->getResultado(),
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
                    'nome_cliente' => $pagamento['nome'] . ' ' . $pagamento['sobrenome'],
                    'whatsapp' =>  $pagamento['whatsapp'],
                    'email' => $pagamento['email'],
                    'cpf' => $pagamento['cpf'],
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
        $assunto = "INTENÇÃO DE PAGAMENTO BOLETO/PIX " . $pagamento['nome'] . " CPF:" . $pagamento['cpf'];
        $empresaNome = SITENAME;
        $emailEmpresa = EMAIL;
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF8' . "\r\n";
        $produtoEmail = $carrinho->titulo . $contaCarrinho > 1 ? ' +' . $contaCarrinho : null;
        $valorEmail = Formata::vr($_SESSION['total_valor']);
        $dataEmail = date('d/m/Y');
        $mensagem = "
        <p>INTENÇÃO DE PAGAMENTO BOLETO/PIX - AGUARDANDO</p>
        <p>Nome: {$pagamento['nome']} {$pagamento['sobrenome']}</p>
        <p>E-mail: {$pagamento['email']}</p>
        <p>CPF: {$pagamento['cpf']}</p>
        <p>Fone: {$pagamento['whatsapp']}</p>
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
