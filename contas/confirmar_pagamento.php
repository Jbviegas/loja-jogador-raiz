<?php
session_start();
ob_start();
//conexao 
require_once('../sheep_core/config.php');
//chama o efi banco digital
require_once('./vendor/autoload.php');

use Gerencianet\Exception\GerencianetException;


$sheep = new Ler();

$pagamento = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

//para cadastrar cliente na loja 
$cadastrarUsuario = new Criar();
//$cadastrarConsentimentos = new Criar();


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
        }
    }


    try {


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

        /*
        $dadosConsentimento = [
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

        $cadastrarConsentimentos->Criacao('consentimento', $dadosConsentimento);

        */

        //ler para logar
        $ler = new Ler();
        $ler->Leitura('usuarios', "WHERE email = :email", "email={$pagamento['email']}");
        if ($ler->getResultado() && password_verify($pagamento['senha'], $ler->getResultado()[0]['senha'])) {
            $_SESSION['sheep_user'] = $ler->getResultado()[0];
        }



        //Entrar logado no painel de controle
        header("Location: " . HOME . '/cliente/' . "sheep.php");
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
