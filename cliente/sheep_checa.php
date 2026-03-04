<?php
ob_start();
session_cache_expire(60);
session_start();
require('../sheep_core/config.php');
$sheep = new Ler();

//sair do sistema
$sair = filter_input(INPUT_GET, 'sair', FILTER_VALIDATE_BOOLEAN); //Se o usuário mandar 'sair' = true através da URL:
if ($sair) { // Verifica se existe 'sair'
    unset($_SESSION['sheep_user']); //Se sim, derruba a sessão do usuário
    header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . "index.php?sheep_saiu=true"); // Redireciona para a página de login
    exit(); // Encerra a execução do script
}


if (!$_SESSION['sheep_user']) { // Se não existir uma sessão
    unset($_SESSION['sheep_user']); // Derruba a sessão do usuário
    header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . "index.php?sheep_saiu=true"); // Redireciona para a página de login
    exit(); // Encerra a execução do script
}


if ($_SESSION['sheep_user']['nivel'] != 'C') { //se o nivel do usuário for diferente de C (cliente)
    unset($_SESSION['sheep_user']); // Derruba a sessão do usuário
    header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . "index.php?sheep_saiu=true"); // Redireciona para a página de login
    exit(); // Encerra a execução do script
}

if ($_SESSION['sheep_user']['status'] != 'S') { //Se o status do usuário for diferente de S (Ativo)
    unset($_SESSION['sheep_user']); // Derruba a sessão do usuário
    header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . "index.php?sheep_saiu=true"); // Redireciona para a página de login
    exit(); // Encerra a execução do script
}


//proteção para o formalário 
$_SESSION['_sheep_firewall'] = (!isset($_SESSION['_sheep_firewall'])) ? hash('sha512', random_int(100, 5000)) : $_SESSION['_sheep_firewall'];

//protação para url do painel de controle 
$_SESSION['timeWT'] = (!isset($_SESSION['timeWT'])) ?  time() : $_SESSION['timeWT'];

$sheep_uri = filter_input(INPUT_SERVER, 'REQUEST_URI');//Pega a URL completa que o usuário está acessando (exemplo: /painel.php?m=usuarios).
$ms = filter_input(INPUT_GET, 'm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);//Aqui está o ponto-chave: ele pega o parâmetro m da URL (via $_GET).
// Se o usuário acessa sheep.php?m=sheep-usuarios então $ms = "sheep-usuarios";

//O FILTER_SANITIZE_FULL_SPECIAL_CHARS remove caracteres perigosos (tipo < > " ' &), ajudando na segurança contra XSS.

//Esse trecho está ligado ao arquivo sheep.php


