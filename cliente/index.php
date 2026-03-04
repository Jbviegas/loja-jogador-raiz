<?php
require('../sheep_core/config.php');
require_once('sheep_top_login.php');


?>

<body>

  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-dark">

              <div class="card-header">
                <center>
                  <img src="<?= HOME ?>/uploads/img-logo/images/2024/10/icone-loja.png" width="100px" alt="<?= SITENAME ?>" class="img-fluid">
                </center>

                <ul>
                  <li onclick="history.back()" style="margin-left: 15px; cursor:pointer; display:flex; align-items:center; font-weight:bold; color:black">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                      <path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
                    </svg><span> Voltar</span>
                  </li>
                </ul>

              </div>

              <?php
              $camposVazios = filter_input(INPUT_GET, 'campos_vazios', FILTER_VALIDATE_BOOLEAN);
              //Se o usuário mandar 'campos_vazios' = true através da URL:
              if ($camposVazios):// Verifica se existe 'campos_vazios', se sim exibe a mensagem("Prezado Cliente, Por gentileza, preencha todos os campos!")
              ?>
                <div class="alert alert-warning alert-has-icon" style="margin:3px auto;">
                  <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">Prezado Cliente</div>
                    Por gentileza, preencha todos os campos!
                  </div>
                </div>

              <?php endif; ?>

              <?php
              $senhaInvalida = filter_input(INPUT_GET, 'senha_errada', FILTER_VALIDATE_BOOLEAN);
               //Se o usuário mandar 'senha_errada' = true através da URL:
              if ($senhaInvalida):// Verifica se existe 'senha_errada', se sim exibe a mensagem("Olá Cliente! A senha, ou, e-mail não existe no sistema!")
              ?>
                <div class="alert alert-danger alert-has-icon" style="margin:3px auto;">
                  <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">Olá Cliente!</div>
                    A senha, ou, e-mail não existe no sistema!
                  </div>
                </div>

              <?php endif; ?>

              <?php
              $saiuSistema = filter_input(INPUT_GET, 'sheep_saiu', FILTER_VALIDATE_BOOLEAN);
               //Se o usuário mandar 'sheep_saiu' = true através da URL:
              if ($saiuSistema):// Verifica se existe 'sheep_saiu', se sim exibe a mensagem("Prezado Cliente, Você saiu do sistema, Volte sempre!")
              ?>
                <div class="alert alert-success alert-has-icon" style="margin:3px auto;">
                  <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">Prezado Cliente</div>
                    Você saiu do sistema, Volte sempre!
                  </div>
                </div>
              <?php endif; ?>

              <!--

                  <div class="alert alert-danger alert-has-icon" style="margin:3px auto;">
                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                    <div class="alert-body">
                      <div class="alert-title">Olá Cliente!</div>
                      Atenção! Você foi bloqueado, por favor entre em contato com o administrador do sistema <?= EMAIL ?>
                    </div>
                  </div>

         



           

                <div class="alert alert-success alert-has-icon" style="margin:4px auto;">
                  <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">Prezado Cliente</div>
                    Senha modificada com sucesso! Tente logar no mínimo 3x para validar a sua senha :)
                  </div>
                </div>

         

                <div class="alert alert-success alert-has-icon" style="margin:4px auto;">
                  <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">Prezado Cliente</div>
                    Foi enviado para o seu e-mail o link para a recuperação da senha, verifique a sua caixa de entrada, caso não esteja lá, verifique a lixeira, ou, o spam :)!
                  </div>
                </div>

              
                <div class="alert alert-danger alert-has-icon" style="margin:3px auto;">
                  <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">Prezado Cliente</div>
                    Sua conta foi cancelada, por gentileza entrar em contato com o suporte!
                  </div>
                </div>
-->

              <div class="card-body">
                <span>Fazer Login na sua conta</span><br><br>
                <form method="post" action="sheep-filtros/entrar.php" class="needs-validation" novalidate="">
                    <!-- Envia o formulário para "sheep-filtros/entrar.php" -->
                  <div class="form-group">
                    <label for="email">E-mail</label>
                    <input id="email" type="email" class="form-control border border-dark p-3" name="email" tabindex="1" placeholder="Digite seu e-mail" required autofocus>
                    <div class="invalid-feedback">
                      Seu e-mail
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Senha</label>
                      <div class="float-right">
                        <a href="sheep_recuperar.php" class="text-small text-danger">
                          Esqueceu sua senha ou email?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control border border-dark p-3" name="senha" placeholder="Digite sua senha" tabindex="2" required>
                    <div class="invalid-feedback">
                      Qual é sua Senha?
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-dark btn-lg btn-block" style="background-color: rgba(22, 22, 22, 0.85);" tabindex="3">
                      Entrar
                    </button>
                  </div>
                </form>

                <?php require_once('sheep_rodape_login.php'); ?>
              </div>


              <script>
                window.addEventListener("pageshow", function(event) {// Atualiza a página
                  if (event.persisted) {
                    location.reload();
                  }
                });
              </script>