<?php

?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Obrigado, pela confiança que você depositou em nosso trabalho! | </title>

  <!-- Bootstrap core CSS -->
  <link href="./css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

  <!-- CDN JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js"></script>

  <!-- Cole aqui o script -->
  <!-- Para obter o script acesse o seguinte site e insira  seu identificador de conta -->
  <!-- https://dev.gerencianet.com.br/docs/pagamento-com-cartao#11-obten%C3%A7%C3%A3o-do-payment_token -->
  <!-- Obs: Utilize o script correto de acordo com as credenciais Client_Id e Client_Secret de produção ou Homologação -->

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

<body>
  <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4">
      <a href="" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
      </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="" class="nav-link " aria-current="page">Início</a></li>
      </ul>

      <div class="col-md-12 py-5 text-center">
        <h4>
          <b class="btn btn-success">Pagamento em Processamento!</b> <br><br>
          Agradecemos profundamente pela confiança.<br><br>
          Queremos informar que o seu pagamento está em processo de análise, e assim que for aprovado, você receberá automaticamente o status da transação em seu e-mail.
          <br><br>Número da Fatura: <b>545454</b>!
        </h4>

      </div>
    </header>

    <footer class="my-5 pt-5 text-muted text-center text-small">
      <a href="https://maykonsilveira.com.br/" target="_blank" style="color:#4a0f4a;">
        Todos os direitos reservados a MaykonSilveira.com.br
      </a>
    </footer>
  </div>

  <script src="https://getbootstrap.com/docs/5.1/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://getbootstrap.com/docs/5.1/examples/checkout/form-validation.js"></script>
</body>

</html>