<!DOCTYPE html>
<html lang="pt-br">

<?php

require_once('header.php');

if ($Link->getData()):
    extract($Link->getData());
else:
    header("Location: " . HOME . "/404");
endif;

?>

<body>

    <!--Containner cards-->
    <div class="linha-3">
        <!--Início Item Produtos em destaque-->

        <div class="containner-comprar">
            <!--Início Linha da galeria-->
            <div class="img-linha">

                <?php
                $galeriaProduto = new Ler();
                $galeriaProduto->Leitura('galeria_produto', "WHERE id_produto = :id", "id={$id}");
                if ($galeriaProduto->getResultado()):
                    foreach ($galeriaProduto->getResultado() as $galeria):
                        $galeria = (object) $galeria;
                ?>
                        <!-- INICIO ITEM GALERIA -->
                        <div class="img-col">
                            <img src="<?= HOME ?>/uploads/img-produtos/<?= $galeria->imagem ?>" class="produtoMiniatura">
                        </div>
                        <!-- FIM ITEM GALERIA -->
                <?php
                    endforeach;
                endif;
                ?>
            </div>
            <!--FIm Linha da galeria-->

            <div class="col-7">
                <img src="<?= HOME ?>/uploads/img-produtos/<?= $capa ?>" id="produtoImg" width="100%">
            </div>
        </div>

        <div class="col-8">

            <h1><?= $titulo ?></h1>

            <form action="<?= HOME ?>/ms/addCarrinho" method="post" class="formulario-comprar">

                <div class="tamanho">Tamanhos :

                    <div class="nomes">
                        <input type="radio" name="tamanho" value="<?= $tamanho_p ?>" <?= $tamanho_p ? '' : 'disabled' ?> required>
                        <label style="margin-right: 10px;"> <?= $tamanho_p ? $tamanho_p : 'P' ?> </label>

                        <input type="radio" name="tamanho" value="<?= $tamanho_m ?>" <?= $tamanho_m ? '' : 'disabled' ?> required>
                        <label style="margin-right: 10px;"><?= $tamanho_m ? $tamanho_m : 'M' ?></label>

                        <input type="radio" name="tamanho" value="<?= $tamanho_g ?>" <?= $tamanho_g ? '' : 'disabled' ?> required>
                        <label style="margin-right: 10px;"><?= $tamanho_g ? $tamanho_g : 'G' ?></label>

                        <input type="radio" name="tamanho" value="<?= $tamanho_gg ?>" <?= $tamanho_gg ? '' : 'disabled' ?> required>
                        <label style="margin-right: 10px;"><?= $tamanho_gg ? $tamanho_gg : 'GG' ?></label>
                    </div>

                    <div class="nomes">
                        <input type="radio" name="tamanho" value="<?= $tamanho_xg ?>" <?= $tamanho_xg ? '' : 'disabled' ?> required>
                        <label style="margin-right: 10px;"><?= $tamanho_xg ? $tamanho_xg : 'XG' ?></label>

                        <input type="radio" name="tamanho" value="<?= $tamanho_lllxl ?>" <?= $tamanho_lllxl ? '' : 'disabled' ?> required>
                        <label style="margin-right: 10px;"><?= $tamanho_lllxl ? $tamanho_lllxl : '3XL' ?></label>

                        <input type="radio" name="tamanho" value="<?= $tamanho_llll_xl ?>" <?= $tamanho_llll_xl ? '' : 'disabled' ?> required>
                        <label style="margin-right: 10px;"><?= $tamanho_llll_xl ? $tamanho_llll_xl : '4XL' ?></label>
                    </div>
                </div>


                <p class="p-quantidade">Quantidade :
                    <input type="number" name="qtde" class="input-quantidade" value="1" required>
                </p>

                <input type="hidden" name="capa" value="<?= $capa ?>">
                <input type="hidden" name="titulo" value="<?= $titulo ?>">
                <input type="hidden" name="id_produto" value="<?= $id ?>">
                <input type="hidden" name="id_sessao" value="<?= $idSessao ?>">
                <input type="hidden" name="id_cliente" value="<?= $idCliente ?>">
                <input type="hidden" name="valor_total" value="<?= $valor ?>">
                <input type="hidden" name="valor_final" id="valorTotalHidden" value="<?= $valor ?>">


                <input type="hidden" name="peso_correio" value="<?= $peso_correio ?>">
                <input type="hidden" name="comprimento_correios" value="<?= $comprimento_correios ?>">
                <input type="hidden" name="largura_correios" value="<?= $largura_correios ?>">
                <input type="hidden" name="altura_correios" value="<?= $altura_correios ?>">

                <button type="submit" name="addCarrinho" class="btn-4" <?= $titulo == 'Esgotado' ? 'disabled' : '' ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                        <path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                    </svg>carrinho</button>


            </form>

            <div id="valor-total">
                <b>Total: R$ <span id="valorTotalCalculado"><?= $valor ?></span></b>
            </div>


            <div class="parcele">
                <p style="font-size: 12px;">Parcele em até 3x sem juros</p>
            </div>

            <div class="description">
                <br>
                <h5>Suporte ao CLiente</h5>
                <p style="font-size: 12px;">> Enviamos para todo Brasil com código de rastreamento</p>
                <p style="font-size: 12px;">> Produto com garantia contra defeito de fábrica</p>
                <p style="font-size: 12px;">> Processo de pagamento totalmente seguro e criptografado</p>
                <p style="font-size: 12px;">> Suporte ao cliente antes e após a compra</p>
                <p style="font-size: 12px;">> Site protegido com os melhores certificados de segurança</p><br>

                <h5>Descrição:</h5>
                <p style="font-size: 14px;"><?= $descricao ?></p> <br>

                <h4>Observe a tabela de Medidas abaixo:</h4>
            </div>
        </div>
    </div>
    <!--Fim Item Produtos em destaque-->

    <!-- Início tabela de tamanhos -->
    <div class="tabela-medidas">
        <img src="<?= CAMINHO_TEMAS ?>/assets/img/TABELA DE MEDIDAS AGASALHO TREINO.png" alt="" id="produtoImg" class="img-tabela-medidas" style="height: 1000px;">
    </div>
    <!-- Início tabela de tamanhos -->

    <!--Inicío Classificão-->
    <div class="linha linha2">
        <h2 class="relacionados">Produtos Relacionados</h2>
    </div>

    <div class="linha-4">
        <?php
        $produtosRelacionado = new Ler();
        $produtosRelacionado->Leitura('produto', "WHERE id != :id AND id_categoria = :idCat LIMIT 14", "id={$id}&idCat={$id_categoria}");
        if ($produtosRelacionado->getResultado()):
            foreach ($produtosRelacionado->getResultado() as $produto):
                $produto = (object) $produto;
        ?>
                <!--INICIO ITEM PRODUTOS EM DESTAQUE MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR -->
                <div class="col-4">
                    <a href="<?= HOME ?>/ver-produto-treino-inverno/<?= $produto->id . '/' . $produto->url ?>" title="<?= $produto->titulo ?>">
                        <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>">
                        <h4><?= Formata::LimitaTextos($produto->titulo, 10) ?></h4>

                        <p class="cor-preco">R$ <?= Formata::vr($produto->valor)  ?></p>
                    </a>
                </div>
                <!--FIM ITEM PRODUTOS EM DESTAQUE MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR -->
        <?php
            endforeach;
        endif;
        ?>

    </div>

    <!--Fim Classificçao-->
    <div class="ver-mais">
        <a href="<?= HOME ?>/5-treino-inverno" class="btn-destaque">Veja mais</a>
    </div>

    <script>
        function Cadastrar() {
            return true
        }

        var produtoImg = document.getElementById("produtoImg");
        var produtoMiniatura = document.getElementsByClassName("produtoMiniatura");

        for (let i = 0; i < produtoMiniatura.length; i++) {
            produtoMiniatura[i].onclick = function() {
                produtoImg.src = produtoMiniatura[i].src;
            }

        }

        function cliqueiNoCheckBoxCom() {

            let name = document.querySelector(".input-nome")
            name.style.display = "block"
            name.value = "- -"

            let number = document.querySelector(".input-numero")
            number.style.display = "block"
            number.value = ""

            let labelName = document.querySelector(".label-nome")
            labelName.style.display = "block"

            let labelNumber = document.querySelector(".label-numero")
            labelNumber.style.display = "block"

        }

        function cliqueiNoCheckBoxSem() {

            let name = document.querySelector(".input-nome")
            name.style.display = "none"
            name.value = "- -"

            let number = document.querySelector(".input-numero")
            number.style.display = "none"
            number.value = "0"

            let labelName = document.querySelector(".label-nome")
            labelName.style.display = "none"

            let labelNumber = document.querySelector(".label-numero")
            labelNumber.style.display = "none"

        }

        function atualizarValorTotal() {
            let quantidade = document.querySelector('.input-quantidade').value;
            let valorPadrao = document.querySelector('#valor-padrao').checked;
            let valorProduto = valorPadrao ? <?= $valor ?> : <?= $valor + 40 ?>;
            let valorTotal = quantidade * valorProduto;

            // Atualizar o total exibido
            document.getElementById('valorTotalCalculado').innerText = valorTotal.toFixed(2);

            // Atualizar o valor do campo hidden
            document.getElementById('valorTotalHidden').value = valorTotal.toFixed(2);
        }

        // Atualizar o valor ao alterar a quantidade
        document.querySelector('.input-quantidade').addEventListener('input', atualizarValorTotal);

        // Atualizar o valor ao alterar a personalização
        document.querySelector('#valor-padrao').addEventListener('click', atualizarValorTotal);
        document.querySelector('#valor-maior').addEventListener('click', atualizarValorTotal);

        // Referência ao campo de quantidade e ao campo número
        const quantidadeInput = document.querySelector('.input-quantidade');
        const numeroInput = document.querySelector('.input-numero');

        // Impedir que a quantidade seja menor que 1
        quantidadeInput.addEventListener('change', () => {
            if (quantidadeInput.value < 1 || quantidadeInput.value === '') {
                quantidadeInput.value = 1;
            }
            atualizarValorTotal();
        });

        // Impedir que o número seja menor que 0
        numeroInput.addEventListener('input', () => {
            if (numeroInput.value < 0) {
                numeroInput.value = 0;
            }
        });
    </script>
</body>

<?php require_once("footer.php") ?>

</html>