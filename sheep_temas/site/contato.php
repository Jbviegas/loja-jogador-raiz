<?php require_once('header.php') ?>

<!----INICIO MINHA CONTA MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR ---->
<div class="minha-conta">

    <div class="container">

        <div class="linha">

            <div class="col-2">

                <img src="<?= CAMINHO_TEMAS ?>/assets/img/banner-3.png" alt="" width="100%">

            </div>

            <div class="col-2">

                <div class="formulario">

                    <div class="btn-form">
                        <?php
                        $camposVazios = filter_input(INPUT_GET, 'camposVazios', FILTER_VALIDATE_BOOLEAN);
                        if ($camposVazios):
                            echo '<p style="color:red;">Preencha todos os campos!</p>';
                        endif;
                        ?>

                        <?php
                        $tudoCerto = filter_input(INPUT_GET, 'sucesso', FILTER_VALIDATE_BOOLEAN);
                        if ($tudoCerto):
                            echo '<p style="color:green;">Mensagem enviada com sucesso!</p>';
                        endif;
                        ?>
                        <span>Contato</span>
                    </div>


                    <form action="" method="post" id="CadastroSite-2">
                        <?php
                        $enviaEmail = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                        if (isset($enviaEmail['sendContato'])):
                            unset($enviaEmail['sendContato']);

                            if (in_array('', $enviaEmail)):
                                header("Location: " . HOME . "/contato&camposVazios=true");
                                exit();
                            endif;

                            if ($enviaEmail['firewall'] != $_SESSION['_firewall']):
                                header("Location: " . HOME);
                                exit();
                            endif;

                            $assunto = "Contado Diretamente do Site " . SITENAME . " Cliente: " . $enviaEmail['nome'];
                            $mensagem = "
<p>Nome: {$enviaEmail['nome']}</p>
<p>Pedido: {$enviaEmail['id']}</p>
<p>E-mail Cliente: {$enviaEmail['gmail']}</p>
<p>E-mail de Recebimento: {$enviaEmail['email']}</p>
<p>Mensagem: {$enviaEmail['mensagem']}</p>
";
                            Formata::EnviaEmailHome($assunto, $mensagem,  'contato', $enviaEmail['email'], $enviaEmail['nome'], $enviaEmail['id'], $enviaEmail['gmail']);

                        endif;

                        ?>

                        <input type="text" name="nome" placeholder="Nome Completo">
                        <input type="text" name="id" placeholder="Número do Pedido">
                        <input type="text" name="gmail" placeholder="Seu e-mail">
                        <input type="hidden" name="email" value="<?= EMAIL ?>">
                        <input type="hidden" name="firewall" value="<?= $_SESSION['_firewall'] ?>">
                        <textarea name="mensagem" cols="30" rows="9">Deixe sua mensagem</textarea>
                        <button type="submit" name="sendContato" class="btn-3">Enviar</button>

                    </form>

                </div>
                <br>
                <br>
                <br>
                <a href="https://api.whatsapp.com/send?phone=5511943046009">
                    <h4 class="logo-zap">Whatsapp:<i class="fa fa-whatsapp" aria-hidden="true"></i></h4>
                </a>
            </div>

        </div>

    </div>

</div>

</div>
<!----FIM MINHA CONTA MSFLIX.COM.BR MAYKONSILVEIRA.COM.BR ---->
<?php require_once('footer.php') ?>