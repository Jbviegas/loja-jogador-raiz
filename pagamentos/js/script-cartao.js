$(document).ready(function () {
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


    // Função para pegar as parcelas
function getParcelas() {
    if ($('#bandeira')[0].checkValidity()) {
        var valor_total = parseInt($('#valor_total').val()); // Pegando em valor inteiro
        var bandeira = $('#bandeira').val(); // Pegando a bandeira do cartão

        checkout.getInstallments(
            valor_total, // Valor total da cobrança
            bandeira, // Bandeira do cartão
            function (error, response) {
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
        $(document).ready(function () {
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
$(document).ready(function () {
    // Selecionar a primeira opção do campo
    $('#opcoes_parcelas option:first').prop('selected', true);

    // Chamar manualmente a função para aplicar as ações
    changeParcela();
});

// Selecionar a primeira parcela por padrão ao carregar a página
$(document).ready(function () {
    // Selecionar a primeira opção do campo
   

    // Chamar manualmente o evento 'change' para aplicar as ações
    $('#opcoes_parcelas').change();
});

   //função par finalizar o pagamento
   $('#confirmar_pagamento').click( function (){

        if($('#formulario_pagamento')[0].checkValidity){

            var numero_cartao = $('#numero_cartao').val(); // capturando infomações do campo numero do cartão
            var bandeira = $('#bandeira').val(); // capturando infomações do campo bandeira
            var cvv = $('#codigo_seguranca').val(); // capturando infomações do campo codigo de segurança
            var mes_vencimento = $('#mes_vencimento').val(); // capturando infomações do campo mes_vencimento
            var ano_vencimento = $('#ano_vencimento').val(); // capturando infomações do campo ano_vencimento

            checkout.getPaymentToken(
                {
                    brand: bandeira,// bandeira do cartão
                    number: numero_cartao, //numero do cartão
                    cvv: cvv,// codigo de segurança
                    expiration_month: mes_vencimento,//mês de vencimento
                    expiration_year: ano_vencimento// ano de vencimento 
                },
                function (error, response) 
                {

                    if(error){
                       //trata o erro
                       console.error(error);

                       alert(`Código do erro: ${error.error}\nDescrição do erro: ${error.error_description}`);
                    }else {
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
        
        }else{
            alert("Todo os campos são obrigatórios");
        }

   });

});

    
});
