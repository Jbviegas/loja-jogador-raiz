<!-- Main Content -->
<div class="main-content">


    <!-- Inclui o token de autenticação do usuário -->
    <?php include_once('./token.php'); ?>


    <?php
    require_once('sheep-filtros/valida.php'); // Inclui a validação dos dados do formulário antes de qualquer processamento

    $criar = filter_input_array(INPUT_POST, FILTER_DEFAULT); // Recebe todos os dados enviados pelo formulário via POST
    if (isset($criar['sendSheep'])) { //sendSheep é o botão de envio do formulário, Verifica se o formulário foi enviado (botão 'sendSheep' foi clicado)
        unset($criar['sendSheep']); // Remove o botão 'sendSheep' do array de dados, pois não precisamos salvar isso


        // Armazena a imagem da capa enviada pelo usuário
        // Se não houver arquivo, define como null
        // $_FILES['capa']['tmp_name'] contém o caminho temporário do arquivo no servidor
        $criar['capa'] = $_FILES['capa']['tmp_name'] ? $_FILES['capa'] : null;


        // Proteção contra requisições inválidas ou CSRF
        // Compara o firewall enviado pelo formulário com o token de sessão
        if ($criar['sheep_firewall'] != $_SESSION['_sheep_firewall']) { // Proteção contra requisições inválidas
            // Se o token não bater, redireciona para a página de erro
            header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . FILTROS . "cliente/sheep-painel/index&erro=true&token={$_SESSION['timeWT']}");
            // Se o firewall recebido do formulário não for igual ao firewall da sessão atual, redireciona para a página de erro
            exit(); // Encerra a execução do script imediatamente
        }


        $salvar = new Produtos(); // Instancia a classe responsável por gerenciar produtos
        $salvar->criarProduto($criar); // Chama o método criarProduto, passando os dados do formulário (incluindo capa)
        if ($salvar->getResultado()) { // Verifica se o produto foi cadastrado com sucesso
            $_SESSION['_sheep_firewall'] = hash('sha512', random_int(100, 5000));
            // Gera um novo token de segurança para a próxima requisição
            if (!empty($_FILES['fotos']['tmp_name'][0])) { //$_FILES['fotos']['tmp_name'] é um array, não uma string, por isso precisa de [0]
                // Verifica se o usuário enviou fotos adicionais (além da capa)

                Formata::galeriaImagens('produto', SHEEP_IMG_PRODUTOS, $_FILES['fotos'], $salvar->getResultado(), $criar['tipo']);
                // Chama o método galeriaImagens para processar as fotos adicionais
            }
            //Se tudo der certo redireciona o usuário pra pagina de sucesso
            header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . FILTROS . "cliente/sheep-painel/index&sucesso=true&token={$_SESSION['timeWT']}");
        } else {
            header("Location: " . URL_CAMINHO_PAINEL_CLIENTE . FILTROS . "cliente/sheep-painel/index&erro=true&token={$_SESSION['timeWT']}");
            // Se algo deu errado, redireciona para a página de erro
        }
    }
    ?>
</div>