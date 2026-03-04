<?php

/**
 * Este exemplo já está adaptado para utilizar
 * na versão 5.0.0 da SDK de PHP
 */

if (file_exists($autoload = realpath(__DIR__ . "/../vendor/autoload.php"))) {
    require_once $autoload;
} else {
    print_r("Autoload not found or on path <code>$autoload</code>");
}

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

if (isset($_POST)) {

    if (file_exists($options = realpath(__DIR__ . "/../examples/credentials/options.php"))) {
        require_once $options;
    }

    $paymentToken = $_POST['payment_token'];

    $item_1 = [
        'name' => $_POST['nome_item_1'],
        'amount' => (int) $_POST['quantidade_item_1'],
        'value' => (int) $_POST['valor_item_1']
    ];

    $item_2 = [
        'name' => $_POST['nome_item_2'],
        'amount' => (int) $_POST['quantidade_item_2'],
        'value' => (int) $_POST['valor_item_2']
    ];

    $items = [
        $item_1,
        $item_2
    ];

    $customer = [
        'name' => $_POST['nome_cliente'],
        'cpf' => preg_replace('/[^0-9]/', '', $_POST['cpf']),
        'phone_number' => preg_replace('/[^0-9]/', '', $_POST['telefone']),
        'email' => $_POST['email'],
        'birth' => date('Y-m-d', strtotime($_POST['nascimento']))
    ];

    $billingAddress = [
        'street' => $_POST['rua'],
        'number' => $_POST['numero'],
        'neighborhood' => $_POST['bairro'],
        'zipcode' => preg_replace('/[^0-9]/', '', $_POST['cep']),
        'city' => $_POST['cidade'],
        'state' => $_POST['estado']
    ];

    $credit_card = [
        'customer' => $customer,
        'installments' => (int) $_POST['parcelas'],
        'billing_address' => $billingAddress,
        'payment_token' => $paymentToken
    ];

    $payment = [
        'credit_card' => $credit_card
    ];

    $body = [
        'items' => $items,
        'payment' => $payment
    ];

    try {
        $api = new Gerencianet($options);
        $response = $api->oneStep([], $body);

        echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
        echo 'Máscara do cartão:' . $_POST['mascara_cartao'];
    } catch (GerencianetException $e) {
        print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
} else {
    print_r("As informações para o pagamento não foram enviadas. Tente novamente!");
}
