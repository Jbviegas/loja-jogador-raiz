<?php
// se não existir uma sessão ele derruba
if (!$_SESSION['sheep_user']) {// Se a sessão do usuário não existir
    unset($_SESSION['sheep_user']);// Remove a sessão do usuário
    header("Location: " . URL_CAMINHO_PAINEL . "index.php?sheep_saiu=true");// Redireciona para a página de login do painel
    exit();// Encerra a execução do script
}

//se o nivel for diferente de M ele sai
if ($_SESSION['sheep_user']['nivel'] != 'M') {// Se o nível do usuário não for 'M'
    unset($_SESSION['sheep_user']);// Remove a sessão do usuário
    header("Location: " . URL_CAMINHO_PAINEL . "index.php?sheep_saiu=true");// Redireciona para a página de login do painel
    exit();// Encerra a execução do script
}

//se o o status for diferente de S(Ativo) ele sai
if ($_SESSION['sheep_user']['status'] != 'S') {// Se o status do usuário não for 'S'
    unset($_SESSION['sheep_user']);// Remove a sessão do usuário
    header("Location: " . URL_CAMINHO_PAINEL . "index.php?sheep_saiu=true");// Redireciona para a página de login do painel
    exit();// Encerra a execução do script
}
