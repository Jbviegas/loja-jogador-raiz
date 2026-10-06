<!DOCTYPE html>
<html lang="pt-br">

<?php require_once("header.php") ?>

<section>
    <!--Início Swiper-->
    <div>
        <div class="swiper">

            <div class="swiper-wrapper">
                <div class="swiper-slide"><?php include("banners-destaques-categorias/swipper-slide-1.php") ?></div>
                <div class="swiper-slide"><?php include("banners-destaques-categorias/swipper-slide-2.php") ?></div>
                <div class="swiper-slide"><?php include("banners-destaques-categorias/swipper-slide-3.php") ?></div>
                <div class="swiper-slide"><?php include("banners-destaques-categorias/swipper-slide-4.php") ?></div>
            </div>

        </div>

        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    </div>
    <!--FIm Swiper-->
</section>


<body>

    <section>
        <!--Início categorias-->
        <div class="categorias">
            <div class="containner-img-categorias">

                <div class="bloco-categoria">
                    <?php include("banners-destaques-categorias/1-categorias-torcedor.php") ?>
                </div>

                <div class="bloco-categoria">
                    <?php include("banners-destaques-categorias/2-categorias-jogador.php") ?>
                </div>

                <div class="bloco-categoria">
                    <?php include("banners-destaques-categorias/3-categorias-infantil.php") ?>
                </div>

                <div class="bloco-categoria">
                    <?php include("banners-destaques-categorias/4-categorias-feminino.php") ?>
                </div>

                <div class="bloco-categoria">
                    <?php include("banners-destaques-categorias/5-categorias-treino-inverno.php") ?>
                </div>

                <div class="bloco-categoria">
                    <?php include("banners-destaques-categorias/6-categorias-nba.php") ?>
                </div>

                <div class="bloco-categoria">
                    <?php include("banners-destaques-categorias/7-categorias-retro.php") ?>
                </div>
            </div>
        </div>
        <!--Fim categorias-->
    </section>

    <section>
        <!--Início Banner-->
        <div class="banner">

            <?php include("banners-destaques-categorias/master-banner-9.php") ?>

        </div>
        <!--Fim Banner-->
    </section>

    <section class="linha">
        <!--Containner Cards-->
        <div>

            <h2 class="lancamentos" style=" text-align: center; text-decoration: underline;">Lançamentos Torcedor</h2>

            <?php include("produtos-home/8-produtos-home-lancamentos-torcedor.php") ?>

            <div class="ver-mais">
                <a href="<?= HOME ?>/12-lancamentos-torcedor" class="btn-destaque">Veja Mais</a>
            </div>

        </div>



        <div>

            <h2 class="lancamentos" style=" text-align: center; text-decoration: underline;">lançamentos Jogador</h2>

            <?php include("produtos-home/9-produtos-home-lancamentos-jogador.php") ?>

            <div class="ver-mais">
                <a href="<?= HOME ?>/13-lancamentos-jogador" class="btn-destaque">Veja Mais</a>
            </div>

        </div>

        <!-- Fim Containner Cards-->

    </section>

    <section>
        <!--Início Banner-->
        <div class="banner">

            <?php include("banners-destaques-categorias/master-banner-2.php") ?>

        </div>
        <!--Fim Banner-->
    </section>

    <section class="produtos">
        <!--Containner Cards-->
        <?php include("produtos-home/1-produtos-home-torcedor.php") ?>
        <!-- Fim Containner Cards-->

        <div class="ver-mais">
            <a href="<?= HOME ?>/1-torcedor" class="btn-destaque">Veja Mais</a>
        </div>
    </section>

    <section>
        <!--Início Destaque Categoria Torcedor-->
        <div class="ofertas">
            <div class="corpo-categoria">

                <div class="linha-2">

                    <?php include("banners-destaques-categorias/banner.destaque-destaque-1.php") ?>

                </div>
            </div>
        </div>
        <!--Fim Destaque Categoria Torcedor-->
    </section>


    <!--FIm Categoria Torcedor-->


    <section>
        <!--Início Banner-->
        <div class="banner">

            <?php include("banners-destaques-categorias/master-banner-3.php") ?>

        </div>
        <!--Fim Banner-->
    </section>


    <!-- Início Categoria Jogador -->

    <section class="produtos">
        <!--Containner Cards-->
        <?php include("produtos-home/2-produtos-home-jogador.php") ?>
        <!-- Fim Containner Cards-->

        <div class="ver-mais">
            <a href="<?= HOME ?>/2-jogador" class="btn-destaque">Veja Mais</a>
        </div>
    </section>
    <!--FIm Categoria Jogador-->

    <section>
        <!--Início Destaque Categoria Jogador-->
        <div class="ofertas">
            <div class="corpo-categoria">

                <div class="linha-2">

                    <?php include("banners-destaques-categorias/banner.destaque-destaque-2.php") ?>


                </div>
            </div>
        </div>
        <!--Fim Destaque Categoria Jogador-->
    </section>


    <section>
        <!--Início Banner-->
        <div class="banner">

            <?php include("banners-destaques-categorias/master-banner-4.php") ?>

        </div>
        <!--Fim Banner-->
    </section>


    <!--Início Categoria Infantil-->

    <section class="produtos">
        <!--Containner Cards-->
        <?php include("produtos-home/3-produtos-home-infantil.php") ?>
        <!-- Fim Containner Cards-->

        <div class="ver-mais">
            <a href="<?= HOME ?>/3-infantil" class="btn-destaque">Veja Mais</a>
        </div>
    </section>
    <!--FIm Categoria Infantil-->

    <section>
        <!--Início Destaque Categoria Infantil-->
        <div class="ofertas">
            <div class="corpo-categoria">

                <div class="linha-2">

                    <?php include("banners-destaques-categorias/banner.destaque-destaque-3.php") ?>

                </div>
            </div>
        </div>
        <!--Fim Destaque Categoria infantil-->
    </section>


    <section>
        <!--Início Banner-->
        <div class="banner">

            <?php include("banners-destaques-categorias/master-banner-5.php") ?>

        </div>
        <!--Fim Banner-->
    </section>


    <!--Início Categoria Feminia-->

    <section class="produtos">
        <!--Containner Cards-->
        <?php include("produtos-home/4-produtos-home-feminino.php") ?>
        <!-- Fim Containner Cards-->

        <div class="ver-mais">
            <a href="<?= HOME ?>/4-feminino" class="btn-destaque">Veja Mais</a>
        </div>
    </section>
    <!--FIm Categoria Feminina-->

    <section>
        <!--Início Destaque Categoria Feminino-->
        <div class="ofertas">
            <div class="corpo-categoria">

                <div class="linha-2">

                    <?php include("banners-destaques-categorias/banner.destaque-destaque-4.php") ?>

                </div>
            </div>
        </div>
        <!--Fim Destaque Categoria Feminino-->
    </section>


    <section>
        <!--Início Banner-->
        <div class="banner">

            <?php include("banners-destaques-categorias/master-banner-6.php") ?>

        </div>
        <!--Fim Banner-->
    </section>


    <!--Início Categiria kit treino-->

    <section>

        <section class="produtos">
            <!--Containner Cards-->
            <?php include("produtos-home/5-produto-home-treino-inverno.php") ?>
            <!-- Fim Containner Cards-->

            <div class="ver-mais">
                <a href="<?= HOME ?>/5-treino-inverno" class="btn-destaque">Veja Mais</a>
            </div>
        </section>
    </section>
    <!--FIm Categoria Kit Treino-->

    <section>
        <!--Início Destaque Categoria treino-->
        <div class="ofertas">
            <div class="corpo-categoria">

                <div class="linha-2">

                    <?php include("banners-destaques-categorias/banner.destaque-destaque-5.php") ?>

                </div>
            </div>
        </div>
        <!--Fim Destaque Categoria Kit Treino-->
    </section>


    <section>
        <!--Início Banner-->
        <div class="banner">

            <?php include("banners-destaques-categorias/master-banner-7.php") ?>

        </div>
        <!--Fim Banner-->
    </section>


    <section class="produtos">
        <!--Containner Cards-->
        <?php include("produtos-home/6-produto-home-nba.php") ?>
        <!-- Fim Containner Cards-->

        <div class="ver-mais">
            <a href="<?= HOME ?>/6-nba" class="btn-destaque">Veja Mais</a>
        </div>
    </section>
    <!--FIm Categoria NBA-->

    <section>
        <!--Início Destaque Categoria treino-->
        <div class="ofertas">
            <div class="corpo-categoria">

                <div class="linha-2">

                    <?php include("banners-destaques-categorias/banner.destaque-destaque-6.php") ?>

                </div>
            </div>
        </div>
        <!--Fim Destaque Categoria Kit Treino-->
    </section>


    <section>
        <!--Início Banner-->
        <div class="banner">

            <?php include("banners-destaques-categorias/master-banner-8.php") ?>

        </div>
        <!--Fim Banner-->
    </section>


    <section class="produtos">
        <!--Containner Cards-->
        <?php include("produtos-home/7-produto-home-retro.php") ?>
        <!-- Fim Containner Cards-->

        <div class="ver-mais">
            <a href="<?= HOME ?>/7-retro" class="btn-destaque">Veja Mais</a>
        </div>
    </section>
    <!--FIm Categoria Retrô-->

    <!--Início Categoria Retrô-->
    <section>
        <!--Início Destaque Categoria Retrô-->
        <div class="ofertas">
            <div class="corpo-categoria">

                <div class="linha-2">

                    <?php include("banners-destaques-categorias/banner.destaque-destaque-7.php") ?>

                </div>
            </div>
        </div>
        <!--Fim Destaque Categoria Retrô-->
    </section>


    <!--Início características do site-->

    <!--Início Swiper-->
    <div>
        <div class="swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="<?= CAMINHO_TEMAS ?>/assets/img/pagamento-seguro-preto.png" alt="bn-6"></div>
                <div class="swiper-slide"><img src="<?= CAMINHO_TEMAS ?>/assets/img/rastreio-preto.png" alt="bn-7"> </div>
                <div class="swiper-slide"><img src="<?= CAMINHO_TEMAS ?>/assets/img/satisfacao-cliente-preto.png" alt="bn-8"></div>
                <div class="swiper-slide"><img src="<?= CAMINHO_TEMAS ?>/assets/img/suporte-preto.png" alt="bn-9"></div>
            </div>

        </div>


        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    </div>
    <!--FIm Swiper-->
    <!--FIm características do site-->

