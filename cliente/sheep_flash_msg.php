 <script>

//Gerenciador das janelas modais(janelas de aviso/alerta) onde as mensagens são exibidas de acordo com a url recebida (REQUEST_URI)

//FAZ A LEITURA DO DOCUMENTO SHEEP PHP - POR MAYKON SILVEIRA - EAD MAYKONSILVEIRA.COM.BR
$(document).ready(function() {
/* 
Dentro dele, o PHP interpreta a URL atual (REQUEST_URI) e procura por palavras-chave específicas (ex.: sucesso, erro, delete, etc.).

Dependendo do que encontrar, o PHP gera código JavaScript que abre automaticamente um modal correspondente.
*/   

<?php 

//responsável por filtrar o que passa na uri sheep php - maykonsilveira.com.br EAD 
$shee_uri = filter_input(INPUT_SERVER, 'REQUEST_URI');// <--- Aqui é onde a URI é filtrada
//INPUT_SERVER é uma constante que indica que queremos pegar informações do servidor, como a URL atual.
//'REQUEST_URI' é o nome do parâmetro que contém a URL completa que o usuário está acessando (exemplo: /sheep.php?m=sheep-usuarios).
//filter_input é uma função que ajuda a garantir que o valor obtido seja seguro para uso

//INSERIDO COM SUCESSO -  SHEEP PHP - POR MAYKON SILVEIRA - EAD MAYKONSILVEIRA.COM.BR
if (strrpos($shee_uri,  'sucesso')){ ?>
        
//abre o modal sucesso
$('#sucesso').modal('show');

//FECHA SHEEP o modal em 3 segundos
setTimeout(function() {
      $('#sucesso').modal('hide');
    }, 3000); // 3000 = 3 segundos
    
<?php }; ?> 
    
    
    <?php 



//ERRO NO SISTEMA -  SHEEP PHP - POR MAYKON SILVEIRA - EAD MAYKONSILVEIRA.COM.BR
if (strrpos($shee_uri,  'erro')){ ?>	
        
//abre o modal erro
$('#erro').modal('show');

//FECHA SHEEP o modal em 3 segundos
setTimeout(function() {
      $('#erro').modal('hide');
    }, 3000); // 3000 = 3 segundos
    
<?php }; ?>
    
  
    
    <?php 

//VERIFICA SE JA EXISTE O CONTEUDO SHEEP PHP - POR MAYKON SILVEIRA - EAD MAYKONSILVEIRA.COM.BR
if (strrpos($shee_uri,  'erroTemConteudo')){ ?>	
        
//abre o modal sucesso
$('#erroTemConteudo').modal('show');

//FECHA SHEEP o modal em 3 segundos
setTimeout(function() {
      $('#erroTemConteudo').modal('hide');
    }, 3000); // 3000 = 3 segundos
    
<?php }; ?> 
    
    
    <?php 

//DELETAR -  SHEEP PHP - POR MAYKON SILVEIRA - EAD MAYKONSILVEIRA.COM.BR
if (strrpos($shee_uri,  'delete')){ ?>	
        
//abre o modal sucesso
$('#delete').modal('show');

//FECHA SHEEP o modal em 3 segundos
setTimeout(function() {
      $('#delete').modal('hide');
    }, 3000); // 3000 = 3 segundos
    
<?php }; ?> 
    
    
    
    <?php 


//VERIFICA SE JA É TENTATIVA DE INVASÃO -  SHEEP PHP - POR MAYKON SILVEIRA - EAD MAYKONSILVEIRA.COM.BR
if (strrpos($shee_uri,  'sheep_firewall')){ ?>	
        
//abre o modal sucesso
$('#sheep_firewall').modal('show');

//FECHA SHEEP o modal em 3 segundos
setTimeout(function() {
      $('#sheep_firewall').modal('hide');
    }, 5000); // 3000 = 3 segundos
    
<?php }; ?> 
    
    <?php 


//VERIFICA E FAZ IMPRESSÃO - SHEEP PHP - POR MAYKON SILVEIRA - EAD MAYKONSILVEIRA.COM.BR
if (strrpos($shee_uri,  'imprimir')){ ?>	

//abre o modal de impressão
window.open();

    
<?php }; ?> 
  
});

/*
versão refatorada e moderna, toda em JS/jQuery, sem PHP

$(document).ready(function () {
    // Pega a URL atual
    const uri = window.location.href;

    // Função para abrir e fechar modal automaticamente
    function abrirModal(id, tempo = 3000) {
        $(id).modal('show');
        setTimeout(() => {
            $(id).modal('hide');
        }, tempo);
    }

    // Regras de verificação
    if (uri.includes('sucesso')) {
        abrirModal('#sucesso');
    } 
    else if (uri.includes('erroTemConteudo')) {
        abrirModal('#erroTemConteudo');
    }
    else if (uri.includes('erro')) {
        abrirModal('#erro');
    } 
    else if (uri.includes('delete')) {
        abrirModal('#delete');
    } 
    else if (uri.includes('sheep_firewall')) {
        abrirModal('#sheep_firewall', 5000);
        // Atenção: no código original fecha outro modal (provável bug)
        setTimeout(() => { $('#webtec-firewall').modal('hide'); }, 5000);
    } 
    else if (uri.includes('imprimir')) {
        window.open(); // aqui você pode passar a URL do documento a imprimir
    }
});

 */

</script>

