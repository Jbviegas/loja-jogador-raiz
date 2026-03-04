<!-- Main Content -->
<div class="main-content">
    <!--INICIO MENSAGEN DE RETORNO  MAYKON SILVEIRA--->
    <?php include_once 'token.php'; ?>
    <!--FIM MENSAGEN DE RETORNO  MAYKON SILVEIRA--->

    <?php

    //proteção para usuário logado
    require_once('sheep-filtros/valida.php');

    $criar = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (isset($criar['sendSheep'])) {
        unset($criar['sendSheep']);
        $criar['foto'] = ($_FILES['foto']['tmp_name'] ? $_FILES['foto'] : null);

        $criar['foto'] = ($_FILES['foto']['tmp_name'] ? $_FILES['foto'] : null);

        //firewall de proteção 
        if ($criar['sheep_firewall'] != $_SESSION['_sheep_firewall']) {
            header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-usuarios/index&erro=true&token=" . $_SESSION['timeWT']);
            exit();
        }

        $salvar = new Usuarios();
        $salvar->enviaClasse($criar);
        if ($salvar->getResultado()) {
            $_SESSION['_sheep_firewall'] = hash('sha512', random_int(100, 5000));
            header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-usuarios/index&sucesso=true&token=" . $_SESSION['timeWT']);
        } else {
            header("Location: " . URL_CAMINHO_PAINEL . FILTROS . "sheep-usuarios/index&erro=true&token=" . $_SESSION['timeWT']);
        }
    }

    ?>

</div>