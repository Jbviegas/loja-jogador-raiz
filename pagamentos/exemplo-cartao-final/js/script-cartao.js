
$gn.ready(function (checkout) {

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
        if ($('#bandeira')[0].checkValidity()) {


            var valor_total = parseInt($('#valor_total').val());//pegando em valor inteiro
            var bandeira = $('#bandeira').val();//pegando a 

            checkout.getInstallments(
                valor_total, // valor total da cobrança
                bandeira, // bandeira do cartão
                function (error, response) {
                    if (error) {
                        // Trata o erro ocorrido
                        console.log(error);

                        alert(`Código do erro: ${error.error}\nDescrição do erro: ${error.error_description}`);
                    } else {
                        // Trata a respostae
                        console.log(response);

                        var option = '';

                        for (let index = 0; index < response.data.installments.length; index++) {
                            option += `<option value="${response.data.installments[index].installment}">${response.data.installments[index].installment} x de R$${response.data.installments[index].currency} ${response.data.installments[index].has_interest === false ? "sem juros" : ""}</option>`;
                        }

                        $('#opcoes_parcelas').html(option);
                        $("#modal_parcelas").modal('show');
                    }
                }
            );
        } else {
            alert("o campo bandeira é obrigatório");
        }
    });



});
