<div class="main-content">

  <!-- INICIO NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL ?>sheep.php">Inicio</a></li>
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-produtos/criar&token=<?= $_SESSION['timeWT'] ?> ">Novo</a></li>
      <li class="breadcrumb-item active" aria-current="page">Listar</li>
    </ol>
  </nav>
  <!-- FIM NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

  <section class="section">
    <div class="section-body">
      <!--INICIO LINKS TOPO clientesPR.COM.BR MAYKON SILVEIRA--->
      <?php include_once 'topo.php'; ?>
      <!--FIM LINKS TOPO clientesPR.COM.BR MAYKON SILVEIRA--->

      <!-- INICIO TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
      <?php include_once('./token.php'); ?>
      <!-- FIM TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

      <!-- INICIO TABELA  MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Produtos Ativos</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                  <thead>
                    <tr>
                      <th>Nº</th>
                      <th>Foto</th>
                      <th>Criado</th>
                      <th>Titulo</th>
                      <th>Valor</th>
                      <th>Departamento</th>
                      <th>Estoque</th>
                      <th>Visitas</th>
                      <th>Editar</th>
                      <th>Excluir</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sheep->Leitura('produto', "WHERE tipo = 'produto' ORDER BY data DESC");
                    $produtoSite = Formata::Resultado($sheep);
                    if ($produtoSite) {
                      foreach ($sheep->getResultado() as $produto) {
                        $produto = (object) $produto;

                        $estoqueBaixo = null;

                        if (in_array($produto->estoque, [1, 2, 3, 4, 5])) {
                          $estoqueBaixo = 'style="background:#f0f2a0;"';
                        } elseif ($produto->estoque === 0) {
                          $estoqueBaixo = 'style="background:#f2a5a0;"';
                        } else {
                          $estoqueBaixo = null;
                        }


                        $sheep->Leitura('categorias', "WHERE id = :id", "id={$produto->id_categoria}");
                        $CategoriasSite = Formata::Resultado($sheep);
                        if ($CategoriasSite) {
                          foreach ($sheep->getResultado() as $categoria);
                          $categoria = (object) $categoria;
                        }
                    ?>
                        <tr <?= $estoqueBaixo ?>>
                          <td><?= $produto->id ?></td>

                          <td>
                            <a href="#" data-toggle="modal" data-target="#ver<?= $produto->id ?>">
                              <?php if ($produto->capa) { ?>
                                <img src="<?= SHEEP_IMG_PRODUTOS . $produto->capa ?>" alt="<?= $produto->titulo ?>" width="35">
                              <?php } else { ?>
                                <img src="assets/img/sem-imagem.png" alt="<?= $produto->titulo ?>" width="35">
                              <?php } ?>
                            </a>
                          </td>

                          <td><?= date('d/m/Y', strtotime($produto->data)) ?></td><!--strtotime converte a data para o formato timestamp e date é usado para formatar a data-->
                          <td> <?= $produto->titulo ?> </td>
                          <td><b>R$ <?= $produto->valor ? $produto->valor : 0; ?></b></td>
                          <td><?= $categoria->nome ?></td>
                          <td><?= $produto->estoque ? $produto->estoque : 0; ?></td>
                          <td><?= $produto->visitas ? $produto->visitas : 0; ?></td>
                          <td><a href="<?= URL_CAMINHO_PAINEL . FILTROS . "sheep-produtos/atualizar&editar={$produto->id}&token={$_SESSION['timeWT']}" ?>" class="btn btn-icon btn-primary"><i class="far fa-edit"></i></a></td>
                          <td>

                            <form action="<?= URL_CAMINHO_PAINEL . FILTROS . 'sheep-produtos/filtros/excluir&token=' . $_SESSION['timeWT'] ?>" method="post">
                              <input type="hidden" name="sheep-firewall" value="<?= $_SESSION['_sheep_firewall'] ?>">
                              <input type="hidden" name="id" value="<?= $produto->id ?>">
                              <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Deseja Realmente Excluir')"><i class="fas fa-trash-alt"></i></button>
                            </form>

                          </td>
                        </tr>
                    <?php
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
  <?php
  $ler = new Ler();
  $ler->Leitura('produto', "WHERE tipo = 'produto' ORDER BY data DESC");
  if ($ler->getResultado()) {
    foreach ($ler->getResultado() as $produto) {
      $produto = (object) $produto;

  ?>
      <!-- INICIO MODAL SUPORTE MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
      <!-- basic modal -->
      <div class="modal fade" id="ver<?= $produto->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><?= $produto->titulo ?></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>
                <?php if ($produto->capa) { ?>
                  <img alt="<?= $produto->titulo ?>" src="<?= SHEEP_IMG_PRODUTOS . $produto->capa ?>" style="width:100%;">
                <?php } else { ?>
                  <img alt="<?= $produto->titulo ?>" src="assets/img/sem-imagem.png" style="width:100%;">
                <?php } ?>

              </p>
              <p>Criado(a): <?= date('d/m/Y', strtotime($produto->data)) ?></p>
              <p>Titulo: <?= $produto->titulo ?></p>
              <p>Tamanho: <?= $produto->tamanho_p ?></p>
              <p>Tamanho: <?= $produto->tamanho_m ?></p>
              <p>Tamanho: <?= $produto->tamanho_g ?></p>
              <p>Tamanho: <?= $produto->tamanho_gg ?></p>
              <p>Tamanho: <?= $produto->tamanho_xg ?></p>
              <p>Tamanho: <?= $produto->tamanho_lllxl ?></p>
              <p>Tamanho: <?= $produto->tamanho_llll_xl ?></p>

              <p>Valor: R$ <?= $produto->valor ?></p>
            </div>

            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-danger" data-dismiss="modal">x</button>
            </div>
          </div>
        </div>
      </div>
  <?php
    }
  }
  ?>
  <!-- FIM MODAL SUPORTE MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
  <?php
  $sheep = null;
  $ler = null;
  ?>
</div>