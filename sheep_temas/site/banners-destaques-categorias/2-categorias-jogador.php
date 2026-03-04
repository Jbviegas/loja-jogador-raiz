<!-- Início Categoria Jogador -->
<?php
$sheep->Leitura('banners', "WHERE local = 'Categorias' AND id = 26 LIMIT 1");
$bannerDestaque = Formata::Resultado($sheep);
if ($bannerDestaque):
    foreach ($sheep->getResultado() as $banner):
        $banner = (object) $banner;
?>

        <a href="<?= $banner->link ?>">
            <div class="circulo">
                <img src="<?= HOME ?>/uploads/img-banners/<?= $banner->capa ?>" alt="Categorias">
            </div>
        </a>
        <span class="descricao-categoria">
            <p><?= $banner->titulo_um ?></p>
        </span>

<?php
    endforeach;
endif;
?>
<!-- Fim  Categoria Jogador  -->