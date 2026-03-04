<!-- Início Banner-master-1 -->
<?php
$sheep->Leitura('banners', "WHERE local = 'Banner Master' AND id = 45 LIMIT 1");
$bannerDestaque = Formata::Resultado($sheep);
if ($bannerDestaque):
    foreach ($sheep->getResultado() as $banner):
        $banner = (object) $banner;
?>

        <img src="<?= HOME ?>/uploads/img-banners/<?= $banner->capa ?>" alt="Banner-Master-Lançamentos" width="100%">

<?php
    endforeach;
endif;
?>
<!-- Fim Banner-master-1 -->