<!-- Início Banner-master-1 -->
<?php
$sheep->Leitura('banners', "WHERE local = 'Banner Master' AND id = 34 LIMIT 1");
$bannerDestaque = Formata::Resultado($sheep);
if ($bannerDestaque):
    foreach ($sheep->getResultado() as $banner):
        $banner = (object) $banner;
?>
        <a href="<?= $banner->link ?>">
            <img src="<?= HOME ?>/uploads/img-banners/<?= $banner->capa ?>" alt="Banner-Master-Torcedor" width="100%">
        </a>
<?php
    endforeach;
endif;
?>
<!-- Fim Banner-master-1 -->