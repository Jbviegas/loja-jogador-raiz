<div class="main-content">

    <!-- INICIO TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <?php include_once('./token.php'); ?>
    <!-- FIM TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <!-- INICIO NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL ?>sheep.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-produtos/index&token=<?= $_SESSION['timeWT'] ?> ">Listas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Compras Pendentes Mês</li>
        </ol>
    </nav>
    <!-- FIM NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

    <section class="section">
        <div class="section-body">
            <?php
            $ano = date('Y');
            $mes = date('m');
            ?>

            <!-- INICIO TABELA  MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Compras Pendentes do Mês</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Nº</th>
                                            <th>Capa</th>
                                            <th>Mês</th>
                                            <th>Data</th>
                                            <th>Cliente</th>
                                            <th>ID</th>
                                            <th>Produto</th>
                                            <th>Pedido Nº</th>
                                            <th>QTD</th>
                                            <th>Valor</th>
                                            <th>Status Pedido</th>
                                            <th>Ver +</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        if (!$sheep instanceof Ler) {
                                            $sheep = new Ler();
                                        }

                                        $sheep->Leitura('minhas_compras',  "WHERE status = 'waiting' AND mes = :mes ORDER BY data DESC", "mes={$mes}");
                                        $minhasCompras = Formata::Resultado($sheep);
                                        if ($minhasCompras) {
                                            foreach ($sheep->getResultado() as $compras) {
                                                $compras = (object) $compras;

                                                $corFinalizaCompra = $compras->finalizado == 'S' ? 'style="background:#c5faea;"' : null;
                                        ?>
                                                <tr <?= $corFinalizaCompra ?>>
                                                    <td><?= $compras->id ?></td>
                                                    <td>
                                                        <a href="#" data-toggle="modal" data-target="#ver">
                                                            <?php if ($compras->capa) { ?>
                                                                <img alt="<?= $compras->produto ?>" src="<?= SHEEP_IMG_PRODUTOS . $compras->capa ?>" width="35">
                                                            <?php } else { ?>
                                                                <img alt="<?= $compras->produto ?>" src="assets/img/sem-imagem.png" width="35">
                                                            <?php } ?>

                                                        </a>
                                                    </td>
                                                    <td><?= date('m', strtotime($compras->data)) ?></td>
                                                    <td><?= date('d/m/Y', strtotime($compras->data)) ?></td>
                                                    <td><?= $compras->nome_cliente ?></td>
                                                    <td><?= $compras->id_cliente ?></td>
                                                    <td><?= Formata::LimitaTextos($compras->produto, 2) ?></td>
                                                    <td><?= $compras->transacao ?></td>
                                                    <td><?= $compras->quantidade ?></td>
                                                    <td>R$ <?= Formata::vr($compras->valor_produto  * $compras->quantidade) ?></td>

                                                    <td>
                                                        <?php if ($compras->status == 'paid' || $compras->status == 'approved') { ?>
                                                            <a href="#" class="btn btn-success">Aprovado</a>
                                                        <?php } elseif ($compras->status == 'unpaid') { ?>
                                                            <a href="#" class="btn btn-danger">Recusado</a>
                                                        <?php } elseif ($compras->status == 'refunded' || $compras->status == 'canceled' || $compras->finalizado == 'C') { ?>
                                                            <a href="#" class="alert-danger">Cancelado</a>
                                                        <?php } else { ?>
                                                            <a href="#" class="btn btn-warning">Pendente</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td> <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ver<?= $compras->id ?>">Ver </a></td>
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

    <!-- INICIO MODAL  DETALHES DA COMPRA  MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <?php
    $ler = new Ler();
    $ler->Leitura('minhas_compras');
    if ($ler->getResultado()) {
        foreach ($ler->getResultado() as $compras) {
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
                                <?php if ($compras->capa) { ?>
                                    <img alt="<?= $compras->produto ?>" src="<?= SHEEP_IMG_PRODUTOS . $compras->capa ?>" style="width:100%;">
                                <?php } else { ?>
                                    <img alt="<?= $compras->produto ?>" src="assets/img/sem-imagem.png" style="width:100%;">
                                <?php } ?>
                            </p>

                            <p>Status Pedido</p>
                            <span>
                                <?php if ($compras->status == 'paid' || $compras->status == 'approved') { ?>
                                    <a href="#" class="btn btn-success">Aprovado</a>
                                <?php } elseif ($compras->status == 'unpaid') { ?>
                                    <a href="#" class="btn btn-danger">Recusado</a>
                                <?php } elseif ($compras->status == 'refunded' || $compras->status == 'canceled' || $compras->finalizado == 'C') { ?>
                                    <a href="#" class="btn btn-danger">Cancelado</a>
                                <?php } else { ?>
                                    <a href="#" class="btn btn-warning">Pendente</a>
                                <?php } ?>
                            </span>
                            <br>
                            <br>
                            <br>
                            <p>Cliente: <?= $compras->nome_cliente ?></p>
                            <p>ID:<?= $compras->id_cliente ?></p>
                            <p>Whatsapp: <?= $compras->whatsapp ?></p>
                            <p>CPF: <?= $compras->cpf ?></p>
                            <p>E-mail: <?= $compras->email ?></p>
                            <p>Produto : <?= $compras->produto ?></p>
                            <p>N° Pedido : <?= $compras->transacao ?></p>
                            <p>Grupo do Produto:<?= $compras->id_sessao ?></td>
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
                            <p>Prazo de Entrega : 14 dias</p>
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
    <!-- FIM MODAL DETALHES DA COMPRA MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->



    <!-- INICIO MODAL ENVIO DE RASTREIO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

    <!-- basic modal -->
    <div class="modal fade" id="rastreio<?= $compras->transacao ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rastreio da Transação Nº <?= $compras->transacao ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                    <form action="<?= URL_CAMINHO_PAINEL . FILTROS . "sheep-compras/filtros/rastreio&token={$_SESSION['timeWT']}" ?>" method="post">
                        <input type="text" name="rastreio" class="form-control" placeholder="Adicione o número do rastreio">
                        <input type="hidden" name="id" value="<?= $compras->transacao ?>">
                        <input type="hidden" name="sheep_firewall" value="<?= $_SESSION['_sheep_firewall'] ?>"> <br>
                        <button type="submit" class="btn btn-primary" name="sendRastreio">Enviar Rastreio</button>
                    </form>
                    </p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">x</button>
                </div>
            </div>
        </div>
    </div>

    <!-- FIM MODAL ENVIO DE RASTREIO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <?php
    $sheep = null;
    $ler = null;
    ?>

</div>