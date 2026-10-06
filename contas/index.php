<?php
session_start();
ob_start();
//conexão 
require_once('../sheep_core/config.php');

//chama o efi banco digital
require_once('./vendor/autoload.php');
$sheep = new Ler();

//token de proteção do site 
$tokenPagamentoSite = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_SPECIAL_CHARS);
if ($_SESSION['token_pagamentos'] != $tokenPagamentoSite):
    header("Location: " . HOME);
    exit();
endif;

if ($tokenPagamentoSite == null):
    header("Location: " . HOME);
    exit();
endif;


if ($_SESSION['token_pagamentos'] === $tokenPagamentoSite):
    null;
else:
    header("Location: " . HOME);
    exit();
endif;
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagamento Seguro Banco Digital Efí | <?= SITENAME ?></title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

    <!-- CDN JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js"></script>

    <style>
        .nav-link {

            color: blueviolet !important;
        }

        .nav-link.active {
            background-color: blueviolet !important;
            color: #fff !important;
        }

        .nav-link.active:hover {
            background-color: black !important;
        }
    </style>
</head>

<body>
    <script type="text/javascript">
        var base_url = "<?= HOME ?>";
    </script>

    <div class="container" style="box-sizing: border-box;">

        <!-- INICIO TOPO PAGAMENTO MAYKONSILVEIRA.COM.BR E MSFLIX.COM.BR -->
        <header class="p-3 text-white border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                            <use xlink:href="#bootstrap" />
                        </svg>
                    </a>

                    <style>
                        .text-orange {
                            color: #ff8000 !important;
                            /* Laranja */
                        }
                    </style>

                    <img src="logo-efi-pay.svg" alt="<?= SITENAME ?>" style="border-radius: 8%; width:100px; margin-right:100px">

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" style="margin-top: 20px; width:100%; border:#ff8000 solid; display:flex; align-items:center">

                        <li><a href="<?= HOME ?>" class="nav-link px-2 text-orange">Início</a></li>

                        <li><a href="<?= HOME ?>/contato" class="nav-link px-2 text-orange">Contatos</a></li>

                        <li>
                            <?php if (isset($_SESSION['sheep_user'])): ?>
                                <a href="<?= HOME ?>/cliente/sheep.php" style="text-decoration: none;">Minha Conta</a>
                            <?php else: ?>
                                <a href="<?= HOME ?>/cliente/" style="text-decoration: none; margin-left:10px">Entrar</a>
                            <?php endif; ?>
                        </li>
                    </ul>

                </div>
            </div>
        </header>
        <div class="b-example-divider"></div>
        <!-- FIM TOPO PAGAMENTO MAYKONSILVEIRA.COM.BR E MSFLIX.COM.BR -->
        <main>


            <div class="tab-content" id="myTabContent">

                <!-- INICIO PAGAMENTO BOLETO E PIX MAYKONSILVEIRA.COM.BR E MSFLIX.COM.BR-->
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <br>

                    <?php
                    /**
                     * 
                     * fORMULARIO USUARIO LOGADO
                     * 
                     */
                    $cliente = (object) [];
                    if (isset($_SESSION['sheep_user'])):
                        $ler = new Ler();
                        $ler->Leitura('usuarios', "WHERE id = :id", "id={$_SESSION['sheep_user']['id']}");
                        if ($ler->getResultado()):
                            foreach ($ler->getResultado() as $cliente);
                            $cliente = (object) $cliente;
                        endif;

                    ?>


                        <div class="d-flex flex-wrap justify-content-center py-3 mb-4">
                            <div class="col-md-12 py-5 text-center">
                                <div class="alert alert-warning" style="font-size: 17px;">Atenção! Caso você queira mudar seus dados pessoais e o endereço da entrega clique
                                    em "Minha Conta" acesse o "Painel do Cliente" e depois clique em "Configurações -> Minha Conta" e mude seus dados e o endereço da
                                    entrega, só não se esqueça de mudar o "Número" e "CEP" do local da entrega.
                                </div>
                                <br>

                                <!-- section title -->
                                <div class="col-12">

                                </div>
                                <!-- end section title -->

                                <!-- section text -->
                                <div class="col-12" style="margin: 10px 0 -100px 0;">
                                </div>
                                <!-- end section title -->

                            </div>
                        </div>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link p2 rounded" href="<?= HOME ?>/pagamentos/index.php?token=<?= $_SESSION['token_pagamentos']  ?>" style="background-color: #ff8000;">
                                    <span style="color: #fff;"> Ir para Pagamento</span>
                                </a>
                            </li>

                        </ul>

                        <form class="needs-validation" action="./confirmar_pagamento.php?tokenPagamento=<?= $_SESSION['token_pagamentos'] ?>" method="post">
                            <div class="row g-5">


                                <div class="col-md-12">
                                    <h4 class="mb-3">Minha Conta</h4>

                                    <!-- INICIO VERIFICAÇÃO DE E-MAIL NO SISTEMA MAYKONSILVEIRA.COM.BR  -->
                                    <?php
                                    $emailExiste = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_BOOLEAN);
                                    if ($emailExiste):
                                    ?>
                                        <div class="alert alert-danger" role="alert">
                                            Este e-mail já existe em nosso sistema, fale com o nosso suporte <?= EMAIL ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- FIM VERIFICAÇÃO DE E-MAIL NO SISTEMA MAYKONSILVEIRA.COM.BR  -->

                                    <!-- INICIO VERIFICAÇÃO DE CPF NO SISTEMA MAYKONSILVEIRA.COM.BR  -->
                                    <?php
                                    $cpfExiste = filter_input(INPUT_GET, 'cpf', FILTER_VALIDATE_BOOLEAN);
                                    if ($cpfExiste):
                                    ?>
                                        <div class="alert alert-danger" role="alert">
                                            Este CPF já existe em nosso sistema, fale com o nosso suporte <?= EMAIL ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- FIM VERIFICAÇÃO DE CPF NO SISTEMA MAYKONSILVEIRA.COM.BR  -->


                                    <div class="row g-3">
                                        <div class="col-sm-4">
                                            <label for="nome_cliente" class="form-label">Primeiro Nome</label>
                                            <input type="text" class="form-control" name="nome" placeholder="Seu primeiro nome" value="<?= $cliente->nome ? $cliente->nome : null ?>" required disabled>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="nome_cliente" class="form-label">Sobre Nome</label>
                                            <input type="text" class="form-control" name="sobrenome" placeholder="Seu sobrenome" value="<?= $cliente->sobrenome ? $cliente->sobrenome : null ?>" required disabled>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="cpf" class="form-label">CPF</label>
                                            <input type="text" class="form-control" name="cpf" id="cpfmj" placeholder="CPF válido" value="<?= $cliente->cpf ? $cliente->cpf : null ?>" required disabled>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input type="email" class="form-control" name="email" placeholder="Seu e-mail" value="<?= $cliente->email ? $cliente->email : null ?>" required disabled>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="telefone" class="form-label">Whatsapp / Celular</label>
                                            <input type="text" class="form-control" name="whatsapp" id="cel" placeholder="Seu celular" value="<?= $cliente->whatsapp ? $cliente->whatsapp : null ?>" required disabled>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="nascimento" class="form-label">Data de nascimento</label>
                                            <input type="date" class="form-control" name="nascimento"
                                                placeholder="Nascimento" value="<?= $cliente->nascimento ? $cliente->nascimento : null ?>" required disabled>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>



                                        <hr class="my-4">
                                        <h4 class="mb-3">Meu Endereço</h4>

                                        <div class="col-sm-6">
                                            <label for="rua" class="form-label">Rua</label>
                                            <input type="text" class="form-control" name="endereco" value="<?= $cliente->endereco ? $cliente->endereco : null; ?>" id="rua"
                                                placeholder="Seu Endereço" required disabled>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <label for="numero" class="form-label">Número</label>
                                            <input type="number" class="form-control" name="numero" value="<?= $cliente->numero ? $cliente->numero : 0; ?>" id="numero" placeholder="Número" required disabled>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="numero" class="form-label">Bairro</label>
                                            <input type="text" class="form-control" name="bairro" id="bairro" value="<?= $cliente->bairro ? $cliente->bairro : 0; ?>" placeholder="Bairro" required disabled>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>


                                        <div class="col-sm-3">
                                            <label for="cep" class="form-label">CEP</label>
                                            <input type="text" class="form-control cepmj" name="cep" placeholder="Seu CEP" value="<?= $cliente->cep ? $cliente->cep : null; ?>" required disabled>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="cidade" class="form-label">Estado</label>
                                            <select class="form-select load_estados" name="estado" id="estado" required disabled>
                                                <option value="0">Selecione o Estado</option>
                                                <?php
                                                $sheep->Leitura('app_estados', "ORDER BY estado_nome ASC");
                                                if ($sheep->getResultado()):
                                                    foreach ($sheep->getResultado() as $estado):
                                                        $estado = (object) $estado;
                                                ?>
                                                        <option value="<?= $estado->estado_id ?>" <?= $cliente->estado == $estado->estado_id ? 'selected' : null;  ?>><?= $estado->estado_nome ?></option>
                                                <?php
                                                    endforeach;
                                                endif;
                                                ?>

                                            </select>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-5">
                                            <label for="cidade" class="form-label">Cidade</label>
                                            <select class="form-select load_cidades" name="cidade" id="cidade" required disabled>
                                                <option value="0">Selecione a Cidade</option>

                                                <?php
                                                $sheep->Leitura('app_cidades', "ORDER BY cidade_nome ASC");
                                                $cidadesPagamento = Formata::Resultado($sheep);
                                                if ($cidadesPagamento):
                                                    foreach ($sheep->getResultado() as $cidade):
                                                        $cidade = (object) $cidade;
                                                ?>
                                                        <option value="<?= $cidade->cidade_id ?>" <?= $cliente->cidade == $cidade->cidade_id ? 'selected' : null;  ?>><?= $cidade->cidade_nome ?></option>
                                                <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                    </div>

                                    <span id="mensagem"></span>

                                   
                                </div>
                            </div>
                        </form>

                    <?php
                        /**
                         * 
                         * FORMULARIO USUARIO SEM CADATRO
                         * 
                         */
                    else:
                    ?>

                        <div class="d-flex flex-wrap justify-content-center py-3 mb-4">
                            <div class="col-md-12 py-5 text-center">
                                <div class="alert alert-warning">Atenção! Caso você ja tenha uma conta clique em "Entrar" e faça login,
                                    ou então crie uma conta e após a conta ser criada você será redirecionado ao "Painel do Cliente"
                                    daí é só voltar aqui e continuar a sua compra.
                                </div>
                                <br>

                                <!-- section title -->
                                <div class="col-12">

                                </div>
                                <!-- end section title -->

                                <!-- section text -->
                                <div class="col-12" style="margin: 10px 0 -100px 0;">
                                </div>
                                <!-- end section title -->

                            </div>
                        </div>
                        <form class="needs-validation" id="formulario_pagamento" method="post"
                            action="./confirmar_pagamento.php?tokenPagamento=<?= $_SESSION['token_pagamentos'] ?>">
                            <div class="row g-5">


                                <div class="col-md-12">
                                    <h4 class="mb-3">Criar conta:</h4>

                                    <!-- INICIO VERIFICAÇÃO DE E-MAIL NO SISTEMA MAYKONSILVEIRA.COM.BR  -->
                                    <?php
                                    $emailExiste = filter_input(INPUT_GET, 'email', FILTER_VALIDATE_BOOLEAN);
                                    if ($emailExiste):
                                    ?>
                                        <div class="alert alert-danger" role="alert">
                                            Este e-mail já existe em nosso sistema, fale com o nosso suporte <?= EMAIL ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- FIM VERIFICAÇÃO DE E-MAIL NO SISTEMA MAYKONSILVEIRA.COM.BR  -->

                                    <!-- INICIO VERIFICAÇÃO DE CPF NO SISTEMA MAYKONSILVEIRA.COM.BR  -->
                                    <?php
                                    $cpfExiste = filter_input(INPUT_GET, 'cpf', FILTER_VALIDATE_BOOLEAN);
                                    if ($cpfExiste):
                                    ?>
                                        <div class="alert alert-danger" role="alert">
                                            Este CPF já existe em nosso sistema, fale com o nosso suporte <?= EMAIL ?>
                                        </div>
                                    <?php endif; ?>
                                    <!-- FIM VERIFICAÇÃO DE CPF NO SISTEMA MAYKONSILVEIRA.COM.BR  -->


                                    <div class="row g-3">
                                        <div class="col-sm-4">
                                            <label for="nome_cliente" class="form-label">Nome</label>
                                            <input type="text" class="form-control" name="nome" placeholder="Seu primeiro nome" required>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="nome_cliente" class="form-label">Sobrenome</label>
                                            <input type="text" class="form-control" name="sobrenome" placeholder="Seu sobrenome" required>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="cpf" class="form-label">CPF</label>
                                            <input type="text" class="form-control" name="cpf" id="cpfmj" placeholder="CPF válido" required>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input type="email" class="form-control" name="email" placeholder="Seu e-mail" required>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="telefone" class="form-label">Whatsapp / Celular</label>
                                            <input type="text" class="form-control" name="whatsapp" id="cel" placeholder="Seu celular" required>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="nascimento" class="form-label">Data de nascimento</label>
                                            <input type="date" class="form-control" name="nascimento"
                                                placeholder="Nascimento" required>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>



                                        <hr class="my-4">
                                        <h4 class="mb-3">Endereço da Entrega:</h4>

                                        <div class="col-sm-6">
                                            <label for="rua" class="form-label">Rua</label>
                                            <input type="text" class="form-control" name="endereco" id="rua"
                                                placeholder="Seu Endereço" required>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <label for="numero" class="form-label">Número</label>
                                            <input type="number" class="form-control" name="numero" id="numero" placeholder="Número" required>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="numero" class="form-label">Bairro</label>
                                            <input type="text" class="form-control" name="bairro" id="numero" placeholder="Número" required>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>


                                        <div class="col-sm-3">
                                            <label for="cep" class="form-label">CEP</label>
                                            <input type="text" class="form-control cepmj" name="cep" placeholder="Seu CEP" value="" required>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="cidade" class="form-label">Estado</label>
                                            <select class="form-select load_estados" name="estado" id="estado" required>
                                                <option value="0">Selecione o Estado</option>
                                                <?php
                                                $sheep->Leitura('app_estados', "ORDER BY estado_nome ASC");
                                                if ($sheep->getResultado()):
                                                    foreach ($sheep->getResultado() as $estado):
                                                        $estado = (object) $estado;
                                                ?>
                                                        <option value="<?= $estado->estado_id ?>"><?= $estado->estado_nome ?></option>
                                                <?php
                                                    endforeach;
                                                endif;
                                                ?>

                                            </select>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                        <div class="col-sm-5">
                                            <label for="cidade" class="form-label">Cidade</label>
                                            <select class="form-select load_cidades" name="cidade" id="cidade" required>
                                                <option value="0">Selecione a Cidade</option>

                                                <?php
                                                $sheep->Leitura('app_cidades', "ORDER BY cidade_nome ASC");
                                                $cidadesPagamento = Formata::Resultado($sheep);
                                                if ($cidadesPagamento):
                                                    foreach ($sheep->getResultado() as $cidade):
                                                        $cidade = (object) $cidade;
                                                ?>
                                                        <option value="<?= $cidade->cidade_id ?>"><?= $cidade->cidade_nome ?></option>
                                                <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Este campo é obrigatório.
                                            </div>
                                        </div>

                                    </div>

                                    <hr class="my-4">

                                    <br>
                                    <br>

                                    <h4 class="mb-3">Senha de acesso(minimo 8 digitos letras, números e caracteres especiais)</h4>

                                    <div class="col-sm-12">
                                        <label for="rua" class="form-label">Sua Senha</label>
                                        <input type="password" class="form-control" name="senha"
                                            placeholder="Senha no minimo 8 digitos letras, números e caracteres especiais" id="senha1" oninput="verificarSenhas();" required>
                                        <small>Sugestão de Senha: <b> <?= Formata::GerarSimbolos(20) . '@' . random_int(10, 100) . '_' . date('s'); ?> </b> </small>
                                        <div class="invalid-feedback">
                                            Este campo é obrigatório.
                                        </div>
                                    </div>

                                    <br>

                                    <div class="col-sm-12">
                                        <label for="numero" class="form-label">Confirmar Senhas</label>
                                        <input type="password" class="form-control" placeholder="Confirmar a senha" id="senha2" name="senha2" oninput="verificarSenhas();" required required>
                                        <div class="invalid-feedback">
                                            Este campo é obrigatório.
                                        </div>
                                    </div>

                                    <span id="mensagem"></span>
                                </div>


                                <br>
                                <br>
                                <div id="areaBotoes" class="row g-3" style="margin-left: 3px;">
                                    <div class="col-sm-6 ">
                                        <button class="w-100 btn btn-success btn-lg" type="submit" name="sendPagamento">Criar Conta</button>
                                    </div>
                                </div>
                            </div>
                </div>
                </form>

            <?php endif; ?>


            </div>
            <!-- FIM PAGAMENTO BOLETO E PIX MAYKONSILVEIRA.COM.BR E MSFLIX.COM.BR-->

    </div>


    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <a href="https://gerencianet.com.br/" target="_blank">
            <img style="height: 50px;" src="compra-segura.png" alt="Gerencianet - Conceito em Pagamentos">
        </a>
    </footer>
    </div>

    <script>
        window.addEventListener("pageshow", function(event) {
            if (event.persisted) {
                location.reload();
            }
        });
    </script>

    <script src="./js/scripsts.js"></script>

    <!--- INICIOCOMBO SELECIONA ESTADO E CIDADE WEBTECPR.COM.BR--->

    <script src="./js/custom.js"></script>
    <!--- FIMCOMBO SELECIONA ESTADO E CIDADE WEBTECPR.COM.BR--->

    <script src="https://getbootstrap.com/docs/5.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://getbootstrap.com/docs/5.1/examples/checkout/form-validation.js"></script>


</body>

</html>