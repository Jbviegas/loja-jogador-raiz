<?php
ob_start();
session_cache_expire(10);
session_start();
require('../sheep_core/config.php');
$sheep = new Ler();

//Sair do sistema
$sair = filter_input(INPUT_GET, 'sair', FILTER_VALIDATE_BOOLEAN);
if ($sair) {
    unset($_SESSION['sheep_user']);
    header("Location: " . URL_CAMINHO_PAINEL . "index.php?sheep_saiu=true");
    exit();
}

// se não existir uma sessão ele derruba
if (!$_SESSION['sheep_user']) {
    unset($_SESSION['sheep_user']);
    header("Location: " . URL_CAMINHO_PAINEL . "index.php?sheep_saiu=true");
    exit();
}

//se o nivel for diferente de M ele sai
if ($_SESSION['sheep_user']['nivel'] != 'M') {
    unset($_SESSION['sheep_user']);
    header("Location: " . URL_CAMINHO_PAINEL . "index.php?sheep_saiu=true");
    exit();
}

//se o o status for diferente de S(Ativo) ele sai
if ($_SESSION['sheep_user']['status'] != 'S') {
    unset($_SESSION['sheep_user']);
    header("Location: " . URL_CAMINHO_PAINEL . "index.php?sheep_saiu=true");
    exit();
}


//proteção para o formalário 
$_SESSION['_sheep_firewall'] = (!isset($_SESSION['_sheep_firewall'])) ? hash('sha512', random_int(100, 5000)) : $_SESSION['_sheep_firewall'];

//protação para url do painel de controle 
$_SESSION['timeWT'] = (!isset($_SESSION['timeWT'])) ?  time() : $_SESSION['timeWT'];

$see_uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
$ms = filter_input(INPUT_GET, 'm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
