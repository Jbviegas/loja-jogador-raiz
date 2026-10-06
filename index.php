<?php

session_start(); // Inicia a sessão
ob_start(); // Inicia o buffer de saída

require('./sheep_core/config.php'); // Carrega as configurações do sistema

$idSessao = session_id(); // Pega o ID da sessão atual
$idCliente = isset($_SESSION['sheep_user']) ? $_SESSION['sheep_user']['id'] : 0; // Pega o ID do cliente logado


$_SESSION['correios'] = null; // Limpa os dados dos correios

$_SESSION['_firewall'] = (!isset($_SESSION['_firewall'])) ? hash('sha512', random_int(100, 5000)) : $_SESSION['_firewall'];
// Gera um token de segurança para a sessão
?>

<?php
// inicia a leitura geral
$sheep = new Ler(); // Instancia a classe de leitura de dados no banco de dados
/*Essa classe é a mais importante do sistema, é ela que você vai usar para ler os dados do banco de dados em praticamente todas as
    partes do sistema, seja para exibir produtos, categorias, informações do cliente, etc.*/

$Link = new Link; // Instancia a classe de gerenciamento de links e rotas
//Classe responsável por organizar o SEO do sistema e realizar a navegação!

$Link->getTags(); // Carrega as tags adicionais <meta> <link> <script> etc...
?>

<?php

if (!require_once($Link->getPatch())): // É o método que você usa para saber qual arquivo PHP deve ser incluído/renderizado baseado na URL 
   echo 'Erro ao incluir arquivo de navegação!';
endif;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Preload do CSS principal -->
   <link rel="preload" href="<?= CAMINHO_TEMAS ?>/assets/css/style.css" as="style">

   <!-- Preload das fontes mais usadas -->
   <link rel="preload" href="<?= CAMINHO_TEMAS ?>/assets/fonts/poppins/poppins-v23-latin-regular.woff2" as="font" type="font/woff2" crossorigin>
   <link rel="preload" href="<?= CAMINHO_TEMAS ?>/assets/fonts/poppins/poppins-v23-latin-700.woff2" as="font" type="font/woff2" crossorigin>

   <!-- Fontes locais (Poppins 100–900) -->
   <link rel="stylesheet" href="<?= CAMINHO_TEMAS ?>/assets/css/fonts.css">

   <!-- Ícone do site -->
   <link rel="icon" type="image/png" href="/img-logo/images/2025/02/nome2025-02-26-21-19-icone-1740615569.png">

   <!-- Font Awesome (ícones) -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <!-- Swiper (carrossel/slideshow) -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

   <!-- CSS principal -->
   <link rel="stylesheet" href="<?= CAMINHO_TEMAS ?>/assets/css/style.css">

</head>



<script type="text/javascript">
   var base_url = "<?= HOME ?>"; // Base URL da aplicação, usada em scripts JS para fazer requisições AJAX - Obs: Não está sendo utilizado
</script>

<!-- Plugins JS File -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<!-- Traz as configurações do Swiper Slides -->
<script src="<?= CAMINHO_TEMAS ?>/assets/js/app.js"></script>


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


<!-- Regras para deativar os botões das Paginas de visialização de produtos -->
<script>
   document.addEventListener("DOMContentLoaded", function() { // Espera o DOM carregar completamente
      var titulo = document.querySelector("input[name='titulo']").value.trim().toLowerCase();
      // Pega o valor do input de título, remove espaços e transforma em minúsculas
      var botaoCarrinho = document.querySelector(".btn-4"); // Seleciona o botão de adicionar ao carrinho

      if (titulo === "indisponível") {
         botaoCarrinho.disabled = true;
         botaoCarrinho.style.opacity = "0.5"; // Opcional: reduz opacidade para indicar que está desabilitado
         botaoCarrinho.style.cursor = "not-allowed"; // Opcional: muda o cursor
      }
   });
</script>

<!-- Recarrega todas as páginas -->
<script>
   window.addEventListener("pageshow", function(event) { // Recarrega a página se ela foi restaurada do cache
      if (event.persisted) {
         location.reload();
      }
   });
</script>


</html>
<?php
$LerProdutosPagina = null;
$sheep = null;
$ler = null;
$galeriaProduto = null;
$produtosRelacionado = null;
$lerCarrinhoTotal = null;
$carrinhoDeCompras = null;
ob_end_flush();
?>