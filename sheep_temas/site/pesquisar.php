<!DOCTYPE html>
<html lang="pt-br">


<div class="pesquisa-produtos" id="input-3" style="display: none; margin-top:95px;">
    <!-- CSS separado -->
    <style>
        .produto-card {
            display: block;
            margin-bottom: 10px;
        }

        .produto-card a {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: inherit;
        }

        .produto-card img {
            width: 200px;
        }

        .produto-card .titulo {
            font-size: 18px;
            font-weight: bold;
        }
    </style>

    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND status = 'S' AND id_categoria = 1 ");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!-- Início Item Produtos em destaque (Card) -->
            <div class="produto-card">
                <a href="<?= HOME . '/ver-produto/' . $produto->id . '/' . $produto->url ?>" class="pesquisa-produtos">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>"><br>
                    <span class="titulo"><?= $produto->titulo ?></span>
                </a>
            </div>

    <?php
        endforeach;
    endif;
    ?>

    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND status = 'S' AND id_categoria = 2 ");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!-- Início Item Produtos em destaque (Card) -->
            <div class="produto-card">
                <a href="<?= HOME . '/ver-produto-jogador/' . $produto->id . '/' . $produto->url ?>" class="pesquisa-produtos">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>"><br>
                    <span class="titulo"><?= $produto->titulo ?></span>
                </a>
            </div>

    <?php
        endforeach;
    endif;
    ?>


    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND status = 'S' AND id_categoria = 4 ");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!-- Início Item Produtos em destaque (Card) -->
            <div class="produto-card">
                <a href="<?= HOME . '/ver-produto-retro/' . $produto->id . '/' . $produto->url ?>" class="pesquisa-produtos">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>"><br>
                    <span class="titulo"><?= $produto->titulo ?></span>
                </a>
            </div>


    <?php
        endforeach;
    endif;
    ?>

    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND status = 'S' AND id_categoria = 5 ");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!-- Início Item Produtos em destaque (Card) -->
            <div class="produto-card">
                <a href="<?= HOME . '/ver-produto-feminino/' . $produto->id . '/' . $produto->url ?>" class="pesquisa-produtos">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>"><br>
                    <span class="titulo"><?= $produto->titulo ?></span>
                </a>
            </div>


    <?php
        endforeach;
    endif;
    ?>

    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND status = 'S' AND id_categoria = 6 ");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!-- Início Item Produtos em destaque (Card) -->
            <div class="produto-card">
                <a href="<?= HOME . '/ver-produto-infantil/' . $produto->id . '/' . $produto->url ?>" class="pesquisa-produtos">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>"><br>
                    <span class="titulo"><?= $produto->titulo ?></span>
                </a>
            </div>


    <?php
        endforeach;
    endif;
    ?>

    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND status = 'S' AND id_categoria = 7 ");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!-- Início Item Produtos em destaque (Card) -->
            <div class="produto-card">
                <a href="<?= HOME . '/ver-produto-treino-inverno/' . $produto->id . '/' . $produto->url ?>" class="pesquisa-produtos">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>"><br>
                    <span class="titulo"><?= $produto->titulo ?></span>
                </a>
            </div>


    <?php
        endforeach;
    endif;
    ?>

    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND status = 'S' AND id_categoria = 8 ");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!-- Início Item Produtos em destaque (Card) -->
            <div class="produto-card">
                <a href="<?= HOME . '/ver-produto-nba/' . $produto->id . '/' . $produto->url ?>" class="pesquisa-produtos">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>"><br>
                    <span class="titulo"><?= $produto->titulo ?></span>
                </a>
            </div>

    <?php
        endforeach;
    endif;
    ?>

    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND status = 'S' AND id_categoria = 9");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!-- Início Item Produtos em destaque (Card) -->
            <div class="produto-card">
                <a href="<?= HOME . '/ver-produto/' . $produto->id . '/' . $produto->url ?>" class="pesquisa-produtos">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>"><br>
                    <span class="titulo"><?= $produto->titulo ?></span>
                </a>
            </div>


    <?php
        endforeach;
    endif;
    ?>

    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND status = 'S' AND id_categoria = 10 ");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!-- Início Item Produtos em destaque (Card) -->
            <div class="produto-card">
                <a href="<?= HOME . '/ver-produto/' . $produto->id . '/' . $produto->url ?>" class="pesquisa-produtos">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>"><br>
                    <span class="titulo"><?= $produto->titulo ?></span>
                </a>
            </div>


    <?php
        endforeach;
    endif;
    ?>

    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND status = 'S' AND id_categoria = 11 ");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!-- Início Item Produtos em destaque (Card) -->
            <div class="produto-card">
                <a href="<?= HOME . '/ver-produto/' . $produto->id . '/' . $produto->url ?>" class="pesquisa-produtos">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>"><br>
                    <span class="titulo"><?= $produto->titulo ?></span>
                </a>
            </div>


    <?php
        endforeach;
    endif;
    ?>

    <?php
    $sheep->Leitura('produto', "WHERE tipo = 'produto' AND status = 'S' AND id_categoria = 12 ");
    $produtosHome = Formata::Resultado($sheep);
    if ($produtosHome):
        foreach ($sheep->getResultado() as $produto):
            $produto = (object) $produto;
    ?>

            <!-- Início Item Produtos em destaque (Card) -->
            <div class="produto-card">
                <a href="<?= HOME . '/ver-produto/' . $produto->id . '/' . $produto->url ?>" class="pesquisa-produtos">
                    <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>"><br>
                    <span class="titulo"><?= $produto->titulo ?></span>
                </a>
            </div>


    <?php
        endforeach;
    endif;
    ?>

</div>

</html>