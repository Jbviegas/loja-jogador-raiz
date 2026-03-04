<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total_qtde = filter_input(INPUT_POST, 'total_qtde', FILTER_DEFAULT);
    $total_valor = filter_input(INPUT_POST, 'total_valor', FILTER_DEFAULT);
    $id_sessao = filter_input(INPUT_POST, 'id_sessao', FILTER_DEFAULT);
    $cep = filter_input(INPUT_POST, 'cep', FILTER_DEFAULT);

    $_SESSION = [
        'total_qtde' => $total_qtde,
        'total_valor' => $total_valor,
        'id_sessao' => $id_sessao,
        'cep' => $cep,
    ];

    echo json_encode(['message' => 'Frete foi selecionado com sucesso!']);
} else {
    echo json_encode(['message' => 'Método não foi suportado!']);
}
