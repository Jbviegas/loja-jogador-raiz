<?php
$removerCarrinho = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (isset($removerCarrinho)) {

    $removendoCarrinho = new AddCarrinho();
    $removendoCarrinho->excluirCarrinho($removerCarrinho);
    if ($removendoCarrinho->getResultado()) {
        header("Location: " . HOME . "/carrinho");
    }
}
