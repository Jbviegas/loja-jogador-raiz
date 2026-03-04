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

<?php require_once 'head_pagamento.php'; ?>

<body>
    <script type="text/javascript">
        var base_url = "<?= HOME ?>";
    </script>
    <div class="container">



        <!-- INICIO TOPO PAGAMENTO MAYKONSILVEIRA.COM.BR E MSFLIX.COM.BR -->
        <header class="p-3 text-white">
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

            <style>
                .bg-orange {
                    background-color: #ff8000 !important;
                    /* Laranja forte */
                    color: white !important;
                    border: none !important;
                    /* Remove a borda caso necessário */
                }

                /* Estilo específico para botão ativo */
                .nav-tabs .nav-link.active {
                    background-color: #ff8000 !important;
                    color: white !important;
                    border: none !important;
                }
            </style>


            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation" style="margin-right: 10px;">
                    <button class="nav-link rounded bg-orange" id="home-tab" data-bs-toggle="tab"
                        data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                        Cartão de Crédito
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link p-2 rounded" href="<?= HOME ?>/pagamentos/pgbepix.php?token=<?= $_SESSION['token_pagamentos'] ?>" style="background-color: #666666;">
                        <span style="color: orange;">PIX / Boleto </span>
                    </a>
                </li>
            </ul>

            <?php
            /**
             * 
             * fORMULARIO USUARIO LOGADO
             * 
             */
            if (isset($_SESSION['sheep_user'])):
                $ler = new Ler();
                $ler->Leitura('usuarios', "WHERE id = :id", "id={$_SESSION['sheep_user']['id']}");
                if ($ler->getResultado()):
                    foreach ($ler->getResultado() as $cliente);
                    $cliente = (object) $cliente;
                endif;

            ?>

                <div class="col-md-12 py-5 text-center">
                    <div class="alert alert-warning">Atenção! Caso você queira mudar seus dados pessoais e o endereço da entrega clique
                        em "Minha Conta" acesse o "Painel do Cliente" e depois clique em "Configurações -> Minha Conta" e mude seus dados pessoais ou o endereço da
                        entrega, ou ambos, não se esqueça de mudar o "Número" e o "CEP" do local da entrega.</div>
                    <br>
                </div>

                <form class="needs-validation" id="formulario_pagamento" method="post"
                    action="./confirmar_pagamento_logado.php?tokenPagamento=<?= $_SESSION['token_pagamentos'] ?>">
                    <div class="row g-5">


                        <div class="col-md-12">
                            <h4 class="mb-3">Dados do Cliente :</h4>

                            <div class="row g-3">

                                <div class="col-sm-4">
                                    <label for="nome_cliente" class="form-label">Nome</label>
                                    <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?= $cliente->nome ? $cliente->nome : ''; ?>" required readonly>
                                    <div class="invalid-feedback">Este campo é obrigatório.</div>
                                </div>

                                <div class="col-sm-4">
                                    <label for="nome_cliente" class="form-label">Sobrenome</label>
                                    <input type="text" class="form-control" name="sobrenome" placeholder="Sobrenome" value="<?= $cliente->sobrenome ? $cliente->sobrenome : ''; ?>" required readonly>
                                    <div class="invalid-feedback">Este campo é obrigatório.</div>
                                </div>

                                <div class="col-sm-4">
                                    <label for="cpf" class="form-label">CPF</label>
                                    <input type="text" class="form-control" name="cpf" id="cpfmj" placeholder="CPF" value="<?= $cliente->cpf ? $cliente->cpf : ''; ?>" required readonly>
                                    <div class="invalid-feedback">Este campo é obrigatório.</div>
                                </div>

                                <div class="col-sm-4">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" name="email" value="<?= $cliente->email ? $cliente->email : ''; ?>" placeholder="E-mail" required readonly>
                                    <div class="invalid-feedback">Este campo é obrigatório.</div>
                                </div>

                                <div class="col-sm-4">
                                    <label for="telefone" class="form-label">Whatsapp / Celular</label>
                                    <input type="text" class="form-control" name="whatsapp" id="cel" value="<?= $cliente->whatsapp ? $cliente->whatsapp : ''; ?>" placeholder="Celular" required readonly>
                                    <div class="invalid-feedback">Este campo é obrigatório.</div>
                                </div>

                                <div class="col-sm-4">
                                    <label for="nascimento" class="form-label">Data Nascimento</label>
                                    <input type="date" class="form-control" name="nascimento" placeholder="Nascimento" value="<?= $cliente->nascimento ? $cliente->nascimento : ''; ?>" required readonly>
                                    <div class="invalid-feedback">Este campo é obrigatório.</div>
                                </div>

                                <div class="col-sm-4">
                                    <input type="hidden" class="form-control" name="id" value="<?= $cliente->id ?>">
                                </div>
                            </div>




                            <hr class="my-4">
                            <h4 class="mb-3">Endereço de entrega</h4>
                            <div class="col-sm-6">
                                <label for="rua" class="form-label">Rua</label>
                                <input type="text" class="form-control" name="endereco"
                                    value="<?= isset($cliente->endereco) ? $cliente->endereco : '' ?>"
                                    <?= isset($cliente->endereco) && $cliente->endereco ? 'readonly' : '' ?> required>
                            </div>

                            <div class="col-sm-2">
                                <label for="numero" class="form-label">Número</label>
                                <input type="number" class="form-control" name="numero"
                                    value="<?= isset($cliente->numero) ? $cliente->numero : '' ?>"
                                    <?= isset($cliente->numero) && $cliente->numero ? 'readonly' : '' ?> required>
                            </div>

                            <div class="col-sm-4">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control" name="bairro"
                                    value="<?= isset($cliente->bairro) ? $cliente->bairro : '' ?>"
                                    <?= isset($cliente->bairro) && $cliente->bairro ? 'readonly' : '' ?> required>
                            </div>

                            <div class="col-sm-3">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" class="form-control cepmj" name="cep"
                                    value="<?= isset($cliente->cep) ? $cliente->cep : '' ?>"
                                    <?= isset($cliente->cep) && $cliente->cep ? 'readonly' : '' ?> required>
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
                                            <option value="<?= isset($estado->estado_id) ?>" <?= $cliente->estado == $estado->estado_id ? 'selected' : null;  ?>><?= $estado->estado_nome ?></option>
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
                                            <option value="<?= isset($cidade->cidade_id) ?>" <?= $cliente->cidade == $cidade->cidade_id ? 'selected' : null;  ?>><?= $cidade->cidade_nome ?></option>
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
                    </div>

                    <hr class="my-4">

                    <h4 class="mb-3">Informação do cartão</h4>

                    <div class="row gy-3" style="margin-left: 3px;">

                        <div class="col-sm-7">
                            <label for="numero_cartao" class="form-label">Número do cartão</label>
                            <input type="text" class="form-control" name="numero_cartao" id="numero_cartao"
                                placeholder="Nº do cartão" required>
                            <div class="invalid-feedback">
                                Este campo é obrigatório.
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <label for="bandeira" class="form-label">Bandeira</label>
                            <select class="form-select" id="bandeira" required>

                                <option value="visa" selected>Visa</option>
                                <option value="mastercard">MasterCard</option>
                                <option value="amex">Amex</option>
                                <option value="elo">Elo</option>
                                <option value="hipercard">Hipercard</option>
                            </select>
                            <div class="invalid-feedback">
                                Este campo é obrigatório.
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label for="mes_vencimento" class="form-label">Mês de vencimento</label>
                            <select class="form-select" name="mes_vencimento" id="mes_vencimento" required>

                                <?php
                                $contagemMes = 1;
                                for ($conta = $contagemMes; $conta <= 12; $conta++) {
                                    echo '<option value="' . $conta . '">' . $conta . '</option>';
                                }
                                ?>


                            </select>
                            <div class="invalid-feedback">
                                Este campo é obrigatório.
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label for="ano_vencimento" class="form-label">Ano de vencimento</label>
                            <select class="form-select" name="ano_vencimento" id="ano_vencimento" required>
                                <?php
                                $anoAtual = date('Y');
                                for ($ano = $anoAtual; $ano <= 2050; $ano++) {
                                    echo '<option value="' . $ano . '">' . $ano . '</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Este campo é obrigatório.
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <label for="codigo_seguranca" class="form-label">Código de segurança (cvv)</label>
                            <input type="text" class="form-control" name="codigo_seguranca" id="codigo_seguranca"
                                required>
                            <div class="invalid-feedback">
                                Este campo é obrigatório.
                            </div>
                        </div>


                        <!-- Input do Payment Token que será gerado a partir dos dados do cartão inseridos -->
                        <div class="col-sm-12">
                            <!--<label for="payment_token" class="form-label">Payment Token a ser gerado</label>-->
                            <input type="hidden" class="form-control" name="payment_token" id="payment_token"
                                readonly>
                        </div>

                        <!-- Input da máscara do cartão de crédito inserido -->
                        <div class="col-12">
                            <!--<label for="mascara_cartao" class="form-label">Máscara do cartão de crédito</label>-->
                            <input type="hidden" class="form-control" name="mascara_cartao" id="mascara_cartao"
                                readonly>
                        </div>
                    </div>

                    <span id="mensagem"></span>

                    <hr class="my-4">

                    <?php
                    // Obtém o ID da sessão atual do usuário
                    $idSessaoAtual = session_id();

                    // Formata o valor total
                    $mudaValor = Formata::vr($_SESSION['total_valor']); // Exemplo: 76,88
                    $valorModificado = str_replace([',', '.'], '', $mudaValor); // Exemplo: 7688
                    $valorFinal = (int) $valorModificado; // Converte para inteiro

                    // Obtém o ID da sessão na tabela carrinho correspondente à sessão atual do usuário
                    $lerIdsessao = new Ler();
                    $query = "SELECT id_sessao FROM carrinho WHERE id_sessao = '$idSessaoAtual' LIMIT 1"; // Consulta corrigida

                    $lerIdsessao->LeituraCompleta($query);

                    $idsessao = $idSessaoAtual; // Define o ID da sessão padrão como a sessão atual
                    if ($lerIdsessao->getResultado()) {
                        $resultado = $lerIdsessao->getResultado()[0];
                        $idsessao = $resultado['id_sessao'] ?? $idSessaoAtual; // Caso não tenha resultado, mantém a sessão atual
                    }
                    ?>

                    <input type="hidden" name="valor_total" id="valor_total" value="<?= $valorFinal ?>" required>
                    <input type="hidden" name="id_sessao" value="<?= htmlspecialchars($idsessao) ?>">
                    <input type="hidden" name="total_valor" value="<?= htmlspecialchars($_SESSION['total_valor']) ?>">
                    <input type="hidden" name="total_qtde" value="<?= htmlspecialchars($_SESSION['total_qtde']) ?>">



                    <div id="areaBotoes" class="row g-3" style="margin-left: 3px;">
                        <div class="col-sm-6">


                            <button class="w-100 btn btn-primary btn-lg" id="ver_parcelas" type="button"><i
                                    class="bi bi-arrow-right-short"></i> Gerar Parcelas</button>

                            <!--<input type="hidden" class="form-control" name="parcelas" id="bandeira"> -->
                            <select class="form-select" id="opcoes_parcelas" name="parcelas" required>
                            </select>
                            <br>
                            <!-- <button type="button" id="definir_parcelas" class="btn btn-primary">Definir parcelas</button>-->
                        </div>
                        <div class="col-sm-6">
                            <button class="w-100 btn btn-secondary btn-lg disabled" id="confirmar_pagamento"
                                type="button" name="sendPagamento">Confirmar pagamento</button>
                        </div>
                    </div>
    </div>
    </div>
    </form>


<?php
                /**
                 * CADASTRO DE USUARIO SEM LOGIN
                 * 
                 */
            else:

?>

    <div class="col-md-12 py-5 text-center">
        <div class="alert alert-warning">Atenção! Você saiu do Painel do Cliente.</div>
        <br>
    </div>

    <form class="needs-validation" id="formulario_pagamento" method="post"
        action="./confirmar_pagamento.php?tokenPagamento=<?= $_SESSION['token_pagamentos'] ?>">
        <div class="row g-5">


            <div class="col-md-12">
                <h4 class="mb-3">Dados do titular do Cartão:</h4>

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
                        <input type="text" class="form-control" name="nome" id="nome_cliente"
                            placeholder="Nome" required disabled>
                        <div class="invalid-feedback">
                            Este campo é obrigatório.
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="nome_cliente" class="form-label">Sobrenome</label>
                        <input type="text" class="form-control" name="sobrenome" placeholder="Sobrenome" required disabled>
                        <div class="invalid-feedback">
                            Este campo é obrigatório.
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" name="cpf" id="cpfmj" placeholder="CPF"
                            required disabled>
                        <div class="invalid-feedback">
                            Este campo é obrigatório.
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="E-mail" required disabled>
                        <div class="invalid-feedback">
                            Este campo é obrigatório.
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="telefone" class="form-label">Celular/Whatsapp</label>
                        <input type="text" class="form-control" name="whatsapp" id="cel" placeholder="Celular"
                            required disabled>
                        <div class="invalid-feedback">
                            Este campo é obrigatório.
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="nascimento" class="form-label">Data de nascimento</label>
                        <input type="date" class="form-control" name="nascimento"
                            placeholder="Data de Nascimento" required disabled>
                        <div class="invalid-feedback">
                            Este campo é obrigatório.
                        </div>
                    </div>


                    <hr class="my-4">
                    <h4 class="mb-3">Endereço de entrega</h4>

                    <div class="col-sm-6">
                        <label for="rua" class="form-label">Rua</label>
                        <input type="text" class="form-control" name="endereco" id="rua"
                            placeholder="Seu Endereço" required disabled>
                        <div class="invalid-feedback">
                            Este campo é obrigatório.
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <label for="numero" class="form-label">Número</label>
                        <input type="number" class="form-control" name="numero" id="numero" placeholder="Número" required disabled>
                        <div class="invalid-feedback">
                            Este campo é obrigatório.
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label for="numero" class="form-label">Bairro</label>
                        <input type="text" class="form-control" name="bairro" id="numero" placeholder="Número" required disabled>
                        <div class="invalid-feedback">
                            Este campo é obrigatório.
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control cepmj" name="cep" placeholder="Seu CEP" value="" required disabled>
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
                        <select class="form-select load_cidades" name="cidade" id="cidade" required disabled>
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
                        placeholder="Senha no minimo 8 digitos letras, números e caracteres especiais" id="senha1" oninput="verificarSenhas();" required disabled>
                    <small>Sugestão de Senha: <b> <?= Formata::GerarSimbolos(20) . '@' . random_int(10, 100) . '_' . date('s'); ?> </b> </small>
                    <div class="invalid-feedback">
                        Este campo é obrigatório.
                    </div>
                </div>

                <br>

                <div class="col-sm-12">
                    <label for="numero" class="form-label">Confirmar Senhas</label>
                    <input type="password" class="form-control" placeholder="Confirmar a senha" id="senha2" name="senha2" oninput="verificarSenhas();" required disabled>
                    <div class="invalid-feedback">
                        Este campo é obrigatório.
                    </div>
                </div>

                <span id="mensagem"></span>
            </div>

            <hr class="my-4">

            <h4 class="mb-3">Informação do cartão</h4>

            <div class="row gy-3" style="margin-left: 3px;">

                <div class="col-sm-7">
                    <label for="numero_cartao" class="form-label">Número do cartão</label>
                    <input type="text" class="form-control" name="numero_cartao" id="numero_cartao"
                        placeholder="Nº do cartão" required disabled>
                    <div class="invalid-feedback">
                        Este campo é obrigatório.
                    </div>
                </div>

                <div class="col-sm-5">
                    <label for="bandeira" class="form-label">Bandeira</label>
                    <select class="form-select" id="bandeira" required disabled>

                        <option value="visa" selected>Visa</option>
                        <option value="mastercard">MasterCard</option>
                        <option value="amex">Amex</option>
                        <option value="elo">Elo</option>
                        <option value="hipercard">Hipercard</option>
                    </select>
                    <div class="invalid-feedback">
                        Este campo é obrigatório.
                    </div>
                </div>

                <div class="col-sm-4">
                    <label for="mes_vencimento" class="form-label">Mês de vencimento</label>
                    <select class="form-select" name="mes_vencimento" id="mes_vencimento" required disabled>

                        <?php
                        $contagemMes = 1;
                        for ($conta = $contagemMes; $conta <= 12; $conta++) {
                            echo '<option value="' . $conta . '">' . $conta . '</option>';
                        }
                        ?>


                    </select>
                    <div class="invalid-feedback">
                        Este campo é obrigatório.
                    </div>
                </div>

                <div class="col-sm-4">
                    <label for="ano_vencimento" class="form-label">Ano de vencimento</label>
                    <select class="form-select" name="ano_vencimento" id="ano_vencimento" required disabled>
                        <?php
                        $anoAtual = date('Y');
                        for ($ano = $anoAtual; $ano <= 2050; $ano++) {
                            echo '<option value="' . $ano . '">' . $ano . '</option>';
                        }
                        ?>
                    </select>
                    <div class="invalid-feedback">
                        Este campo é obrigatório.
                    </div>
                </div>

                <div class="col-sm-4">
                    <label for="codigo_seguranca" class="form-label">Código de segurança (cvv)</label>
                    <input type="text" class="form-control" name="codigo_seguranca" id="codigo_seguranca"
                        required disabled>
                    <div class="invalid-feedback">
                        Este campo é obrigatório.
                    </div>
                </div>


                <!-- Input do Payment Token que será gerado a partir dos dados do cartão inseridos -->
                <div class="col-sm-12">
                    <!--<label for="payment_token" class="form-label">Payment Token a ser gerado</label>-->
                    <input type="hidden" class="form-control" name="payment_token" id="payment_token"
                        readonly>
                </div>

                <!-- Input da máscara do cartão de crédito inserido -->
                <div class="col-12">
                    <!--<label for="mascara_cartao" class="form-label">Máscara do cartão de crédito</label>-->
                    <input type="hidden" class="form-control" name="mascara_cartao" id="mascara_cartao"
                        readonly>
                </div>
            </div>

            <hr class="my-4">

            <?php
                $mudaValor = Formata::vr($_SESSION['total_valor']); // 76,88
                $valorOriginal = $mudaValor;
                $valorModificado = str_replace([",", "."], "", $valorOriginal); // 7688
                $valorFinal = (int) $valorModificado; // 7688

                $lerIdsessao = new Ler();
                $lerIdsessao->LeituraCompleta("SELECT id_sessao FROM carrinho ORDER BY id_sessao DESC");

                // Verifica se o resultado é válido
                if ($lerIdsessao->getResultado()):
                    // Obtém o array associativo completo
                    $resultado = $lerIdsessao->getResultado()[0];

                    // Acessa diretamente o valor da chave 'id_sesao'
                    $idsessao = $resultado['id_sessao'];

                    // Converte o valor para string
                    //$idSessaoString = strval($idsessao);

            ?>
            <?php
                endif;
            ?>

            <input type="hidden" name="valor_total" id="valor_total" value="<?= $valorFinal  ?>" required>
            <input type="hidden" name="id_sessao" value="<?= $idsessao ?>">
            <input type="hidden" name="total_valor" value="<?= $_SESSION['total_valor'] ?>">
            <input type="hidden" name="total_qtde" value="<?= $_SESSION['total_qtde'] ?>">



            <div id="areaBotoes" class="row g-3" style="margin-left: 3px;">
                <div class="col-sm-6">


                    <button class="w-100 btn btn-primary btn-lg" id="ver_parcelas" type="button" disabled><i
                            class="bi bi-arrow-right-short"></i> Gerar Parcelas</button>

                    <!--<input type="hidden" class="form-control" name="parcelas" id="bandeira"> -->
                    <select class="form-select" id="opcoes_parcelas" name="parcelas" required>
                    </select>
                    <br>
                    <!-- <button type="button" id="definir_parcelas" class="btn btn-primary">Definir parcelas</button>-->
                </div>
                <div class="col-sm-6">
                    <button class="w-100 btn btn-secondary btn-lg disabled" id="confirmar_pagamento"
                        type="button" name="sendPagamento" disabled>Confirmar pagamento</button>
                </div>
            </div>
        </div>
        </div>
    </form>

<?php endif; ?>


</main>

<footer class="my-5 pt-5 text-muted text-center text-small">
    <a href="https://sejaefi.com.br/" target="_blank">
        <img style="height: 40px;" src="compra-segura.png" alt="Gerencianet - Conceito em Pagamentos">
    </a>
</footer>
</div>


<script src="./js/scripsts.js"></script>


<script>
    window.addEventListener("pageshow", function(event) {
        if (event.persisted) {
            location.reload();
        }
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $gn.ready(function(checkout) {

            //Aplicando as mascaras nos inputs do formulário
            $('#cpf').mask('000.000.000-00');
            $('#nascimento').mask('00/00/0000');
            $('#cep').mask('00.000-000');
            $('#numero_cartao').mask('0000 0000 0000 0000');
            $('#codigo_seguranca').mask('000');
            $('#telefone').mask('(00) 90000-0000');
            $('#telefone').blur(function(event) {
                if ($(this).val().length == 15) { // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
                    $('#telefone').mask('(00) 00000-0009');
                } else {
                    $('#telefone').mask('(00) 0000-00009');
                }
            });


            // Função para pegar as parcelas
            function getParcelas() {
                if ($('#bandeira')[0].checkValidity()) {
                    var valor_total = parseInt($('#valor_total').val()); // Pegando em valor inteiro
                    var bandeira = $('#bandeira').val(); // Pegando a bandeira do cartão

                    checkout.getInstallments(
                        valor_total, // Valor total da cobrança
                        bandeira, // Bandeira do cartão
                        function(error, response) {
                            if (error) {
                                // Trata o erro ocorrido
                                console.log(error);
                                alert(`Código do erro: ${error.error}\nDescrição do erro: ${error.error_description}`);
                            } else {
                                // Trata a resposta
                                console.log(response);

                                var option = '';

                                for (let index = 0; index < response.data.installments.length; index++) {
                                    option += `<option value="${response.data.installments[index].installment}">${response.data.installments[index].installment} x de R$${response.data.installments[index].currency} ${response.data.installments[index].has_interest === false ? "sem juros" : ""}</option>`;
                                }

                                $('#opcoes_parcelas').html(option);
                                $('#opcoes_parcelas option:first').prop('selected', true);
                            }
                        }
                    );
                } else {
                    alert("O campo bandeira é obrigatório");
                }
            }

            // Associar a função ao evento 'change' do campo de bandeira
            $('#bandeira').change(getParcelas);

            // Chame a função inicialmente para carregar as parcelas quando a página carregar
            $(document).ready(getParcelas);



            // Função para mudar as cores e realizar outras ações ao selecionar a parcela
            function changeParcela() {
                if ($('#opcoes_parcelas')[0].checkValidity()) {
                    var quantidade_parcelas = $('#opcoes_parcelas option:selected').val();

                    $('#parcelas').val(quantidade_parcelas);

                    // ALTERAÇÃO DO BOTÃO VER PARCELAS - CAPTURAR O TEXTO 
                    $('#ver_parcelas').html($('#opcoes_parcelas option:selected').text());
                    $('#ver_parcelas').removeClass('btn-primary');
                    $('#ver_parcelas').addClass('btn-success');

                    // ALTERAÇÃO DO BOTÃO CONFIRMAR_PAGAMENTO 
                    $('#confirmar_pagamento').removeClass('btn-secondary disabled');
                    $('#confirmar_pagamento').addClass('btn-primary');
                } else {
                    // Selecionar a primeira parcela por padrão ao carregar a página
                    $(document).ready(function() {
                        // Selecionar a primeira opção do campo
                        $('#opcoes_parcelas option:first').prop('selected', true);

                        // Chamar manualmente o evento 'change' para aplicar as ações
                        $('#opcoes_parcelas').change();
                    });
                }
            }

            // Associar a função ao evento 'change' do campo de seleção de parcelas
            $('#opcoes_parcelas').change(changeParcela);

            // Chamar manualmente a função ao carregar a página para aplicar as ações à primeira parcela
            $(document).ready(function() {
                // Selecionar a primeira opção do campo
                $('#opcoes_parcelas option:first').prop('selected', true);

                // Chamar manualmente a função para aplicar as ações
                changeParcela();
            });

            // Selecionar a primeira parcela por padrão ao carregar a página
            $(document).ready(function() {
                // Selecionar a primeira opção do campo


                // Chamar manualmente o evento 'change' para aplicar as ações
                $('#opcoes_parcelas').change();
            });

            //função par finalizar o pagamento
            $('#confirmar_pagamento').click(function() {

                if ($('#formulario_pagamento')[0].checkValidity) {

                    var numero_cartao = $('#numero_cartao').val(); // capturando infomações do campo numero do cartão
                    var bandeira = $('#bandeira').val(); // capturando infomações do campo bandeira
                    var cvv = $('#codigo_seguranca').val(); // capturando infomações do campo codigo de segurança
                    var mes_vencimento = $('#mes_vencimento').val(); // capturando infomações do campo mes_vencimento
                    var ano_vencimento = $('#ano_vencimento').val(); // capturando infomações do campo ano_vencimento

                    checkout.getPaymentToken({
                            brand: bandeira, // bandeira do cartão
                            number: numero_cartao, //numero do cartão
                            cvv: cvv, // codigo de segurança
                            expiration_month: mes_vencimento, //mês de vencimento
                            expiration_year: ano_vencimento // ano de vencimento 
                        },
                        function(error, response) {

                            if (error) {
                                //trata o erro
                                console.error(error);

                                alert(`Código do erro: ${error.error}\nDescrição do erro: ${error.error_description}`);
                            } else {
                                //trata o a resposta
                                console.log(response);

                                // Desabilitar os botões ver_parcelas e confirmar_pagamento

                                $('#ver_parcelas').addClass('disabled');
                                $('#confirmar_pagamento').addClass('disabled');


                                $('#confirmar_pagamento').removeClass('btn-primary'); //remover classe do botão 
                                $('#confirmar_pagamento').addClass('btn-success'); //add classe do botão e mudar para cor verde
                                $('#confirmar_pagamento').html('Pagamento Processado'); //Muda o texto do botão para Pagamento Processado

                                // Inserir o payment_token e o card_masck dos inputs
                                var payment_token = response.data.payment_token; //recebe o valor retornado no response
                                var mascara_cartao = response.data.card_mask; //recebe o valor retornado no response
                                $('#payment_token').val(payment_token); // pegando o valor do input e adiciona o valor retornado
                                $('#mascara_cartao').val(mascara_cartao); // pegando o valor do input e adiciona o valor retornado

                                //Dessabilitar os inputs dos dados do cartão de crédito
                                $('#numero_cartao').prop('disabled', true);
                                $('#bandeira').prop('disabled', true);
                                $('#codigo_seguranca').prop('disabled', true);
                                $('#mes_vencimento').prop('disabled', true);
                                $('#ano_vencimento').prop('disabled', true);


                                //confirma o pagamento e envia para o php
                                $('#formulario_pagamento').submit();

                            }
                        }

                    );

                } else {
                    alert("Todo os campos são obrigatórios");
                }

            });

        });


    });
</script>



<script src="https://getbootstrap.com/docs/5.1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://getbootstrap.com/docs/5.1/examples/checkout/form-validation.js"></script>

<script src="./js/custom.js"></script>

</body>

</html>