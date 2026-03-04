/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

"use strict";

jQuery(function ($) {

    $("#cpfmj").mask("999.999.999-99")
    $("#cnpj").mask("99.999.999/9999-99")
    $("#fone").mask("(99)9999-9999")
    $("#cel").mask("(99)99999-9999")
    $(".cepmj").mask("99.999-999")
});

/**
 * LOAD CIDADES  
 */
$(function () {

    $('.load_estados').change(function () {

        var estado = $('.load_estados');
        var cidade = $('.load_cidades');
        var caminho = ($('#caminho').length ? $('#caminho').attr('class') + '/cidades.php' : base_url + '/ms/cidades.php');

        estado.attr('disabled', 'true');
        cidade.attr('disabled', 'true');

        cidade.html('<option value="">Carrengando cidades... </option>');

        $.post(caminho, { estado: $(this).val() }, function (cidades) {
            cidade.html(cidades).removeAttr('disabled');

            estado.removeAttr('disabled');
        });


    });

});



/**
 * EXCLUIR GALERIA DE PRODUTOS
 */
function excluirGaleriaDeProdutos(ms) {
    var id = $(ms).attr('data-idmsflix');

    $(ms).closest('#removeGaleria').remove();

    $.ajax({
        url: base_url + "sheep_painel/sheep.php?m=sheep-produtos/excluir-galeria",
        type: "POST",
        data: { id: id },
        dataType: "json",

        success: function () {
            $(ms).closest('#removeGaleria').remove();

            alert('Imagem removida com sucesso!');
        }
    });
}


//CONFIRMA SENHA
// Esta função é chamada sempre que há uma mudança nos campos de senha.
function verificarSenhas() {
    // Obtém o valor do campo de senha com o id 'senha1'.
    var senha1 = document.getElementById('senha1').value;

    // Obtém o valor do campo de confirmação de senha com o id 'senha2'.
    var senha2 = document.getElementById('senha2').value;

    // Seleciona o elemento do DOM que vai exibir a mensagem para o usuário.
    var mensagem = document.getElementById('mensagem');

    // Seleciona o elemento do DOM que vai exibir a mensagem para o usuário.
    var campoInput = document.getElementById('senha2');

    // Verifica se as senhas são iguais.
    if (senha1 == senha2) {
        // Se forem iguais, define o texto do elemento de mensagem para informar que são iguais.
        mensagem.textContent = "As senhas são iguais";

        // Se as senhas não forem iguais, define o texto do elemento de mensagem para informar que não são iguais.
        mensagem.style.color = '#08e23b';

        // Se as senhas não forem iguais, define o texto do elemento de mensagem para informar que não são iguais.
        campoInput.style.background = '#08e23b';
    } else {
        // Se as senhas não forem iguais, define o texto do elemento de mensagem para informar que não são iguais.
        mensagem.textContent = "As senhas não são iguais";

        // Altera a cor do texto para vermelho, indicando um erro ou desigualdade.
        mensagem.style.color = 'red';

        // Altera a cor do texto para vermelho, indicando um erro ou desigualdade.
        campoInput.style.background = 'yellow';

    }

    // Verifica se algum dos campos de senha está vazio.
    if (senha1 === '' || senha2 === '') {
        // Se algum campo estiver vazio, limpa o texto do elemento de mensagem.
        // Isso é para garantir que não mostramos uma mensagem de erro/sucesso se o usuário ainda não digitou nada.
        mensagem.textContent = "";
    }


}



