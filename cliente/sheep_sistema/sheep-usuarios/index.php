<?php

$editar = $_SESSION['sheep_user']['id'];
if ($editar) {
  $sheep->Leitura('usuarios', "WHERE id = :id", "id={$editar}");
  if ($sheep->getResultado()) {
    foreach ($sheep->getResultado() as $cliente);
    $cliente = (object) $cliente;
  } else {
    header('Location: sheep.php');
  }
}

?>


<!-- Main Content -->
<div class="main-content">

  <!-- INICIO NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="sheep.php">Inicio</a></li>
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL_CLIENTE . FILTROS ?>sheep-usuarios/index&token=<?= $_SESSION['timeWT'] ?>">Minha Conta</a></li>
      <li class="breadcrumb-item active" aria-current="page">Atualizar / Excluir</li>
    </ol>
  </nav>
  <!-- FIM NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

  <section class="section">
    <!--INICIO MENSAGEN DE RETORNO  MAYKON SILVEIRA--->
    <?php include_once 'token.php'; ?>
    <!--FIM MENSAGEN DE RETORNO  MAYKON SILVEIRA--->

    <div class="card-header">
      <h4>Excluir Minha Conta</h4>

      <form action="<?= URL_CAMINHO_PAINEL_CLIENTE . FILTROS ?>sheep-usuarios/filtros/excluir&token=<?= $_SESSION['timeWT'] ?>" method="post" onsubmit="return confirmarAcao('Atenção! O processo de exclusão de conta é irreversível, não exclua se ainda houver pedidos em aberto.')">
        <input type="hidden" name="id" value="<?= $cliente->id ?>">
        <button type="submit" class="btn btn-icon btn-danger"><i class="fas fa-trash-alt"></i></button>
      </form>
    </div>

    <form action="<?= URL_CAMINHO_PAINEL_CLIENTE . FILTROS ?>sheep-usuarios/filtros/atualizar&token=<?= $_SESSION['timeWT'] ?>" method="post" enctype="multipart/form-data">


      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-body">

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto</label>
                  <div class="col-sm-12 col-md-7">
                    <div id="image-preview" class="image-preview">
                      <label for="image-upload" id="image-label">Buscar Imagem</label>
                      <?php if ($cliente->foto) { ?>
                        <img alt="" src="<?= SHEEP_IMG_USUARIOS . '/' . $cliente->foto ?>" style="width:100%; height:auto; object-fit:cover;">
                      <?php  } else {
                        null;
                      } ?>

                      <input type="file" name="foto" id="image-upload" />
                    </div>
                  </div>
                </div>

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nome(Obrigatório)</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="nome" placeholder="Primeiro nome" value="<?= $cliente->nome ? $cliente->nome : null; ?>" readonly>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="sobrenome" placeholder="Sobrenome" value="<?= $cliente->sobrenome ? $cliente->sobrenome : null; ?>" readonly>
                  </div>
                </div>


                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">CPF(Obrigatório)</label>
                  <div class="col-md-7">
                    <input type="text" id="cpfmj" class="form-control" name="cpf" placeholder="CPF" value="<?= $cliente->cpf ? $cliente->cpf : null; ?>" readonly>
                  </div>

                </div>



                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">E-mail(Obrigatório)</label>
                  <div class="col-md-7">
                    <input type="email" class="form-control" name="email" placeholder="E-mail" value="<?= $cliente->email ? $cliente->email : null; ?>">
                  </div>

                </div>



                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Whatsapp(Opcional)</label>
                  <div class="col-md-7">
                    <input type="text" id="cel" class="form-control" name="whatsapp" placeholder="whatsapp" value="<?= $cliente->whatsapp ? $cliente->whatsapp : null; ?>">
                  </div>

                </div>

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nascimento(Opcional)</label>
                  <div class="col-md-7">
                    <input type="date" class="form-control" name="nascimento" value="<?= $cliente->nascimento ? $cliente->nascimento : null; ?>">
                  </div>

                </div>

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Endereço(Obrigatório)</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="endereco" placeholder="Seu Endereço" value="<?= $cliente->endereco ? $cliente->endereco : null; ?>">
                  </div>

                  <div class="col-md-3">
                    <input type="number" class="form-control" name="numero" placeholder="Número" value="<?= $cliente->numero ? $cliente->numero : null; ?>">
                  </div>

                </div>


                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">CEP(Obrigatório)</label>
                  <div class="col-md-7">
                    <input type="text" class="form-control" id="cepmj" name="cep" placeholder="CEP Válido" value="<?= $cliente->cep ? $cliente->cep : null; ?>">
                  </div>


                </div>



                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Estado</label>
                  <div class="col-sm-12 col-md-7">
                    <select class="form-control select2 load_estados" name="estado">
                      <?php
                      $ler = new Ler();
                      $ler->Leitura('app_estados', "ORDER BY estado_nome ASC");
                      if ($ler->getResultado()) {
                        foreach ($ler->getResultado() as $estado) {
                          $estado = (object) $estado;
                      ?>
                          <option value="<?= $estado->estado_id ?>" <?= $cliente->estado == $estado->estado_id ? 'selected' : null; ?>><?= $estado->estado_nome ?></option>
                      <?php }
                      } ?>

                    </select>
                  </div>
                </div>

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Cidade</label>
                  <div class="col-md-7">
                    <select class="form-control select2" name="cidade" id="load_cidades">

                      <?php
                      $ler->Leitura('app_cidades', "ORDER BY cidade_nome ASC");
                      $cidadesUsuarios = Formata::Resultado($ler);
                      if ($cidadesUsuarios) {
                        foreach ($ler->getResultado() as $cidade) {
                          $cidade = (object) $cidade;
                      ?>
                          <option value="<?= $cidade->cidade_id ?>" <?= $cliente->cidade == $cidade->cidade_id ? 'selected' : null; ?>><?= $cidade->cidade_nome ?></option>
                      <?php }
                      } ?>

                    </select>
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bairro</label>
                  <div class="col-md-7">
                    <input type="text" class="form-control" name="bairro" placeholder="Bairro" value="<?= $cliente->bairro ? $cliente->bairro : null; ?>">
                  </div>

                </div>



                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Senha(Obrigatório)</label>
                  <div class="col-md-7">
                    <input type="password" class="form-control" name="senha" placeholder="Senha">
                    <small>Dica de Senha: <b><?= Formata::GerarSimbolos(11); ?></b></small>
                  </div>

                </div>


                <input type="hidden" name="sheep_firewall" value="<?= $_SESSION['_sheep_firewall'] ?>">
                <input type="hidden" name="nivel" value="C">
                <input type="hidden" name="status" value="S">
                <input type="hidden" name="id" value="<?= $editar ?>">
                <input type="hidden" name="tipo" value="usuario">
                <input type="hidden" name="tipo_cadastro" value="atualizar">

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                  <div class="col-sm-12 col-md-7">
                    <button type="submit" class="btn btn-lg btn-dark" name="sendSheep">Salvar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>

</div>

<script>
  function confirmarAcao(mensagem) {
    return confirm(mensagem);
  }
</script>

<?php
$sheep = null;
$ler = null;
?>