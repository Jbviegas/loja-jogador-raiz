<div class="main-content">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4>Faturamento Anual</h4>
            </div>
            <div class="card-body">
                <?php
                $ano = date('Y');
                $mes = date('m');
                $totalValorFinal = 0; // Inicializa a soma dos valores
                ?>
                <div class="table-responsive">

                    <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Ano</th>
                                <th>Data/Hora</th>
                                <th>Cliente</th>
                                <th>N° do Pedido</th>
                                <th>Valor Total</th>
                                <th>Status da Fatura</th>
                                <th></th>
                                <th>Faturamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $lerRelatorio = new Ler();
                            $lerRelatorio->Leitura('faturas', "WHERE status = 'paid' AND finalizado = 'S' AND ano = :ano ORDER BY data DESC", "ano={$ano}");
                            if ($lerRelatorio->getResultado()) {
                                foreach ($lerRelatorio->getResultado() as $relatorio) {
                                    $relatorio = (object) $relatorio;
                                    $totalValorFinal += $relatorio->valor_total; // Soma os valores
                            ?>
                                    <tr>
                                        <td> <?= $relatorio->ano ?> </td>
                                        <td> <?= $relatorio->ultima_atualizacao ?> </td>
                                        <td><?= $relatorio->cliente_nome ?></td>
                                        <td> <?= $relatorio->transacao ?> </td>
                                        <td> <?= number_format($relatorio->valor_total, 2, ',', '.') ?> </td>
                                        <td>
                                            <?php if ($relatorio->status == 'paid' && $relatorio->finalizado == 'S') { ?>
                                                <a href="#" class="alert-success">Finalizada</a>
                                            <?php } else { ?>
                                                <a href="#" class="alert-warning">Pendente</a>
                                            <?php } ?>
                                        </td>

                                        <td> <a href="#" data-toggle="modal" data-target="#ver<?= $relatorio->transacao ?>">||</a></td>
                                        </td>

                                        <td><?= $relatorio->faturamentoanual ?></a></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right"><strong>Valor Final:</strong></td>
                                <td><strong><?= number_format($totalValorFinal, 2, ',', '.') ?></strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="recent-report__chart">
                    <canvas id="meuGrafico" style="height:300px;"></canvas>
                </div>

            </div>
        </div>

    </section>
    <!-- INICIO MODAL  DETALHES DA COMPRA  MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <?php
    $ler = new Ler();
    $ler->Leitura('faturas');
    if ($ler->getResultado()) {
        foreach ($ler->getResultado() as $relatorio) {
            $relatorio = (object) $relatorio;
    ?>
            <!-- basic modal -->
            <div class="modal fade" id="ver<?= $relatorio->transacao ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> Faturamento do Ano de <?= $relatorio->ano ?> :</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <span>
                                <?php if ($relatorio->faturamentoanual == "" && $relatorio->finalizado == 'S') { ?>
                                    <span>
                                        <form action="<?= URL_CAMINHO_PAINEL . FILTROS . "sheep-relatorios/filtros/valoranual&token={$_SESSION['timeWT']}" ?>" method="post">
                                            <input type="text" name="faturamentoanual" class="form-control" placeholder="Adicione o Valor do Faturamento">
                                            <input type="hidden" name="id" value="<?= $relatorio->transacao ?>">
                                            <input type="hidden" name="sheep_firewall" value="<?= $_SESSION['_sheep_firewall'] ?>"><br>
                                            <button type="submit" class="btn btn-primary" name="sendValor">Enviar Valor</button>
                                        </form>
                                    </span>
                                <?php } else { ?>
                                    <?= $relatorio->faturamentoanual ?></a>
                                <?php } ?>
                            </span>
                            <br>
                            <br>
                            <p> Mês :<?= $relatorio->mes ?> </p>
                            <p>Valor da Fatura : <?= number_format($relatorio->valor_total, 2, ',', '.') ?> </p>
                            <p>Status da Fatura :
                                <?php if ($relatorio->status == 'paid' && $relatorio->finalizado == 'S') { ?>
                                    <a href="#" class="alert-success">Finalizada</a>
                                <?php } else { ?>
                                    <a href="#" class="alert-warning">Pendente</a>
                                <?php } ?>
                            </p>
                            <p> Data/Hora : <?= $relatorio->ultima_atualizacao ?> </p>
                            <p>Cliente :<?= $relatorio->cliente_nome ?></p>
                            <p>N° do Pedido : <?= $relatorio->transacao ?> </p>
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


</div>