</body>

<?php require_once("footer.php") ?>

<script>
   function cliqueiNoMenu() {
      let btnMenu = document.querySelector(".menuLateral")
      btnMenu.style.left = "0"
   }

   function cliqueiNoX() {
      let btnX = document.querySelector(".menuLateral")
      btnX.style.left = "-350px"
   }

   function cliqueiNoXx() {
      let btnXx = document.querySelector(".sidebar-cart")
      btnXx.style.display = "none"
   }


   function cliqueiNoCarrinho() {
      let btnCarrinho = document.querySelector(".sidebar-cart")
      btnCarrinho.style.display = "block"
   }


   function removerAcentos(texto) {
      return texto.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
   }

   function search_produtos() {
      let pesquisa = document.querySelector('.menuPesquisa');
      //Mostra da direita para a esquerda a div de pesquisa quando o usuário clica na barra de pesquisa que tem a função search_produtos() 
      let input = document.getElementById('searchbar').value; // Pegando o valor do input de pesquisa que o usuario digitou
      input = removerAcentos(input.toLowerCase()); // Remove acentos e transforma em minúsculas

      let x = document.getElementsByClassName('pesquisa-produtos');
      // Pegando todos os elementos que tem a classe pesquisa-produtos, ou seja, os cards de produtos

      for (let i = 0; i < x.length; i++) { //i= 0, enquanto i < x.lenght itera i++ (i=1, i=2, i=3...)
         // Loop para percorrer todos os produtos(cards) e verificar se o nome do produto inclui o texto digitado no input de pesquisa
         let textoProduto = removerAcentos(x[i].innerHTML.toLowerCase());
         // Pegando todos os produto do card(x = x.lenght) e iterando(i++) enquanto i < x.lenght
         //Pegando todos os produtos do card(innerHTML) e removendo acentos(removerAcentos(texto)) e transformando em minúsculas(toLowerCase()) 
         // para comparar com o valor do input de pesquisa(input)

         if (!textoProduto.includes(input)) { // Se o nome do produto não inclui o texto digitado, esconde o card do produto
            x[i].style.display = "none";
         } else {
            if (input === "") { // Se o input de pesquisa estiver vazio:
               x[i].style.display = "none"; // Esconde o card do produto
               pesquisa.style.right = '-2200px'; // Esconde a div de pesquisa que veio da função search_produtos() da direita para a esquerda
            } else { // Se o nome do produto inclui o texto digitado, mostra o card do produto
               x[i].style.display = "block"; // Mostra o card do produto
               pesquisa.style.right = '0px'; // Mostra a div de pesquisa que veio da função search_produtos() da direita para a esquerda
               pesquisa.style.width = '100%'; // Define a largura da div de pesquisa para 100% da tela
            }
         }
      }
   }


   function cliqueiNoBody() {
      let pesquisa = document.querySelector('.menuPesquisa');
      let input = document.getElementById('searchbar'); // Pegando o input

      pesquisa.style.right = '-2000px'; //Esconde a div de pesquisa que veio da função search_produtos() da direita para a esquerda
      input.value = ""; // Limpando o valor do input
   }
</script>

</html>