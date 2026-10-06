<?php

            require_once('sheep_topo.php'); //Inclui o topo do painel

            $sheep_caminho_painel = '';
            //Esse $ms vem do sheep_checa.php
            if (!empty($ms)): //O valor que o usuário manda pela URL via GET (?m=sheep-usuarios), é usado para decidir qual página incluir dentro do painel.
                $sheep_caminho_painel = __DIR__ . '/sheep_sistema/' . strip_tags(trim($ms) . '.php');
            //_DIR_ cria o caminho direto para o diretório(pasta)->1 cliente ->pula(sheep_sistema) vai direto-> 2 ?m=sheep-usuarios/index.php
            else:
                $sheep_caminho_painel = __DIR__ . '/sheep_sistema/' . 'sheep_painel.php';
            //Se $ms está vazio __DIR__ carrega(pasta)->1 cliente ->pula(sheep_sistema) vai direto-> 2 sheep_painel.php(sheep.php), página inicial do painel.
            endif;

            if (file_exists($sheep_caminho_painel)):
                //Se o arquivo existe 
                include_once($sheep_caminho_painel);
            //ele é incluído e mostrado na tela
            else:
                //Se o arquivo não existe
                echo "Erro ao acessar a página /" . (isset($ms) ? $ms : '') . ".php!"; //Mostra mensagem de erro
                unset($_SESSION['sheep_user']); //Derruba a sessão do usuário
                header('Location: ' . HOME); //Redireciona para a página inicial do site

            endif;

            // rodape Maykon Silveira
            require_once('sheep_rodape.php'); //Inclui o rodapé do painel
            ?>

          <script>
              window.addEventListener("pageshow", function(event) { //Atualiza a pagina quando o usuário volta
                  if (event.persisted) {
                      location.reload();
                  }
              });
          </script>