<?php
ob_start();
session_start();
require_once('../../sheep_core/config.php');

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if ($email == null && $senha == null) {
    header("Location: " . URL_CAMINHO_PAINEL . "index.php?campos_vazios=true");
    exit();
}

$verifica = new Entrar();
$verifica->acessarPainel($email, $senha);
if ($verifica->getResultado()) {
    $_SESSION['sheep_user'] = $verifica->getResultado();
    header("Location: " . URL_CAMINHO_PAINEL . "sheep.php");
    exit();
} else {
    unset($_SESSION['sheep_user']);
    header("Location: " . URL_CAMINHO_PAINEL . "index.php?senha_errada=true");
    exit();
}
