<?php

// Recebe os dados do formulário
$carrinho = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

// Verifica se o formulário foi submetido
if (isset($carrinho['addCarrinho'])) { // Verifica se o botão de adicionar ao carrinho foi clicado
    unset($carrinho['addCarrinho']); // Remove o botão de adicionar ao carrinho do array 

    // Recebe e filtra o valor final e transforma em número decimal ex: 10.99
    $valorTotal = filter_input(INPUT_POST, 'valor_final', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Adiciona o valor final ao array de dados do carrinho
    $carrinho['valor_final'] = $valorTotal;


    // Verifica se o formulário foi submetido
    if (isset($carrinho['addCarrinho']))  // Verifica se o botão de adicionar ao carrinho foi clicado
        unset($carrinho['addCarrinho']); // Remove o botão de adicionar ao carrinho do array

    // Recebe e filtra o valor_total e transforma em número decimal ex: 10.99
    $valor = filter_input(INPUT_POST, 'valor_total', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Adiciona o valor_total ao array de dados do carrinho
    $carrinho['valor_total'] = $valor;


    // Verifica se o formulário foi submetido
    if (isset($carrinho['addCarrinho']))  // Verifica se o botão de adicionar ao carrinho foi clicado
        unset($carrinho['addCarrinho']); // Remove o botão de adicionar ao carrinho do array

    // Recebe e filtra o valor e transforma em número decimal ex: 10.99
    $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Adiciona o valor ao array de dados do carrinho
    $carrinho['valor'] = $valor;

    // Envia os dados para a classe AddCarrinho
    $addCarrinho = new AddCarrinho();
    $addCarrinho->inserir($carrinho);

    // Redireciona o usuário se a operação foi bem-sucedida
    if ($addCarrinho->getResultado()) {
        header("Location: " . HOME . "/carrinho");
        exit;
    }
}
