<!-- Main Content -->
<div class="main-content">

  <!-- INICIO NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL ?>sheep.php">Inicio</a></li>
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-categorias/index&token=<?= $_SESSION['timeWT'] ?>">Atualizar</a></li>
      <li class="breadcrumb-item active" aria-current="page">Departamentos</li>
    </ol>
  </nav>
  <!-- FIM NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

  <?php

  ?>

  <section class="section">

    <!-- INICIO TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <?php include_once('./token.php'); ?>
    <!-- FIM TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

    <?php
    $editar = filter_input(INPUT_GET, 'editar', FILTER_VALIDATE_INT);
    if (!$editar) {


    ?>

      <!-- INICIO FORMULARIO CRIAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
      <form action="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-categorias/filtros/criar&token=<?= $_SESSION['timeWT'] ?>" method="post">

        <div class="section-body">
          <div class="row">
            <div class="col-12">
              <div class="card">

                <div class="card-footer text-right">
                  <a href="" class="btn btn-primary" data-toggle="modal" data-target=".ajuda"><i class="fa fa-exclamation-circle"></i> Ajuda </a>
                </div>

                <div class="card-header">
                  <h4>Departamentos</h4>
                </div>
                <div class="card-body">

                  <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nome(Obrigatório)</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" name="nome" placeholder="Nome do departamento" required="">
                    </div>
                    <input type="hidden" name="usuario" value="<?= $_SESSION['sheep_user']['id'] ?>">
                    <input type="hidden" name="sheep_firewall" value="<?= $_SESSION['_sheep_firewall'] ?>">
                    <input type="hidden" name="tipo" value="categoria">
                    <input type="hidden" name="tipo_cadastro" value="criar">

                    <button type="submit" class="btn btn-lg btn-primary" style="float:left;" name="sendSheep">Salvar</button>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
  </section>
  <!-- FIM FORMULARIO CRIAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->


<?php
    } else {
      $ler = new Ler();
      $ler->Leitura('categorias', "WHERE id = :id", "id={$editar}");
      if ($ler->getResultado()) {
        foreach ($ler->getResultado() as $atualizarDep);
        $atualizarDep = (object) $atualizarDep;
      }
?>
  <!-- INICIO FORMULARIO ATUALIZAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
  <section class="section">
    <form action="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-categorias/filtros/atualizar&token=<?= $_SESSION['timeWT'] ?>" method="post">

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-footer text-right">
                <a href="" class="btn btn-primary"><i class="fa fa-exclamation-circle"></i> Lista </a>
              </div>

              <div class="card-header">
                <h4>Atualizar</h4>
              </div>
              <div class="card-body">

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nome(Obrigatório)</label>
                  <div class="col-md-7">
                    <input type="text" class="form-control" name="nome" placeholder="Nome do departamento" value="<?= $atualizarDep->nome ? $atualizarDep->nome : null; ?>" style="border: 1px solid red;">
                  </div>
                  <input type="hidden" name="id" value="<?= $editar ?>">
                  <input type="hidden" name="usuario" value="<?= $_SESSION['sheep_user']['id'] ?>">
                  <input type="hidden" name="sheep_firewall" value="<?= $_SESSION['_sheep_firewall'] ?>">
                  <input type="hidden" name="tipo" value="categoria">
                  <input type="hidden" name="tipo_cadastro" value="atualizar">
                  <button class="btn btn-lg btn-primary" style="float:left;" name="sendSheep">Salvar</button>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>
  <!-- FIM FORMULARIO ATUALIZAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<?php } ?>

<!-- INICIO LISTAGEM DE ESTADOS CRIAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<section class="section">
  <div class="section-body">

    <!-- INICIO TABELA  MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Departamentos</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                <thead>
                  <tr>
                    <th>Nº</th>
                    <th>Criado</th>
                    <th>Nome</th>
                    <th>Visitas</th>
                    <th>Editar</th>
                    <th>Excluir</th>

                  </tr>
                </thead>
                <tbody>

                  <?php
                  $sheep->Leitura('categorias', "WHERE tipo = 'categoria' ORDER BY data DESC");
                  $depatamentosSite = Formata::Resultado($sheep);
                  if ($depatamentosSite) {
                    foreach ($sheep->getResultado() as $departamento) {
                      $departamento = (object) $departamento;


                  ?>

                      <tr>
                        <td><?= $departamento->id ?></td>

                        <td> <?= date('d/m/Y', strtotime($departamento->data)) ?> </td>
                        <td><?= $departamento->nome ?  $departamento->nome : null; ?></td>
                        <td><?= $departamento->visitas ?  $departamento->visitas : 0; ?> </td>
                        <td><a href="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-categorias/index&editar=<?= $departamento->id ?>&token=<?= $_SESSION['timeWT'] ?>" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a></td>
                        <td>
                          <form action="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-categorias/filtros/excluir&token=<?= $_SESSION['timeWT'] ?>" method="post">
                            <input type="hidden" name="id" value="<?= $departamento->id ?>">
                            <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Deseja realmente excluir?')"><i class="fas fa-trash-alt"></i></button>
                          </form>
                        </td>
                      </tr>

                  <?php }
                  } ?>


                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
</section>
<!-- FIM LISTAGEM DE ESTADOS CRIAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

</div>


<!-- INICIO DA JANELA DE MODAL DE TREINAMENTO MAYKONSILVEIRA.COM.BR -->
<!-- Large modal -->
<div class="modal fade ajuda" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myLargeModalLabel">Fique tranquilo que vou te ajudar, veja o vídeo até o final 2x</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/ffuF8-Nebuw?rel=0" allowfullscreen></iframe>
        </div>


      </div>
    </div>
  </div>
</div>

<!-- FIM DA JANELA DE MODAL DE TREINAMENTO MAYKONSILVEIRA.COM.BR -->

<?php
$sheep = null;
$ler = null;
?>