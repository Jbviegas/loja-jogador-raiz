<div class="main-content">

  <!-- INICIO NAVEGAÇÃO --->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL_CLIENTE ?>sheep.php">Inicio</a></li>
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL_CLIENTE . FILTROS ?>sheep-produtos/index&token=<?= $_SESSION['timeWT'] ?> ">Minhas Compras</a></li>
      <li class="breadcrumb-item active" aria-current="page">Compras Pendentes</li>
    </ol>
  </nav>
  <!-- FIM NAVEGAÇÃO --->

  <section class="section">
    <div class="section-body">

      <!-- INICIO TABELA   -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>Compras Pendentes</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover" id="save-stage" style="width:100%;">

                  <tbody>
                    <?php
                    /*if (!$sheep instanceof Ler) {
                                            $sheep = new Ler();
                                        }
                    */
                    $sheep->Leitura('minhas_compras', "WHERE id_cliente = :id AND status = 'waiting' ORDER BY id DESC", "id={$_SESSION['sheep_user']['id']}");
                    $minhasCompras = Formata::Resultado($sheep);
                    if ($minhasCompras) {
                      foreach ($sheep->getResultado() as $compras) {
                        $compras = (object) $compras;
                    ?>
                        <tr>

                          <td> <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#ver<?= $compras->id ?>" style="margin-right:50px"> Ver </a>
                            <?php
                            if ($compras->finalizado == 'N' && $compras->status == 'waiting') {
                              echo '<span class="alert-warning">Pendente</span>';
                            }
                            ?>
                            <br>
                            <br>

                            <?php if ($compras->produto) { ?>
                              <img alt="<?= $compras->produto ?>" src="<?= SHEEP_IMG_PRODUTOS . $compras->capa ?>" style="width:50px; margin-right:5px">
                              <?= Formata::LimitaTextos($compras->produto, 4) ?><br><br>
                            <?php } else { ?>
                              <?= $compras->produto ?>
                            <?php } ?>
                            Código de Rastreio : <?= $compras->finalizado == 'S' ? $compras->rastreio : '<span class="alert-warning">Aguarde</span>' ?><br><br>
                            <a href="https://www.correios.com.br/" target="_blank">
                              Rastrear Pedido
                            </a>
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

  <?php
  // Leitura da tabela, ordenando pela data mais recente primeiro
  $sheep->Leitura(
    'produto_cliente',
    "WHERE tipo = 'produto' AND usuario = :id ORDER BY data DESC",
    "id={$_SESSION['sheep_user']['id']}"
  );

  $minhasCompras = Formata::Resultado($sheep);

  if ($minhasCompras) {
    foreach ($sheep->getResultado() as $compras) {
      $compras = (object) $compras;

      // Caminho da imagem (verifica se é URL ou arquivo local)
      $imgSrc = (!empty($compras->capa))
        ? (filter_var($compras->capa, FILTER_VALIDATE_URL)
          ? $compras->capa
          : SHEEP_IMG_PRODUTOS . $compras->capa)
        : "assets/img/sem-imagem.png";
  ?>
  <?php
    }
  }
  ?>

  <!-- INICIO MODAL SUPORTE --->
  <?php
  $sheep->Leitura('minhas_compras', "WHERE id_cliente = :id AND status = 'waiting'", "id={$_SESSION['sheep_user']['id']}");
  $minhasCompras = Formata::Resultado($sheep);
  if ($minhasCompras) {
    foreach ($sheep->getResultado() as $compras) {
      $compras = (object) $compras;
  ?>
      <!-- basic modal -->
      <div class="modal fade" id="ver<?= $compras->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><?= $compras->produto ?> </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>

              <p>Status</p>
              <span>
                <?php if ($compras->status == 'paid' || $compras->status == 'approved') { ?>
                  <a href="#" class="btn btn-success">Aprovado</a>
                <?php } else { ?>
                  <a href="#" class="btn btn-warning">Pendente</a>
                <?php } ?>
              </span>
              <br>
              <br>
              <br>
              <p>Produto : <?= $compras->produto ?></p>
              <p>N° Pedido : <?= $compras->transacao ?></p>
              <p>Tamanho : <?= $compras->tamanho ?></p>
              <p>Personalização :
                <?php if ($compras->numero_camisa === '0') { ?>
                  <?= $compras->numero_camisa = " " ?>
                <?php } else { ?>
                  <?= $compras->numero_camisa ?>
                <?php } ?>

                <?php if ($compras->nome_camisa === '- -') { ?>
                  <?= $compras->nome_camisa = " " ?>
                <?php } else { ?>
                  <?= $compras->nome_camisa ?>
                <?php } ?>
              </p>
              <p>Data da Compra: <?= date('d/m/Y', strtotime($compras->data)) ?></p>
              <p>Valor : R$ <?= Formata::vr($compras->valor_produto) ?></p>
              <p>Quantidade : <?= $compras->quantidade ?></p>
              <!-- <p>Transportadora:</p> -->
              <p>Valor do Frete : Grátis</p>
              <p>Prazo de Entrega : 5 a 14 dias</p>
              <p>Endereco : <?= $compras->endereco ?></td>
              <p>Numero da rua : <?= $compras->numero ?></td>
              <p>CEP : <?= $compras->cep ?></td>
              <p>Cidade : <?= $compras->cidade ?></td>
              <p>Estado : <?= $compras->estado ?></td>
              <p>Bairro : <?= $compras->bairro ?></td>
            </div>
            <div class="modal-footer bg-whitesmoke br">
              <button type="button" class="btn btn-danger" data-dismiss="modal">x</button>
            </div>
          </div>
        </div>
      </div>
  <?php }
  } ?>
  <!-- FIM MODAL SUPORTE --->
  <?php
  $sheep = null;
  ?>

</div>