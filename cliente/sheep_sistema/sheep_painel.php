<div class="main-content">

  <!-- INICIO NAVEGAÇÃO --->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL_CLIENTE ?>sheep.php">Inicio</a></li>
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
              <h4>Compras Recentes</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover" id="save-stage" style="width:100%;">

                  <tbody>
                    <?php
                    if (!$sheep instanceof Ler) {
                      $sheep = new Ler();
                    }
                    $sheep->Leitura('minhas_compras', "WHERE id_cliente = :id ORDER BY id DESC", "id={$_SESSION['sheep_user']['id']}");
                    $minhasCompras = Formata::Resultado($sheep);
                    if ($minhasCompras) {
                      foreach ($sheep->getResultado() as $compras) {
                        $compras = (object) $compras;
                    ?>
                        <tr>
                          <td>
                            <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#ver<?= $compras->id ?>" style="margin-right:50px">Enviar Imagem<br>info. da Compra</a>

                            <?php
                            if ($compras->finalizado == 'N' && $compras->status == 'waiting') {
                              echo '<span class="alert-warning">Pendente</span>';
                            } elseif ($compras->finalizado == 'N' && $compras->status == 'paid') {
                              echo '<span class="alert-success">Aprovado</span>';
                            } elseif ($compras->finalizado == 'S') {
                              echo '<span class="alert-success">Finalizado</span>';
                            } elseif ($compras->finalizado == 'C' && $compras->status == 'expired') {
                              echo '<span class="alert-danger">Não Pago/Recusado</span>';
                            } elseif ($compras->finalizado == 'N' && $compras->status == 'unpaid') {
                              echo '<span class="alert-danger">Não pago/Recusado</span>';
                            } elseif ($compras->finalizado == 'C' && $compras->status == 'unpaid') {
                              echo '<span class="alert-danger">Não pago/Recusado</span>';
                            } elseif ($compras->finalizado == 'C' && $compras->status == 'waiting') {
                              echo '<span class="alert-danger">Pedido Cancelado</span>';
                            } elseif ($compras->finalizado == 'N' && $compras->status == 'canceled' || $compras->status == 'refunded') {
                              echo '<span class="alert-danger">Pedido Cancelado</span>';
                            } elseif ($compras->finalizado == 'C' && $compras->status == 'canceled' || $compras->status == 'refunded') {
                              echo '<span class="alert-danger">Pedido Cancelado</span>';
                            } elseif ($compras->status == 'contested') {
                              echo '<span class="alert-danger">Pagamento Contestado</span>';
                            } elseif ($compras->status == 'approved') {
                              echo '<span class="alert-danger">Aguardando a operadora do cartão liberar o pagamento</span>';
                            } else {
                              echo '<span class="alert-success">A caminho</span>';
                            }
                            ?>
                            <br><br>

                            <?php if ($compras->produto) { ?>
                              <img alt="<?= $compras->produto ?>" src="<?= SHEEP_IMG_PRODUTOS . $compras->capa ?>" style="width:50px; margin-right:5px">
                              <?= Formata::LimitaTextos($compras->produto, 4) ?><br><br>
                            <?php } else { ?>
                              <?= $compras->produto ?>
                            <?php } ?>

                            <?php
                            // Verifica se o código está disponível e é numérico
                            $codigoValido = $compras->status == 'paid'
                              && strtolower($compras->rastreio) != 'aguarde o envio'
                              && is_numeric($compras->rastreio);
                            ?>

                            <?php if ($codigoValido) { ?>
                              Código de Rastreio: <?= $compras->rastreio ?><br><br>

                              <p>Rastreie aqui!: <a href="https://rastreae.com.br/resultado/<?= urlencode($compras->rastreio) ?>" target="_blank">rastreae.com.br</a></p>


                            <?php } elseif ($compras->status == 'paid' && strtolower($compras->rastreio) != 'aguarde o envio') { ?>
                              Código de Rastreio: <?= $compras->rastreio ?>
                            <?php } else { ?>
                              Código de Rastreio: Aguarde o envio

                            <?php } ?>

                            <br><br>

                            <?php
                            // Verifica se o código é alfanumérico (contém pelo menos uma letra e um número)
                            $codigo = $compras->rastreio;
                            $codigoValido = $compras->status == 'paid'
                              && strtolower($codigo) != 'aguarde o envio'
                              && preg_match('/[a-zA-Z]/', $codigo) // contém letra
                              && preg_match('/[0-9]/', $codigo);   // contém número
                            ?>

                            <?php if ($codigoValido) { ?>

                              <p>Rastreie aqui!: <a href="https://www.correios.com.br/" target="_blank">correios.com.br</a></p>


                            <?php } ?>


                            <br><br>
                          </td>
                        </tr>


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

  <div class="card-header" style="margin-bottom: 10px;">
    <span style="margin-right: 40px; font-weight: bold; font-size: 20px;">Imagens Enviadas</span><a href="<?= URL_CAMINHO_PAINEL_CLIENTE . FILTROS . "sheep-produtos/imagens_enviadas&token={$_SESSION['timeWT']}" ?>" style="color: red; text-decoration: none;" title="imagens recebidas"> <button style="border-radius: 10px; background: blue; color: white; border: none; padding: 10px;">Ver</button></a></span>
  </div>

  <!-- INICIO MODAL SUPORTE --->
  <?php
  $sheep->Leitura('minhas_compras', "WHERE id_cliente = :id ", "id={$_SESSION['sheep_user']['id']}");
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


              <form action="<?= URL_CAMINHO_PAINEL_CLIENTE . FILTROS ?>sheep-produtos/filtros/criando&token=<?= $_SESSION['timeWT'] ?>" method="post" enctype="multipart/form-data">

                <div class="section-body" <?= $compras->personaliza_foto == 'PS' ? ' style="display:block"' : ' style="display:none"' ?>>
                  <div class="row">
                    <div class="col-12">
                      <div class="card">

                        <div class="card-footer text-right">
                          <a href="" class="btn btn-primary"><i class="fa fa-exclamation-circle"></i> Ajuda? </a>
                        </div>

                        <div class="card-header">
                          <h4>A imagem só poderá ser enviada uma única vez</h4>
                        </div>
                        <div class="card-body">

                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Resolução Mínima da imagem para uma boa impressão(1181px X 1772px)<br><br>
                              Resolução Ideal para uma Excelente impressão (2480px X 3508px) ou superior</label>
                            <div class="col-sm-12 col-md-7">
                              <div id="image-preview" class="image-preview" style="background-image: url('<?= HOME . "/uploading.png" ?>'); background-size: cover; background-position: center;">
                                <label for="image-upload" id="image-label">Buscar Imagem</label>

                                <input type="file" name="capa" id="image-upload" required />
                              </div>
                            </div>
                          </div>

                          <div class="form-group row mb-4">
                            <div class="col-md-7">
                              <input type="hidden" class="form-control" name="titulo" value="<?= $compras->produto ? "imagem personalizada" : null; ?>">
                            </div>
                          </div>

                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Dê um nome condizente com a imagem</label>

                            <div class="col-md-7">
                              <input type="text" class="form-control" name="titulo_b" value="" placeholder="Ex: Tio Patinhas" required>
                            </div>
                          </div>



                          <input type="hidden" name="transacao" value="<?= $compras->transacao ?>">
                          <input type="hidden" name="id_produto" value="<?= $compras->id_produto ?>">
                          <input type="hidden" name="usuario" value="<?= $_SESSION['sheep_user']['id'] ?>">
                          <input type="hidden" name="nome_cliente" value="<?= $compras->nome_cliente ?>">
                          <input type="hidden" name="sheep_firewall" value="<?= $_SESSION['_sheep_firewall'] ?>">
                          <input type="hidden" name="tipo" value="produto">
                          <input type="hidden" name="tipo_cadastro" value="criar">



                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                              <button type="submit" class="btn btn-lg btn-primary" name="sendSheep">Salvar</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>


              <!-- FIM MODAL SUPORTE --->
              <?php
              $sheep = null;
              ?>

              <div style="margin-bottom: 50px;">
                <img alt="<?= $compras->produto ?>" src="<?= SHEEP_IMG_PRODUTOS . $compras->capa ?>" style="width:200px; margin-right:5px">
                <p><?= $compras->produto ?></p>
              </div>

              <p>Status</p>
              <span>
                <?php
                if ($compras->finalizado == 'N' && $compras->status == 'waiting') {
                  echo '<span class="alert-warning">Pendente</span>';
                } elseif ($compras->finalizado == 'N' && $compras->status == 'paid') {
                  echo '<span class="alert-success">Aprovado</span>';
                } elseif ($compras->finalizado == 'S') {
                  echo '<span class="alert-success">Finalizado</span>';
                } elseif ($compras->finalizado == 'C' && $compras->status == 'expired') {
                  echo '<span class="alert-danger">Não Pago/Recusado</span>';
                } elseif ($compras->finalizado == 'N' && $compras->status == 'unpaid') {
                  echo '<span class="alert-danger">Não pago/Recusado</span>';
                } elseif ($compras->finalizado == 'C' && $compras->status == 'unpaid') {
                  echo '<span class="alert-danger">Não pago/Recusado</span>';
                } elseif ($compras->finalizado == 'C' && $compras->status == 'waiting') {
                  echo '<span class="alert-danger">Pedido Cancelado</span>';
                } elseif ($compras->finalizado == 'N' && $compras->status == 'canceled' || $compras->status == 'refunded') {
                  echo '<span class="alert-danger">Pedido Cancelado</span>';
                } elseif ($compras->finalizado == 'C' && $compras->status == 'canceled' || $compras->status == 'refunded') {
                  echo '<span class="alert-danger">Pedido Cancelado</span>';
                } elseif ($compras->status == 'contested') {
                  echo '<span class="alert-danger">Pagamento Contestado</span>';
                } elseif ($compras->status == 'approved') {
                  echo '<span class="alert-danger">Aguardando a operadora do cartão liberar o pagamento</span>';
                } else {
                  echo '<span class="alert-success">A caminho</span>';
                }
                ?>
              </span>
              <br>
              <br>
              <br>
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
              <p>Prazo de Entrega : 5 a 15 dias</p>
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