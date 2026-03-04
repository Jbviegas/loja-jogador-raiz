<!DOCTYPE html>
<html lang="pt-br">

<body>

    <div class="carBtnX">
        <button class="btn-xcar" onclick="history.back()">
            <p class="voltar"><svg style="margin-left: 10px;" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                    <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z" />
                </svg></p>
        </button>
    </div>

    <!--Início carrinho-->
    <div class="containner-carrinho">

        <span>
            <?php
            $carrinhoCompras = new Ler();
            $carrinhoCompras->Leitura('carrinho', "WHERE id_sessao = :id", "id={$idSessao}");
            if (!empty($carrinhoCompras->getResultado())) {
                echo 'Seu carrinho';
            } else {
                echo 'Seu carrinho está vazio';
            }
            ?>
        </span>

        <!--Início tabela carrinho-->
        <table class="tabela-produtos">

            <tr>
                <th class="topo-tabela-produtos"><span>Produto</span></th>
                <th>Quantidade</th>
                <th>Valor</th>
            </tr>

            <?php
            $dataDia = date('d');
            $dataMes = date('m');
            $dataAno = date('Y');
            $carrinhoDeCompras = new Ler();
            $carrinhoDeCompras->Leitura('carrinho', "WHERE id_sessao = :idSes AND dia = :dia AND mes = :mes AND ano = :ano", "idSes={$idSessao}&dia={$dataDia}&mes={$dataMes}&ano={$dataAno}");
            if ($carrinhoDeCompras->getResultado()):
                foreach ($carrinhoDeCompras->getResultado() as $produto):
                    $produto = (object) $produto;
            ?>
                    <!--Início item carrinho-->
                    <tr style="border-bottom: 2px solid #e2e2e2;">
                        <td>
                            <div class="info-carrinho">
                                <img src="<?= HOME ?>/uploads/img-produtos/<?= $produto->capa ?>" alt="<?= $produto->titulo ?>" style="width:100px; height:auto;">

                                <div>
                                    <p><?= $produto->titulo ?></p>
                                    <small><?= $produto->nome_camisa != '- -' ?  $produto->nome_camisa : "" ?></small>
                                    <small><?= $produto->numero_camisa != '0' ?  $produto->numero_camisa : "" ?></small>
                                    <small><?= $produto->tamanho ?></small>
                                    <br>
                                    <form action="<?= HOME ?>/ms/removerCarrinho" method="post">
                                        <input type="hidden" name="id" value="<?= $produto->id ?>">
                                        <button type="submit" name="removerCarrinho" class="lixeirinha"> <a href="" title="delete"><i class="fa fa-trash-o"></i></a></button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p> <b> <?= $produto->qtde ?> </b> </p>
                        </td>
                        <td>
                            <p>
                                <b> <?= Formata::vr($produto->valor_total) ?> </b>
                            </p>
                        </td>
                    </tr>
                    <!--FIm item carrinho-->
            <?php
                endforeach;
            endif;
            ?>

        </table>
        <!--Fim tabela carrinho-->

        <!--Início valor total-->
        <!--INICIO VALOR TOTAL DO CARRINHO DE COMPRAS MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR -->
        <div class="valor-total">
            <table>
                <?php
                $lerCarrinhoTotal = new Ler();
                $lerCarrinhoTotal->LeituraCompleta("SELECT SUM(valor_final) AS total FROM carrinho WHERE id_sessao = :id", "id={$idSessao}");
                $total = $lerCarrinhoTotal->getResultado()[0]['total'] ? Formata::vr($lerCarrinhoTotal->getResultado()[0]['total']) : 0;
                ?>
                <tr>
                    <td style="visibility: hidden;">Total</td>
                    <td>Sub-Total: R$ <?= $total ?></td>
                </tr>

                <tr>
                    <td id="calcular_frete"></td>
                    <td>
                        <form action="" method="post" id="form_frete">
                            <?php
                            $buscaCep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_SPECIAL_CHARS);
                            if (isset($buscaCep)):
                                $buscaCep = preg_replace('/[^0-9]/', '', $buscaCep);

                                $respostaFrete = Formata::calculaFreteKangu($buscaCep, $idSessao);

                                if (!empty($respostaFrete)):
                                    foreach ($respostaFrete as $index => $freteOpt):
                            ?>

                <tr>
                    <td>

                        <input type="hidden" name="total_qtde[<?= $index ?>]" value="<?= $_SESSION['total_qtde'] ?>">
                        <input type="hidden" name="total_valor[<?= $index ?>]" value="<?= $_SESSION[$total] ?>">

                        <input type="hidden" name="id_sessao[<?= $index ?>]" value="<?= $idSessao ?>">
                        <input type="hidden" name="cep[<?= $index ?>]" value="<?= $buscaCep ?>">

            <?php
                                    endforeach; //loop frete
                                endif; //!empyt
                                //proteção para url de pagamentos
                                $tokenPagamentoCliente = hash('sha512', random_int(187, 5000));
                                $_SESSION['token_pagamentos'] = $tokenPagamentoCliente; //sessão salva do url pagamento 
                                $idSessaoCarrinho = base64_encode($idSessao);
                                $urlFinalCompra = HOME . '/contas?token=' . $tokenPagamentoCliente;

                                if ($total === 0) {
                                    $urlFinalCompra = false;
                                    echo '<script>alert("Adicione um produto ao carrinho");</script>';
                                }
                                //botão para finalizar a compra
                                echo ' Frete Grátis <br><br>
<a href="' . $urlFinalCompra . '" class="btn finalizar" style="width:180%; border-radius:3px; padding:7px; text-decoration:none; text-align:center; color:white;">
 Finalizar Compra
</a>
';
                            else:
                                //se clicou em calcular o frete 
                                echo '
   <input class="inputCep" type="text" name="cep" placeholder="Digite o CEP" style="width:100%; margin-bottom:5px;">
<button type="submit" class="btn-carrinho" style="width:80%; padding:7px;" onclick="validarCep(event)">
    Calcular Frete
</button>';
                            endif; //isset
            ?>

                    </td>
                </tr>

                </form>

                </td>
                </tr>

            </table>
        </div>
        <!--FIM VALOR TOTAL DO CARRINHO DE COMPRAS MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR -->

    </div>

    <!--FIM CARRINHO DE COMPRAS MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radios = document.querySelectorAll('.frete_selecionado');
            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const selectedIndex = this.value;
                    const data = new FormData();
                    data.append('selectedIndex', selectedIndex);
                    data.append('total_qtde', document.querySelector(`input[name="total_qtde[${selectedIndex}]"]`).value);
                    data.append('total_valor', document.querySelector(`input[name="total_valor[${selectedIndex}]"]`).value);
                    data.append('id_sessao', document.querySelector(`input[name="id_sessao[${selectedIndex}]"]`).value);
                    data.append('cep', document.querySelector(`input[name="cep[${selectedIndex}]"]`).value);

                    fetch(base_url + '/ms/processamento', {
                            method: 'POST',
                            body: data,

                        })
                        .then(response => response.json())
                        .then(result => {
                            console.log(result.message);
                        })
                        .catch(error => {
                            console.error('Error: ', error);
                        })
                });
            });
        });

        function validarCep(event) {
            var inputCep = document.querySelector('.inputCep');

            if (!inputCep.value.trim()) {
                event.preventDefault(); // Impede o envio do formulário caso o botão esteja dentro de um form
                alert("Por favor, digite o CEP antes de calcular o frete.");
                inputCep.focus(); // Foca no campo para facilitar a digitação
            }
        }
    </script>

    <!--Fim carrinho-->

</body>

</html>