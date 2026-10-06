<?php
if (!$sheep instanceof Ler) {
  $sheep = new Ler();
}
$editar = filter_input(INPUT_GET, 'editar', FILTER_VALIDATE_INT);
$sheep->Leitura('produto', "WHERE id = :id", "id={$editar}");
$atualizaProdutos = Formata::Resultado($sheep);
if ($atualizaProdutos) {
  foreach ($sheep->getResultado() as $produto);
  $produto = (object) $produto;
} else {
  header("Location: sheep.php");
}

$titulo = trim($_POST['titulo']);

?>

<!-- Main Content -->
<div class="main-content">

  <!-- INICIO NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL ?>sheep.php">Inicio</a></li>
      <li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-produtos/index&token=<?= $_SESSION['timeWT'] ?>">Listagem</a></li>

      <li class="breadcrumb-item active" aria-current="page">Atualizar</li>
    </ol>
  </nav>
  <!-- FIM NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

  <section class="section">

    <!-- INICIO TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
    <?php include_once('./token.php'); ?>
    <!-- FIM TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

    <form action="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-produtos/filtros/atualizar&token=<?= $_SESSION['timeWT'] ?>" method="post" enctype="multipart/form-data">

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">

              <div class="card-footer text-right">
                <a href="" class="btn btn-primary"><i class="fa fa-exclamation-circle"></i> Ajuda? </a>
              </div>

              <div class="card-header">
                <h4>Atualizar</h4>
              </div>
              <div class="card-body">

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Capa(1200X1200px)</label>
                  <div class="col-sm-12 col-md-7">
                    <div id="image-preview" class="image-preview">
                      <label for="image-upload" id="image-label">Buscar Imagem</label>

                      <?php if ($produto->capa) { ?>
                        <img src="<?= SHEEP_IMG_PRODUTOS . $produto->capa ?>" alt="<?= $produto->titulo ?>" style="width:100%; height:auto;">
                      <?php } ?>

                      <input type="file" name="capa" id="image-upload" />
                    </div>
                  </div>
                </div>

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Título do Produto(Obrigatório)</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control" name="titulo" placeholder="Digite o nome do produto" value="<?= $produto->titulo ? $produto->titulo : null; ?>">
                  </div>
                </div>


                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nome do Jogador 1</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control" name="name_l" placeholder="Digite o nome do jogador" value="<?= $produto->name_l ? $produto->name_l : null; ?>">
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nome do Jogador 2</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control" name="name_ll" placeholder="Digite o nome do jogador" value="<?= $produto->name_ll ? $produto->name_ll : null; ?>">
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nome do Jogador 3</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control" name="name_lll" placeholder="Digite o nome do jogador" value="<?= $produto->name_lll ? $produto->name_lll : null; ?>">
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nome do Jogador 4</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control" name="name_lll_l" placeholder="Digite o nome do jogador" value="<?= $produto->name_lll_l ? $produto->name_lll_l : null; ?>">
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nome do Jogador 5</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control" name="name_lll_ll" placeholder="Digite o nome do jogador" value="<?= $produto->name_lll_ll ? $produto->name_lll_ll : null; ?>">
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nome do Jogador 6</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control" name="name_lll_lll" placeholder="Digite o nome do jogador" value="<?= $produto->name_lll_lll ? $produto->name_lll_lll : null; ?>">
                  </div>
                </div>


                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Quantidade em Estoque(Obrigatório)</label>

                  <div class="col-md-7">
                    <input type="number" class="form-control" name="estoque" placeholder="Digite a quantidade em estoque, muito importante!" value="<?= $produto->estoque ? $produto->estoque : null; ?>">
                  </div>
                </div>

                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Valor(Obrigatório)</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control" name="valor" placeholder="Digite o valor normal" value="<?= $produto->valor ? $produto->valor : null; ?>">
                  </div>

                </div>


                <!-- INICIO CATEGORIA PAI MAYKONSILVEIRA.COM.BR -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> Categoria (Obrigatório)</label>

                  <div class="col-md-7">
                    <select name="id_categoria" class="form-control select2 load_categoria" style="width: 100%;">
                      <?php
                      $ler = new Ler();
                      $ler->Leitura('categorias', "WHERE tipo = 'categoria' ORDER BY nome ASC");
                      if ($ler->getResultado()) {
                        foreach ($ler->getResultado() as $categoria) {
                          $categoria = (object) $categoria;
                      ?>
                          <option value="<?= $categoria->id ?>" <?= $produto->id_categoria == $categoria->id ? 'selected' : null; ?>> <?= $categoria->nome ?> </option>
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
                    <input type="text" class="form-control" name="peso_correio" placeholder="Peso em decimal 0.500" value="<?= $produto->peso_correio ? $produto->peso_correio : null; ?>">
                  </div>

                  <div class="col-md-3">
                    <input type="number" class="form-control" name="diametro_correios" placeholder="Digite o diâmetro" value="<?= $produto->diametro_correios ? $produto->diametro_correios : null; ?>">
                  </div>

                  <div class="col-md-3">
                    <input type="number" class="form-control" name="comprimento_correios" placeholder="Digite o comprimento" value="<?= $produto->comprimento_correios ? $produto->comprimento_correios : null; ?>">
                  </div>
                </div>
                <!-- FIM PESO DIAMENTRO E COMPRIMENTO MAYKONSILVEIRA.COM.BR -->


                <!-- INICIO PESO DIAMENTRO E COMPRIMENTO MAYKONSILVEIRA.COM.BR -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Largura / Altura</label>

                  <div class="col-md-4">
                    <input type="number" class="form-control" name="largura_correios" placeholder="Largura" value="<?= $produto->largura_correios ? $produto->largura_correios : null; ?>">
                  </div>
                  <div class="col-md-3">
                    <input type="number" class="form-control" name="altura_correios" placeholder="Altura" value="<?= $produto->altura_correios ? $produto->altura_correios : null; ?>">
                  </div>

                </div>
                <!-- FIM PESO DIAMENTRO E COMPRIMENTO MAYKONSILVEIRA.COM.BR -->


                <!-- INICIO TAMANHO MAYKONSILVEIRA.COM.BR -->
                <div class="form-group row mb-7">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tamanhos</label>

                  <div class="col-md-7">

                    <div style="border: 2px  solid black ">
                      <label><input type="checkbox" name="tamanho_p" value="P" <?= $produto->tamanho_p == 'P' ? 'checked' : null; ?> style="margin:2px;">P</label><br>
                    </div>

                    <div style="border: 2px  solid black">
                      <label><input type="checkbox" name="tamanho_m" value="M" <?= $produto->tamanho_m == 'M' ? 'checked' : null; ?> style="margin:2px;">M</label><br>
                    </div>

                    <div style="border: 2px  solid black;">
                      <label><input type="checkbox" name="tamanho_g" value="G" <?= $produto->tamanho_g == 'G' ? 'checked' : null; ?> style="margin:2px;">G</label><br>
                    </div>

                    <div style="border: 2px  solid black">
                      <label><input type="checkbox" name="tamanho_gg" value="GG" <?= $produto->tamanho_gg == 'GG' ? 'checked' : null; ?> style="margin:2px;">GG</label><br>
                    </div>
                    <div style="border: 2px  solid black;">
                      <label><input type="checkbox" name="tamanho_xg" value="XG" <?= $produto->tamanho_xg == 'XG' ? 'checked' : null; ?> style="margin:2px;">XG</label><br>
                    </div>

                    <div style="border: 2px  solid black">
                      <label><input type="checkbox" name="tamanho_lllxl" value="3XL" <?= $produto->tamanho_lllxl == '3XL' ? 'checked' : null ?> style="margin:2px;">3XL</label><br>
                    </div>

                    <div style="border: 2px  solid black;">
                      <label><input type="checkbox" name="tamanho_llll_xl" value="4XL" <?= $produto->tamanho_llll_xl == '4XL' ? 'checked' : null ?> style="margin:5px;">4XL</label><br>
                    </div>

                  </div>

                </div>

                <div class="form-group row mb-7">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lançamento</label>
                  <div class="col-md-7">
                    <div style="border: 2px  solid black;">
                      <label><input type="checkbox" name="lancamentos" value="L" <?= $produto->lancamentos == 'L' ? 'checked' : null ?> style="margin:5px;">Laçamento</label><br>
                    </div>
                  </div>
                </div>

                <!-- FIM TAMANHO MAYKONSILVEIRA.COM.BR -->


                <!-- INICIO STATUS MAYKONSILVEIRA.COM.BR -->
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> Status (Obrigatório)</label>

                  <div class="col-md-7">
                    <select name="status" class="form-control select2 load_categoria" style="width: 100%;">

                      <option value="S" <?= $produto->status == 'S' ? 'selected' : null; ?>> Ativo </option>
                      <option value="N" <?= $produto->status == 'N' ? 'selected' : null; ?>> Cancelado </option>

                    </select>
                  </div>
                </div>
                <!-- FIM STATUS MAYKONSILVEIRA.COM.BR -->



                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Descrição</label>

                  <div class="col-md-7">
                    <textarea class="summernote" name="descricao"><?= $produto->descricao ?></textarea>
                  </div>

                </div>



                <div class="form-group row">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Palavras chaves(Obrigatório)</label>

                  <div class="col-md-7">
                    <input type="text" class="form-control inputtags" name="tags" value="<?= $produto->tags ? $produto->tags : null; ?>">
                  </div>
                </div>


                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Enviar Fotos(Opcional)</label>
                  <div class="col-md-7">
                    <input type="file" multiple="" class="form-control" name="fotos[]">
                  </div>

                </div>


                <input type="hidden" name="id" value="<?= $produto->id ?>">
                <input type="hidden" name="usuario" value="<?= $_SESSION['sheep_user']['id'] ?>">
                <input type="hidden" name="sheep_firewall" value="<?= $_SESSION['_sheep_firewall'] ?>">
                <input type="hidden" name="tipo" value="produto">
                <input type="hidden" name="tipo_cadastro" value="atualizar">



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


  <!-- INICIO GALERIAS MAYKONSILVEIRA.COM.BR -->
  <section class="section">
    <div class="section-body">
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
          <div class="card">
            <div class="card-header">
              <h4>Galerias de fotos</h4>
            </div>
            <div class="card-body">

              <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                <?php
                $ler->Leitura('galeria_produto', "WHERE id_produto = :idGl AND tipo = 'produto'", "idGl={$editar}");
                $galeriasProdutos = Formata::Resultado($ler);
                if ($galeriasProdutos) {
                  foreach ($ler->getResultado() as $galeria) {
                    $galeria = (object) $galeria;


                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="removeGaleria">
                      <form action="" method="post">

                        <button type="button" class="btn btn-danger" name="id" data-idmsflix="<?= $galeria->id ?>" style="position:absolute; top:5px; left:80px;" onclick="excluirGaleriaDeProdutos(this)"><i data-feather="trash-2" style="font-size:10px!important;"></i></button>
                      </form>
                      <a href="<?= SHEEP_IMG_PRODUTOS . $galeria->imagem ?>" data-sub-html="">
                        <img class="img-responsive thumbnail" src="<?= SHEEP_IMG_PRODUTOS . $galeria->imagem ?>" alt="" style="width:120px; height:auto; object-fit:cover;">
                      </a>
                    </div>
                <?php
                  }
                }
                ?>

                <hr>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- FIM GLERIAS MAYKONSILVEIRA.COM.BR -->


</div>

<?php
$sheep = null;
$ler = null;
?>