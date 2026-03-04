<?php
$id = 89451;
$sheep->Leitura('banco_efi', "WHERE id = :id", "id={$id}");
$bancoEfi = Formata::Resultado($sheep);
if ($bancoEfi) {
    foreach ($sheep->getResultado() as $efi);
    $efi = (object) $efi;
}

?>
<!-- Main Content -->
<div class="main-content">

    <!-- INICIO NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="sheep.php">Inicio</a></li>

            <li class="breadcrumb-item active" aria-current="page">Banco Efi</li>
        </ol>
    </nav>
    <!-- FIM NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

    <section class="section">

        <!--INICIO TOKEN E RETORNOS TOPO clientesPR.COM.BR MAYKON SILVEIRA--->
        <?php include_once './token.php' ?>
        <!--FIM TOKEN E RETORNOS TOPO clientesPR.COM.BR MAYKON SILVEIRA--->

        <form action="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-efi/filtros/atualizar&token=<?= $_SESSION['timeWT'] ?>" method="post" enctype="multipart/form-data">


            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-footer text-right">

                                <a href="" class="btn btn-primary"><i class="fa fa-exclamation-circle"></i> Lista </a>


                            </div>

                            <div class="card-header">
                                <h4>Banco Efí</h4>
                            </div>
                            <div class="card-body">


                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Chave 1(Obrigatório)</label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="chave_1" placeholder="Cole aqui a chave" value="<?= $efi->chave_1 ? $efi->chave_1 : null; ?>">
                                    </div>

                                </div>


                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Chave 2(Obrigatório)</label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" name="chave_2" placeholder="Cole aqui a chave" value="<?= $efi->chave_2 ? $efi->chave_2 : null; ?>">
                                    </div>

                                </div>


                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select class="form-control select2 load_estados" name="status">

                                            <option value="false" <?= $efi->status == 'false' ? 'selected' : null; ?>>Ativo</option>
                                            <option value="true" <?= $efi->status == 'true' ? 'selected' : null; ?>>Homologação</option>

                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" name="usuario" value="<?= $_SESSION['sheep_user']['id'] ?>">
                                <input type="hidden" name="sheep_firewall" value="<?= $_SESSION['_sheep_firewall'] ?>">
                                <input type="hidden" name="id" value="<?= $id ?>">

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
    </section>
</div>