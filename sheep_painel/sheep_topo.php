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
 <link rel="icon" type="image/png" href="<?= HOME ?>/img-logo/images/2025/02/nome2025-02-26-21-19-icone-1740615569.png">
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
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                <i data-feather="align-justify"></i>
              </a></li>
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
          <?php
          $diaTopo = date('d');
          $mesTopo = date('m');
          $anoTopo = date('Y');

          $lerTopo = new Ler();
          $lerTopo->Leitura(
            'minhas_compras',
            "WHERE status = 'paid' AND dia = :dia AND mes = :mes AND ano = :ano ORDER BY dia DESC",
            "dia={$diaTopo}&mes={$mesTopo}&ano={$anoTopo}"
          );

          if ($lerTopo->getResultado()) {
            $contaCompraTopo = $lerTopo->getContaLinhas();
          } else {
            $contaCompraTopo = 0;
          }
          ?>


          <li class="dropdown dropdown-list-toggle"><a href="<?= FILTROS ?>sheep-compras/aprovados_dia&token=<?= $_SESSION['timeWT'] ?>" data-toggle="dropdown"
              class="nav-link nav-link-lg message-toggle"><i data-feather="bell" class="bell"></i>
              <span class="badge headerBadge1">
                <?= $contaCompraTopo ?>
              </span> </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Compras Recentes
                <div class="float-right">

                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                <?php
                if ($lerTopo->getResultado()) {
                  foreach ($lerTopo->getResultado() as $compras) {
                    $compras = (object) $compras;
                ?>
                    <a href="<?= FILTROS ?>sheep-compras/aprovados_dia&token=<?= $_SESSION['timeWT'] ?>" class="dropdown-item">
                      <span class="dropdown-item-avatartext-white mr-2">
                        <img alt="image" src="<?= HOME ?>/img-produtos/<?= $compras->capa ?>" class="rounded-circle" style="width:30px; height:auto;">
                      </span>
                      <span class="time messege-text"><?= Formata::LimitaTextos($compras->produto, 2) ?></span>
                      <span class="time"><?= date('d', strtotime($compras->data)) ?></span>
                      </span>
                    </a>
                <?php }
                } ?>

              </div>
              <div class="dropdown-footer text-center">
                <a href="<?= FILTROS ?>sheep-compras/aprovados_dia&token=<?= $_SESSION['timeWT'] ?>">Ver todos <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <?php
          $lerTopo->Leitura('usuarios', "WHERE id = :id", "id={$_SESSION['sheep_user']['id']}");
          $adminTopo = Formata::Resultado($lerTopo);
          if ($adminTopo) {
            foreach ($lerTopo->getResultado() as $adminTop);
            $adminTop = (object) $adminTop;
          }

          ?>
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">

              <?php if ($adminTop->foto) { ?>
                <img alt="" src="<?= HOME ?>/uploads/fotos-usuarios/<?= $adminTop->foto ?>" class="user-img-radious-style">
              <?php } else { ?>
                <img alt="<?= $adminTop->nome ?>" src="assets/img/sem-imagem.png" class="user-img-radious-style">
              <?php } ?>
              <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title"> <?= $adminTop->nome ?> </div>

              <a href="<?= URL_CAMINHO_PAINEL . FILTROS . "sheep-usuarios/atualizar&editar={$adminTop->id}&token={$_SESSION['timeWT']}" ?>" class="dropdown-item has-icon"> <i class="farfa-user"></i>
                Perfil
              </a>

              <!--<a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
Atividades
</a>-->

              <a href="<?= FILTROS ?>sheep-dados/index&token=<?= $_SESSION['timeWT'] ?>" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Configurações
              </a>
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