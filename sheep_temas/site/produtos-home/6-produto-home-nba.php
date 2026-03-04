<div class="linha">
    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND id_categoria = 8 AND status = 'S' ORDER BY data DESC LIMIT 14");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!--Início Item Produtos em destaque (Card)-->
            <div class="col-4">
                <a href="<?= HOME . '/ver-produto-nba/' . $produto->id . '/' . $produto->url ?>" title="<?= $produto->titulo ?>">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>">

                    <h4 class="titulo-produto"><?= Formata::LimitaTextos($produto->titulo, 10) ?></h4>

                    <p class="cor-preco"><?= Formata::vr($produto->valor); ?></p>
                </a>
            </div>
            <!--Fim Item Produtos em destaque (Card)-->
    <?php
        endforeach;
    endif;
    ?>
</div>