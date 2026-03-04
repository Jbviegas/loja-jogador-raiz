<?php
ob_start();
session_start();
require_once('../../sheep_core/config.php');

// Filtrando os dados de entrada
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Verifica se os campos estão vazios
if ($email == null && $senha == null) {
    header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . "index.php?campos_vazios=true");
    exit();
}

// Criando uma instância da classe Entrar e chamando o método para acessar o painel
$verifica = new Entrar();
$verifica->acessarPainel($email, $senha);// Função que faz a validação dos dados recebidos (email e senha)
// $verifica recebe os dados do usuário


if ($verifica->getResultado()) {// Pega o resultado da validação na função acessarPainel

    $usuario = $verifica->getResultado();  // Aqui, assume-se que getResultado() retorna um array ou objeto com os dados do usuário
    $_SESSION['sheep_user'] = $usuario;// Armazena os dados do usuário na sessão

    /*
    Retornando os dados do usuário na sessão
     $_SESSION['sheep_user']['id']
     $_SESSION['sheep_user']['nome']
     $_SESSION['sheep_user']['email']

    // Retornando os dados do cliente na sessão (opicional)
    $_SESSION['id_cliente'] = $usuario['id_cliente']; Substitua 'id_cliente' conforme o nome da chave que armazena o ID do cliente
    $_SESSION['nome_cliente'] = $usuario['nome_cliente'];
    $_SESSION['email_cliente'] = $usuario['email_cliente'];

    */

    // Redirecionando para o painel do cliente
    header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . "sheep.php");
    exit();

} else {
    // Se o login falhar, destrua a sessão e redirecione para a página de login
    unset($_SESSION['sheep_user']);
    header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . "index.php?senha_errada=true");
    exit();
}
