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
    $("#cepmj").mask("99.999-999")
});

/**
 * LOAD CIDADES  
 */
$(function () {

    $('.load_estados').change(function () {

        var estado = $('.load_estados');
        var cidade = $('#load_cidades');
        var caminho = ($('#caminho').length ? $('#caminho').attr('class') + '/cidades.php' : '../ms/cidades.php');

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
    type:"POST",
    data:{id:id},
    dataType: "json",

    sucess: function(){
        $(ms).closest('#removeGaleria').remove();

        alert('Imagem removida com sucesso');
    }
});
}


/**
 * EXCLUIR ARQUIVO DE PRODUTOS
 */




/**
 * EXCLUIR GALERIA DE PAGINAS
 */





