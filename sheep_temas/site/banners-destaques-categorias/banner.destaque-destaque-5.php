<!-- Início Destaque Retrô -->
<?php
$sheep->Leitura('banners', "WHERE local = 'Destaques' AND id = 22 LIMIT 1");
$bannerDestaque = Formata::Resultado($sheep);
if ($bannerDestaque):
    foreach ($sheep->getResultado() as $banner):
        $banner = (object) $banner;
?>

        <div class="col-5">
            <img src="<?= HOME ?>/uploads/img-banners/<?= $banner->capa ?>" alt="Destaques" width="300px" height="320px"
                class="oferta-img">
        </div>
<?php
    endforeach;
endif;
?>
<!-- Fim Destaque Retrô -->

<div class="quadrado-img">

</div>
<!-- Início Banner destaque Retrô -->
<?php
$sheep->Leitura('banners', "WHERE local = 'Banner Destaque' AND id = 17 LIMIT 1");
$bannerDestaque = Formata::Resultado($sheep);
if ($bannerDestaque):
    foreach ($sheep->getResultado() as $banner):
        $banner = (object) $banner;
?>
        <div class="col-6">
            <h2 class="titulo"><span>Kit Treino Inverno</span></h2>
            <img src="<?= HOME ?>/img-banners/<?= $banner->capa ?>" alt="<?= $banner->titulo_um ?>" class="oferta-img">
            <p><?= $banner->titulo_dois ?></p>
            <h1><?= $banner->titulo_tres ?></h1>
            <smal><?= $banner->titulo_quatro ?></smal>
            <smal><?= $banner->titulo_cinco ?></smal>
            <br><br>
            <a href="<?= $banner->titulo_seis == 'Esgotado' ? '#' : $banner->link ?>"
                class="btn-destaque <?= $banner->titulo_seis == 'Esgotado' ? 'disabled-link' : '' ?>">
                <?= $banner->titulo_seis ?> <span>&#8594;</span>
            </a>

        </div>
<?php
    endforeach;
endif;
?>
<!-- Fim Banner destaque Retrô -->