<header>

    <!--Início Containner-->
    <div class="containner">
        <!--Início navegação-->

        <div class="navbar">

            <div class="menuLateral">

                <img src="<?= CAMINHO_TEMAS ?>/assets/img/x.png" alt="x" width="30px" height="30px" onclick="cliqueiNoX()"
                    class="btn-x" />

                <ul class="lista-menu">
                    <li><a href="<?= HOME ?>" class="a-menu">Início</a></li>

                    <?php if (isset($_SESSION['sheep_user'])): ?>
                        <li><a href="<?= HOME ?>/cliente/sheep.php" class="a-menu">Minha Conta</a></li>
                    <?php else: ?>
                        <li><a href="<?= HOME ?>/cliente/" class="a-menu">Entrar</a></li>
                    <?php endif; ?>

                    <li><a href="<?= HOME ?>/sobre" class="a-menu">Sobre Nós</a></li>
                    <li><a href="<?= HOME ?>/contato" class="a-menu">Contato</a></li>
                </ul>
                <div class="background-categorias">
                    <span class="red-categorias" style="color:#fff; padding-left:3px">Categorias</span>
                </div>
                <ul>
                    <li class="lista-menu"><a href="<?= HOME ?>/8-europeus" class="a-menu">Europeus</a></li>
                    <li class="lista-menu"><a href="<?= HOME ?>/9-brasileirao" class="a-menu">Brasileirão</a></li>
                    <li class="lista-menu"><a href="<?= HOME ?>/10-selecoes" class="a-menu">Seleções</a></li>
                    <li class="lista-menu"><a href="<?= HOME ?>/11-outros" class="a-menu">Outros</a></li>
                    <li class="lista-menu"><a href="<?= HOME ?>/1-torcedor" class="a-menu">Torcedor</a></li>
                    <li class="lista-menu"><a href="<?= HOME ?>/2-jogador" class="a-menu">Jogador</a></li>
                    <li class="lista-menu"><a href="<?= HOME ?>/7-retro" class="a-menu">Retro</a></li>
                    <li class="lista-menu"><a href="<?= HOME ?>/3-infantil" class="a-menu">Kit Infantil</a></li>
                    <li class="lista-menu"><a href="<?= HOME ?>/4-feminino" class="a-menu">Feminino</a></li>
                    <li class="lista-menu"><a href="<?= HOME ?>/6-nba" class="a-menu">NBA</a></li>
                    <li class="lista-menu"><a href="<?= HOME ?>/5-treino-inverno" class="a-menu">Kit Treino-Inverno</a></li>

                </ul>
            </div>


            <div class="sidebar-cart">
                <div class="carBtnX">
                    <button onclick="cliqueiNoXx()" class="btn-xcar">
                        <p class="x">x</p>
                    </button>
                </div>

            </div>


            <img src="<?= CAMINHO_TEMAS ?>/assets/img/cardapio.png" alt="menu" width="30px" height="30px" class="menu"
                onclick="cliqueiNoMenu()" />

            <div class="logo">
                <a href="<?= HOME ?>" title="<?= SITENAME ?>">
                    <img src="<?= HOME ?>/uploads/img-logo/<?= LOGO_HOME ?>" width="140px" alt="<?= SITENAME ?>" />
                </a>
            </div>




            <!--Início menu navegação topo-->
            <nav>
                <ul id="menu-tens">
                    <li><a href="<?= HOME ?>">Início</a></li>
                    <li><a href="<?= HOME ?>/sobre">Sobre Nós</a></li>
                </ul>
            </nav>

            <div class="icones-topo">

                <div>
                    <a href="<?= HOME ?>/contato" title=""><img src="<?= CAMINHO_TEMAS ?>/assets/img/atendimento-ao-cliente.png" alt="contato" width="35px"
                            height="35px"></a>
                </div>

                <div>
                    <?php if (isset($_SESSION['sheep_user'])): ?>
                        <a href="<?= HOME ?>/cliente/sheep.php">
                            <img src="<?= CAMINHO_TEMAS ?>/assets/img/adicionar-amigo.png" alt="conta" width="35px"
                                height="35px">
                        </a>
                    <?php else: ?>
                        <a href="<?= HOME ?>/cliente/">
                            <img src="<?= CAMINHO_TEMAS ?>/assets/img/adicionar-amigo.png" alt="conta" width="35px"
                                height="35px">
                        </a>
                    <?php endif; ?>
                </div>

                <?php


                $idSessaoAtual = session_id(); // Obtém o ID da sessão atual


                $query = "WHERE id_sessao = '{$idSessaoAtual}'"; // Passando diretamente como string('' tranforma o id da sessão em string)
                $sheep->Leitura('carrinho', $query); //Lê no banco a tabela carrinho e verifica se contém a condição id_sesao = $idSessaoAtual 
                //A classe Leitura  Monta a consulta SQL no formato: SELECT * FROM {tabela} {condição} e insere em sheep
                $contaCarrinho = $sheep->getContaLinhas() ?: 0;
                //Se houver na tabela carrinho(sheep) um ou mais produtos e o id da sessão atual(id_sessao) chama a função getContaLinhas()
                //que por sua vez chama a função privada LER(Ler->rowCount()) contida em si que conta a quantidade de linhas na tabela 
                //carrinho que contenham o id da sessão atual e adiciona esse valor a variavel $contaCarrinho que exibe esse valor no carrinho.

                ?>

                <a href="<?= HOME ?>/carrinho" title="" class="cart">
                    <p class="qtd"><?= $contaCarrinho ?></p>
                </a>





            </div>

        </div>
        <!--Fim menu navegação topo-->
    </div>
    <!--Fim Containner-->

    <div class="pesquisar2">
        <input placeholder="Pesquisar" class="busca2" id="searchbar" onkeyup="search_produtos()" type="text" name="search" autocomplete="off">
        <i class="fa fa-search"></i>
    </div>

</header>


<div class="menuPesquisa">
    <!--Inclui o arquivo pesquisar.php que contém a lógica para exibir os produtos pesquisados e os cards de produtos em destaque na div de pesquisa-->
    <? require_once(__DIR__ . '/pesquisar.php'); ?>
    <!--Aqui é onde os produtos pesquisados vão aparecer, a função search_produtos() do index.php mostra essa div quando o usuário
     clica na barra de pesquisa e esconde quando o usuário clica em qualquer parte fora da barra de pesquisa, ou seja, a div de pesquisa
      aparece e desaparece da direita para a esquerda, e os produtos pesquisados aparecem dentro dessa div, os produtos são exibidos
       usando um card com a imagem do produto e o nome do produto, e cada card tem um link para a página do produto correspondente.-->
    <br>
    <br>
    <br>
    <br>

</div>

</html>