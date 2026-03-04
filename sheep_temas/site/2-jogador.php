<!DOCTYPE html>
<html lang="pt-br">
<?php require_once("header.php") ?>

<body>
    <!--Inicío Classificão-->
    <!-- 
    <div> class="linha linha2">
        <h2>Torcedor</h2>
        <select name="" id="">
            <option value="">Mais comprados</option>
            <option value="">Mais classificados</option>
            <option value="">Maior preço</option>
            <option value="">Menor preço</option>
        </select>
    </div>
    -->
    <!--Inicío Classificão-->

    <div class="linha linha2" style="margin-top: 200px;">
        <h2>Jogador</h2>
    </div>

    <div class="linha">

        <!--INICIO ITEM PRODUTOS EM DESTAQUE MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR -->
        <?php
        $urlPagina = filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT);
        $pagina = new Paginacao(HOME . '/2-jogador/&p=');
        $pagina->LerPaginas($urlPagina, 20);

        $LerProdutosPagina = new Ler();
        $LerProdutosPagina->Leitura('produto', "WHERE id_categoria = '2'  ORDER BY data DESC LIMIT :limit OFFSET :offset", "limit={$pagina->getLimit()}&offset={$pagina->getOffset()}");
        $produtosHome = Formata::Resultado($LerProdutosPagina);
        if ($produtosHome):
            foreach ($LerProdutosPagina->getResultado() as $produto):
                $produto = (object) $produto;
        ?>
                <div class="col-4">
                    <a href="<?= HOME . '/ver-produto-jogador/' . $produto->id . '/' . $produto->url ?>" title="<?= $produto->titulo ?>">
                        <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>">

                        <h4><?= Formata::LimitaTextos($produto->titulo, 10) ?></h4>
                       
                        <p class="cor-preco">R$ <?= Formata::vr($produto->valor); ?></p>
                    </a>
                </div>
        <?php
            endforeach;
            $pagina->ListarPaginas('produto', "WHERE id_categoria = '2' ORDER BY data ASC");
        endif;
        ?>
        <!--FIM ITEM PRODUTOS EM DESTAQUE MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR -->



    </div>
    <!--FIM LINHAS DE PRODUTOS EM DESTAQUE MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR -->

    <?= $pagina->getPaginacao() ?>


    <div class="ver-mais">
        <a href="<?= HOME ?>" class="btn-destaque">Início do Site</a>
    </div>

</body>

<?php require_once("footer.php") ?>

</html>