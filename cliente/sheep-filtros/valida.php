<?php
// se não existir uma sessão ele derruba
if (!$_SESSION['sheep_user']) {
    unset($_SESSION['sheep_user']);
    header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . "index.php?sheep_saiu=true");
    exit();
}

//se o nivel for diferente de C ele sai
if ($_SESSION['sheep_user']['nivel'] != 'C') {
    unset($_SESSION['sheep_user']);
    header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . "index.php?sheep_saiu=true");
    exit();
}

//se o o status for diferente de S(Ativo) ele sai
if ($_SESSION['sheep_user']['status'] != 'S') {
    unset($_SESSION['sheep_user']);
    header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . "index.php?sheep_saiu=true");
    exit();
}
