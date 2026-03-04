<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagamento Seguro Banco Digital Efí | <?= SITENAME ?> </title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

    <!-- CDN JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/efipay/js-payment-token-efi/dist/payment-token-efi-umd.min.js"></script>


    <!-- Cole aqui o script -->

    <!-- Para obter o script acesse o seguinte site e insira  seu identificador de conta -->
    <!-- https://dev.gerencianet.com.br/docs/pagamento-com-cartao#11-obten%C3%A7%C3%A3o-do-payment_token -->
    <!-- Obs: Utilize o script correto de acordo com as credenciais Client_Id e Client_Secret de produção ou Homologação -->
    <script type='text/javascript'>
        var s = document.createElement('script');
        s.type = 'text/javascript';
        var v = parseInt(Math.random() * 1000000);
        s.src = 'https://api.gerencianet.com.br/v1/cdn/3c96304d6da79e2999bfdaa967365f4c/' + v;
        s.async = false;
        s.id = '3c96304d6da79e2999bfdaa967365f4c';//Identificador da conta Efí -> 3c96304d6da79e2999bfdaa967365f4c(ID Conta)
        if (!document.getElementById('3c96304d6da79e2999bfdaa967365f4c')) {
            document.getElementsByTagName('head')[0].appendChild(s);
        };
        $gn = {
            validForm: true,
            processed: false,
            done: {},
            ready: function(fn) {
                $gn.done = fn;
            }
        };
    </script>

    <style>
        .nav-link {

            color: blueviolet !important;
        }

        .nav-link.active {
            background-color: blueviolet !important;
            color: #fff !important;
        }

        .nav-link.active:hover {
            background-color: black !important;
        }
    </style>
</head>