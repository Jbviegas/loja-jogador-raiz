
$(document).ready(function () {

    //Aplicando as mascaras nos inputs do formulário
    $('#cpf').mask('000.000.000-00');
    $('#nascimento').mask('00/00/0000');
    $('#cep').mask('00.000-000');
    $('#numero_cartao').mask('0000 0000 0000 0000');
    $('#codigo_seguranca').mask('000');
    $('#telefone').mask('(00) 90000-0000');
    $('#telefone').blur(function (event) {
        if ($(this).val().length == 15) { // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
            $('#telefone').mask('(00) 00000-0009');
        } else {
            $('#telefone').mask('(00) 0000-00009');
        }
    });


    $("#ver_parcelas").click(function () {
        $("#modal_parcelas").modal('show');
    });

});
