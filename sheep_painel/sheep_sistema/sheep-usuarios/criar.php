<!-- Main Content -->
<div class="main-content">

  <!-- INICIO NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="sheep.php">Inicio</a></li>
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-usuarios/index&token=<?= $_SESSION['timeWT'] ?>">Listar</a></li>
      <li class="breadcrumb-item active" aria-current="page">Criar</li>
    </ol>
  </nav>
  <!-- FIM NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

  <section class="section">
    <!--INICIO MENSAGEN DE RETORNO  MAYKON SILVEIRA--->
    <?php include_once 'token.php'; ?>
    <!--FIM MENSAGEN DE RETORNO  MAYKON SILVEIRA--->


    <form action="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-usuarios/filtros/criar&token=<?= $_SESSION['timeWT'] ?>"
      method="post" enctype="multipart/form-data">

      <script>
        function limparTexto(texto) {
          return texto
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/[^a-zA-Z0-9 ]/g, '')
            .trim();
        }

        document.addEventListener("DOMContentLoaded", function() {
          const camposParaLimpar = document.querySelectorAll('input[name="nome"], input[name="sobrenome"], input[name="endereco"], input[name="bairro"]');

          camposParaLimpar.forEach(campo => {
            campo.addEventListener("input", function() {
              this.value = limparTexto(this.value);
            });
          });
        });
      </script>

      <!-- Seu formulário completo abaixo (sem alterações nos outros campos além dos que precisam limpar) -->

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-footer text-right">
                <a href="" class="btn btn-primary"><i class="fa fa-exclamation-circle"></i> Lista </a>
              </div>

              <div class="card-header">
                <h4>Criar</h4>
              </div>

              <div class="card-body">

                <!-- FOTO -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto</label>
                  <div class="col-sm-12 col-md-7">
                    <div id="image-preview" class="image-preview">
                      <label for="image-upload" id="image-label">Buscar Imagem</label>
                      <input type="file" name="foto" id="image-upload" />
                    </div>
                  </div>
                </div>

                <!-- NOME E SOBRENOME -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                    <h6>Nome</h6>
                  </label>
                  <div class="col-md-3" style="margin-bottom: 5px;">
                    <input type="text" class="form-control" name="nome" placeholder="Seu Nome" required>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="sobrenome" placeholder="Seu Sobrenome" required>
                  </div>
                </div>

                <!-- CPF -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                    <h6>CPF</h6>
                  </label>
                  <div class="col-md-7">
                    <input type="text" id="cpfmj" class="form-control" name="cpf" placeholder="CPF">
                  </div>
                </div>

                <!-- EMAIL -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                    <h6>E-mail</h6>
                  </label>
                  <div class="col-md-7">
                    <input type="email" class="form-control" name="email" placeholder="E-mail">
                  </div>
                </div>

                <!-- WHATSAPP -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                    <h6>Whatsapp</h6>
                  </label>
                  <div class="col-md-7">
                    <input type="text" id="cel" class="form-control" name="whatsapp" placeholder="Whatsapp">
                  </div>
                </div>

                <!-- NASCIMENTO -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                    <h6>Nascimento</h6>
                  </label>
                  <div class="col-md-7">
                    <input type="date" class="form-control" name="nascimento">
                  </div>
                </div>

                <!-- ENDEREÇO -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                    <h6>Endereço</h6>
                  </label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="endereco" placeholder="Sua Rua">
                  </div>
                  <div class="col-md-3">
                    <input type="number" class="form-control" name="numero" placeholder="Número">
                  </div>
                </div>

                <!-- CEP -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                    <h6>CEP</h6>
                  </label>
                  <div class="col-md-7">
                    <input type="text" class="form-control" id="cepmj" name="cep" placeholder="CEP Válido">
                  </div>
                </div>

                <!-- ESTADO -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                    <h6>Estado</h6>
                  </label>
                  <div class="col-sm-12 col-md-7">
                    <select class="form-control select2 load_estados" name="estado" style="width:100%">
                      <?php
                      $ler = new Ler();
                      $ler->Leitura('app_estados', "ORDER BY estado_nome ASC");
                      if ($ler->getResultado()) {
                        foreach ($ler->getResultado() as $estado) {
                          $estado = (object) $estado;
                      ?>
                          <option value="<?= $estado->estado_id ?>"><?= $estado->estado_nome ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>
                </div>

                <!-- CIDADE -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Cidade</label>
                  <div class="col-md-7">
                    <select class="form-control select2" name="cidade" id="load_cidades">
                      <?php
                      $ler->Leitura('app_cidades', "ORDER BY cidade_nome ASC");
                      if ($ler->getResultado()) {
                        foreach ($ler->getResultado() as $cidade) {
                          $cidade = (object) $cidade;
                      ?>
                          <option value="<?= $cidade->cidade_id ?>"><?= $cidade->cidade_nome ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>
                </div>

                <!-- BAIRRO -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bairro</label>
                  <div class="col-md-7">
                    <input type="text" class="form-control" name="bairro" placeholder="Bairro">
                  </div>
                </div>

                <!-- FUNÇÃO -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                    <h6>Função</h6>
                  </label>
                  <div class="col-sm-12 col-md-7">
                    <select class="form-control select2" name="nivel" style="width:100%;">
                      <option value="M">Administrador</option>
                      <option value="C">Cliente</option>
                    </select>
                  </div>
                </div>

                <!-- SENHA -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                    <h6>Senha</h6>
                  </label>
                  <div class="col-md-7">
                    <input type="password" class="form-control" name="senha" placeholder="Senha" required>
                    <small>Dica de Senha: <b><?= Formata::GerarSimbolos(11); ?></b></small>
                  </div>
                </div>

                <!-- STATUS -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                    <h6>Status</h6>
                  </label>
                  <div class="col-sm-12 col-md-7">
                    <select class="form-control selectric" name="status">
                      <option value="S">Ativo</option>
                      <option value="C">Cancelado</option>
                    </select>
                  </div>
                </div>

                <input type="hidden" name="sheep_firewall" value="<?= $_SESSION['_sheep_firewall'] ?>">
                <input type="hidden" name="tipo" value="usuario">
                <input type="hidden" name="tipo_cadastro" value="criar">

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                  <div class="col-sm-12 col-md-7">
                    <button type="submit" class="btn btn-lg btn-primary" name="sendSheep">Salvar</button>
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
<?php

function limparTexto($texto)
{
  $texto = preg_replace('/[áàãâä]/ui', 'a', $texto);
  $texto = preg_replace('/[éèêë]/ui', 'e', $texto);
  $texto = preg_replace('/[íìîï]/ui', 'i', $texto);
  $texto = preg_replace('/[óòõôö]/ui', 'o', $texto);
  $texto = preg_replace('/[úùûü]/ui', 'u', $texto);
  $texto = preg_replace('/[ç]/ui', 'c', $texto);
  $texto = preg_replace('/[^a-z0-9 ]/i', '', $texto);
  return trim($texto);
}

// Limpeza no PHP antes de salvar no banco:
$nome = limparTexto($_POST['nome']);
$sobrenome = limparTexto($_POST['sobrenome']);
$endereco = limparTexto($_POST['endereco']);
$bairro = limparTexto($_POST['bairro']);

// Demais campos seguem normalmente


$sheep = null;
$ler = null;
?>