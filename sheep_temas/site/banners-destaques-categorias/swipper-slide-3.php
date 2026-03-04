
<!-- Início Swipper-Slide-3 -->
<?php
$sheep->Leitura('banners', "WHERE local = 'Slide' AND id = 44 LIMIT 1");
$bannerDestaque = Formata::Resultado($sheep);
if ($bannerDestaque):
    foreach ($sheep->getResultado() as $banner):
        $banner = (object) $banner;
?>

        <img src="<?= HOME ?>/uploads/img-banners/<?= $banner->capa ?>" alt="Swipper-Slide">

<?php
    endforeach;
endif;
?>
<!-- Fim  Categoria Swipper-Slide-2  -->