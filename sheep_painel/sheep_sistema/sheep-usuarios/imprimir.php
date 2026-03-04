<div class="main-content">


    <!-- INICIO NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="sheep.php">Inicio</a></li>
            <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL . FILTROS . "sheep-usuarios/criar&token=" . $_SESSION['timeWT'] ?>">Novo</a></li>
            <li class="breadcrumb-item active" aria-current="page">Imprimir</li>
        </ol>
    </nav>
    <!-- FIM NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

    <section class="section">
        <div class="section-body">

            <!--INICIO LINKS TOPO clientesPR.COM.BR MAYKON SILVEIRA--->
            <?php include_once 'topo.php'; ?>
            <!--FIM LINKS TOPO clientesPR.COM.BR MAYKON SILVEIRA--->
            <br>
            <!--INICIO MENSAGEN DE RETORNO  MAYKON SILVEIRA--->
            <?php include_once 'token.php'; ?>
            <!--FIM MENSAGEN DE RETORNO  MAYKON SILVEIRA--->

            <!-- INICIO TABELA  MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Relatório</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Nº</th>
                                            <th>Criado</th>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Função</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                        $sheep->Leitura('usuarios', "ORDER BY nome ASC");
                                        if ($sheep->getResultado()) {
                                            foreach ($sheep->getResultado() as $cliente) {
                                                $cliente = (object) $cliente;
                                        ?>

                                                <tr>
                                                    <td><?= $cliente->id ?></td>
                                                    <td><?= date('d/m/Y', strtotime($cliente->data)) ?></td>
                                                    <td><?= $cliente->nome ? $cliente->nome : null; ?> <?= $cliente->sobrenome ? $cliente->sobrenome : null; ?></td>
                                                    <td><?= $cliente->cpf ?  $cliente->cpf : null; ?></td>
                                                    <td>
                                                        <?= $cliente->nivel == 'M' ? 'Administrador' : 'Cliente' ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($cliente->status == 'S') {
                                                        ?>

                                                            <button class="btn btn-icon btn-success"><i class="fas fa-check-square"></i></button>

                                                        <?php } else { ?>
                                                            <button class="btn btn-icon btn-danger">X</button>
                                                        <?php } ?>


                                                    </td>
                                                </tr>
                                        <?php  }
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