<!DOCTYPE html>
<html lang="pt-br">
<?php require_once("header.php") ?>

<body>
    <!--Início Minha Conta-->
    <div class="minha-conta">
        <div class="containner-conta">
            <div class="linha">
                <div class="col-2">
                    <div class="formulario">
                        <div class="btn-form">
                            <span onclick="Entrar()">Entrar</span>
                            <span onclick="Cadastro()">Cadastro</span>
                            <hr id="Indicador">
                        </div>
                        <form action="" method="post" id="EntrarPainel">
                            <input type="text" name="email" placeholder="Email de acesso">
                            <input type="password" name="senha" placeholder="Digite sua Senha">
                            <button type="submit" name="senEntrar" class="btn-3">Entrar</button>
                            <a href="" title="">Esqueceu sua senha?</a>
                        </form>

                        <form action="" method="post" id="CadastroSite">
                            <input type="text" name="nome" placeholder="Nome Completo">
                            <input type="text" name="email" placeholder="Email de acesso">
                            <input type="password" name="senha" placeholder="Digite sua Senha">
                            <button type="submit" name="sendCad" class="btn-3">Cadastre-se</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--Fim Minha Conta-->
</body>
<?php require_once("footer.php") ?>

<script src="<?= CAMINHO_TEMAS ?>/assets/js/login.js"></script>

</html>