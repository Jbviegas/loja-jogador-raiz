<?php
$sheep->Leitura('usuarios');
$contadorClienteTodos = Formata::Resultado($sheep);
if ($contadorClienteTodos) {
  $contaTodos = $sheep->getContaLinhas();
} else {
  $contaTodos = 0;
}


$sheep->Leitura('usuarios', "WHERE status = 'S' ");
$contadorClienteAtivos = Formata::Resultado($sheep);
if ($contadorClienteAtivos) {
  $contaAtivos = $sheep->getContaLinhas();
} else {
  $contaAtivos = 0;
}


$sheep->Leitura('usuarios', "WHERE status = 'C' ");
$contadorClienteCancelados = Formata::Resultado($sheep);
if ($contadorClienteCancelados) {
  $contaCancelado = $sheep->getContaLinhas();
} else {
  $contaCancelado = 0;
}



?>

<div class="row">
  <div class="col-12">
    <div class="card mb-0">
      <div class="card-body">
        <ul class="nav nav-pills" style="margin:5px; float:right;">
          <li class="nav-item">
            <a class="nav-link active" href="<?= FILTROS ?>sheep-usuarios/criar&token=<?= $_SESSION['timeWT'] ?>">Novo </a>
          </li>

          <li class="nav-item">
            <a class="nav-link active" href="<?= FILTROS ?>sheep-usuarios/imprimir&token=<?= $_SESSION['timeWT'] ?>" style="margin-left:5px;"><span class="badge badge-primary"><i class="fas fa-print"></i> </span></a>
          </li>

        </ul>
        <ul class="nav nav-pills">

          <li class="nav-item">
            <a class="nav-link active" href="<?= FILTROS ?>sheep-usuarios/index&token=<?= $_SESSION['timeWT'] ?>">Todos <span class="badge badge-white"><?= $contaTodos ?></span></a>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="<?= FILTROS ?>sheep-usuarios/ativos&token=<?= $_SESSION['timeWT'] ?>">Ativos <span class="badge badge-primary"><?= $contaAtivos ?></span></a>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="<?= FILTROS ?>sheep-usuarios/cancelados&token=<?= $_SESSION['timeWT'] ?>">Cancelados <span class="badge badge-primary"><?= $contaCancelado ?></span></a>
          </li>


          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="">Ajuda? <span class="badge badge-primary"><i class="fa fa-exclamation-circle"></i> </span></a>
          </li>


        </ul>
      </div>
    </div>
  </div>
</div>