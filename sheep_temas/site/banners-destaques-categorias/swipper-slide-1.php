
<!-- Início Swipper-Slide-1 -->
<?php
$sheep->Leitura('banners', "WHERE local = 'Slide' AND id = 42 LIMIT 1");
$bannerDestaque = Formata::Resultado($sheep);
if ($bannerDestaque):
    foreach ($sheep->getResultado() as $banner):
        $banner = (object) $banner;
?>
    <a href="<?= $banner->link ?>">
        <img src="<?= HOME ?>/uploads/img-banners/<?= $banner->capa ?>" alt="Swipper-Slide">
    </a>
<?php
    endforeach;
endif;
?>
<!-- Fim  Categoria Swipper-Slide-3  -->