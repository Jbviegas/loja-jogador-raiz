<!DOCTYPE html>
<html lang="pt-br">
<?php require_once("header.php") ?>

<body>


    <div class="linha linha2" style="margin-top: 200px;">
        <h2>Torcedor</h2>

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
        <!--Fim Classificão-->
    </div>

    <div class="linha">

        <!--INICIO ITEM PRODUTOS EM DESTAQUE MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR -->
        <?php
        $urlPagina = filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT); //Pega o número da página atual(ex:1) pela URL
        $pagina = new Paginacao(HOME . '/1-torcedor/&p=');
        $pagina->LerPaginas($urlPagina, 5); // $pagina =  http://localhost/loja-finalizada/1-torcedor/&p=1 , limit = 5

        $LerProdutosPagina = new Ler();
        $LerProdutosPagina->Leitura( //Faz a query no banco, pega os produtos da categoria selecionada, mas somente os da página atual.
            'produto',
            "WHERE id_categoria IN (1, 9, 10, 11, 12) ORDER BY data DESC LIMIT :limit OFFSET :offset",
            "limit={$pagina->getLimit()}&offset={$pagina->getOffset()}" //EX: Limit = 5 -> OFFSET = 10 (pular os 10 primeiros registros)
        ); //limit define quantos itens por página seram mostrados / offset define a partir de qual item ele irá começar a mostrar os itens

        // getLimit()//Retorna o limite de itens por página
        // getOffset()//Retorna o offset de itens por página

        /*
        Se você está na página 3 e limitou para 5 por página:
        LIMIT = 5 = quantidade de itens por página
        OFFSET = (3 * 5) - 5 = 10   ->   (3 = página atual *  5 = limite de itens por página) - 5 = limite de itens por página = 10
        OFFSET = 10 (pular os 10 primeiros registros)
        Ou seja, vai começar a mostrar a partir do item 11 até o 15.
        */

        $produtosHome = Formata::Resultado($LerProdutosPagina);
        /*$produtosHome  Variavel com os dados dos produtos que devem ser mostrados na página de acordo com os limites e offsets pré definidos
         em LerProdutosPagina->Leitura() */
        if ($produtosHome): // Se houver dados dos produtos buscados em LerProdutosPagina->Leitura()
            foreach ($LerProdutosPagina->getResultado() as $produto): // foreach para iterar sobre os produtos buscados, Loop dos produtos
                $produto = (object) $produto; // retorna o resultado desses produtos como objetos da variável $produto

        ?>
                <div class="col-4"><!-- Responsável por exibir os produtos na tela -->
                    <a href="<?= HOME . '/ver-produto/' . $produto->id . '/' . $produto->url ?>" title="<?= $produto->titulo ?>">
                        <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>">

                        <h4><?= Formata::LimitaTextos($produto->titulo, 10) ?></h4>

                        <p class="cor-preco">R$ <?= Formata::vr($produto->valor); ?></p>
                    </a>
                </div>
        <?php
            endforeach;
            $pagina->ListarPaginas('produto', "WHERE id_categoria IN (1, 9, 10, 11, 12) ORDER BY data ASC");
        endif; /*Através da função getSyntax() ListarPaginas:
            Descobrirá quantos registros existem no banco, calculará quantas páginas serão necessárias, montará os links HTML de navegação.
            */
        ?>
        <!--
        Ou seja, com base na contagem, ele:

                Divide pelo limite ($Limit) e calcula quantas páginas no total existem.

                Calcula quais links precisam ser exibidos.

                Calcula qual é a primeira página, última página e as páginas vizinhas.

                E no final, o resultado é guardado em $this->Paginator, que é usado em getPaginacao() para exibir a paginação.
            
            -->

    </div>
    <!--FIM LINHAS DE PRODUTOS EM DESTAQUE MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR -->


    <?= $pagina->getPaginacao() ?> <!-- Mostra a paginação < [1] 2 3 4 5 > Exibe o HTML gerado na função getSyntax() da classe Paginacao.php

    O número da página atual aparece destacado em vermelho (<b style='color:red;'>).

    O < leva para a primeira página, e o > leva para a última.

    Ele gera links para páginas antes e depois, até o máximo definido em $MaxLinks. 

    -->



    <div class="ver-mais">
        <a href="<?= HOME ?>" class="btn-destaque">Início do Site</a>
    </div>

    <script>
        function cliqueiInput() {

            let pesquisar = document.querySelector(".col")
            pesquisar.style.display = "block"

            let body = document.querySelector(".corpo")
            body.style.display = "none"

        }
    </script>

</body>

<?php require_once("footer.php") ?>



</html>