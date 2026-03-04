<?php
require_once("sheep_checa.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= SHEEP_TITULO_PAINEL ?></title>
  <!-- Sheep CSS -->
  <?php require_once('sheep_css.php') ?>
  <!-- Sheep CSS -->
  <link rel="icon" type="image/png" href="<?= HOME ?>/uploads/img-logo/images/2025/02/nome2025-02-26-21-19-icone-1740615569.png">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

  <script>
    var base_url = "<?= HOME ?>/";
    var base_img_produtos = "<?= HOME . '/uploads/img-produtos/' ?>/";
  </script>
  
  <!--<div class="loader"></div>-->
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
            <!--<li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Buscar..." aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li>-->
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <?php
              $lerUsuario = new Ler();
              $lerUsuario->Leitura('usuarios', "WHERE id = :id", "id={$_SESSION['sheep_user']['id']}");
              if ($lerUsuario->getResultado()) {
                foreach ($lerUsuario->getResultado() as $cliente);
                $cliente = (object) $cliente;
              }
              ?>
              <?php if ($cliente->foto) { ?>
                <img alt="<?= $cliente->nome ?>" src="<?= SHEEP_IMG_USUARIOS . $cliente->foto ?>" width="35px" height="30px" class="user-img-radious-style">
              <?php } else { ?>
                <img alt="<?= $cliente->nome ?>" src="assets/img/sem-imagem.png" class="user-img-radious-style">
              <?php } ?>
              <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title"> <?= Formata::Comprimento() . ' ' . $cliente->nome ?> </div>

              <a href="sheep.php?m=sheep-usuarios/index&token=<?= $_SESSION['timeWT'] ?>" class="dropdown-item has-icon text-dark"> <i class="far
										fa-user"></i> Minha conta
              </a>

              <div class="dropdown-divider"></div>
              <span style="cursor:pointer; margin:25px;"><a href="<?= HOME ?>" style="color:black; text-decoration:none">
                  <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                    <path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z" />
                  </svg>
                  Voltar a loja</a></span>

              <div class="dropdown-divider"></div>
              <a href="sheep.php?sair=true" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Sair
              </a>
            </div>
          </li>

        </ul>
      </nav>




      <!--MENU LATERAL WEBTECPR.COM.BR MAYKON SILVEIRA--->
      <?php include_once('sheep_menu.php'); ?>
      <!--FIM MENU LATERAL WEBTECPR.COM.BR MAYKON SILVEIRA--->