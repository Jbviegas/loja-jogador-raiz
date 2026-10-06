<!-- Main Content -->
<div class="main-content">

  <!-- INICIO NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL ?>sheep.php">Inicio</a></li>
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-produtos/index&token=<?= $_SESSION['timeWT'] ?>">Listagem</a></li>

      <li class="breadcrumb-item active" aria-current="page">Criar</li>
    </ol>
  </nav>
  <!-- FIM NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

  <section class="section">

    <!-- INICIO TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <?php include_once('./token.php'); ?>
    <!-- FIM TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

    <form action="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-produtos/filtros/criar&token=<?= $_SESSION['timeWT'] ?>" method="post" enctype="multipart/form-data">

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-footer text-right">
                <a href="" class="btn btn-primary"><i class="fa fa-exclamation-circle"></i> Ajuda? </a>
              </div>

              <div class="card-header">
                <h4>Criar</h4>
              </div>
              <div class="card-body">

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Capa(1200X1200px)</label>
                  <div class="col-sm-12 col-md-7">
                    <div id="image-preview" class="image-preview">
                      <label for="image-upload" id="image-label">Buscar Imagem</label>

                      <input type="file" name="capa" id="image-upload" />
                    </div>
                  </div>
                </div>

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Título do Produto(Obrigatório)</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control" name="titulo" placeholder="Digite o nome do produto">
                  </div>
                </div>

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Quantidade em Estoque(Obrigatório)</label>

                  <div class="col-md-7">
                    <input type="number" class="form-control" name="estoque" value="100" placeholder="Digite a quantidade em estoque, muito importante!">
                  </div>
                </div>

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Valor(Obrigatório)</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control" name="valor" placeholder="Digite o valor">
                  </div>

                </div>


                <!-- INICIO CATEGORIA PAI MAYKONSILVEIRA.COM.BR -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> Categoria (Obrigatório)</label>

                  <div class="col-md-7">
                    <select name="id_categoria" class="form-control select2 load_categoria">
                      <?php
                      if (!$sheep instanceof Ler) {
                        $sheep = new Ler();
                      }
                      $sheep->Leitura('categorias', "WHERE tipo = 'categoria' ORDER BY nome ASC");
                      $categoriasLoja = Formata::Resultado($sheep);
                      if ($categoriasLoja) {
                        foreach ($sheep->getResultado() as $categoria) {
                          $categoria = (object) $categoria;
                      ?>
                          <option value="<?= $categoria->id ?>"> <?= $categoria->nome ?> </option>
                      <?php }
                      } ?>
                    </select>
                  </div>
                </div>
                <!-- FIM CATEGORIA PAI MAYKONSILVEIRA.COM.BR -->


                <!-- INICIO PESO DIAMENTRO E COMPRIMENTO MAYKONSILVEIRA.COM.BR -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Peso/Diamentro/Comprimento</label>

                  <div class="col-md-2">
                    <input type="text" class="form-control" name="peso_correio" value="30" placeholder="Peso em decimal 0.500">
                  </div>
                  <div class="col-md-2">
                    <input type="number" class="form-control" name="diametro_correios" placeholder="Digite o diamentro" value="100">
                  </div>
                  <div class="col-md-3">
                    <input type="number" class="form-control" name="comprimento_correios" value="30" placeholder="Digite o comprimento">
                  </div>
                </div>
                <!-- FIM PESO DIAMENTRO E COMPRIMENTO MAYKONSILVEIRA.COM.BR -->


                <!-- INICIO PESO DIAMENTRO E COMPRIMENTO MAYKONSILVEIRA.COM.BR -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Largura / Altura</label>

                  <div class="col-md-4">
                    <input type="number" class="form-control" value="30" name="largura_correios" placeholder="Largura">
                  </div>
                  <div class="col-md-3">
                    <input type="number" class="form-control" value="4" name="altura_correios" placeholder="Altura">
                  </div>

                </div>
                <!-- FIM PESO DIAMENTRO E COMPRIMENTO MAYKONSILVEIRA.COM.BR -->


                <!-- INICIO STATUS MAYKONSILVEIRA.COM.BR -->
                <div class="form-group row mb-7">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>

                  <div class="col-md-7">
                    <select name="status" class="form-control">
                      <option value="S" class="">Ativo</option>
                      <option value="N" class="">Cancelado</option>
                    </select>
                  </div>

                </div>
                <!-- FIM STATUS MAYKONSILVEIRA.COM.BR -->



                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Descrição</label>

                  <div class="col-md-7">
                    <textarea class="summernote" name="descricao"></textarea>
                  </div>

                </div>



                <div class="form-group row">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Palavras chaves(Obrigatório)</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control inputtags" name="tags">
                  </div>
                </div>


                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Enviar Fotos(Opcional)</label>
                  <div class="col-md-7">
                    <input type="file" multiple="" class="form-control" name="fotos[]">
                  </div>

                </div>


                <input type="hidden" name="usuario" value="<?= $_SESSION['sheep_user']['id'] ?>">
                <input type="hidden" name="sheep_firewall" value="<?= $_SESSION['_sheep_firewall'] ?>">
                <input type="hidden" name="tipo" value="produto">
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
$sheep = null;
?>