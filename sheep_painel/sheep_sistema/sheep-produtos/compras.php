<div class="main-content">

<!-- INICIO NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL ?>sheep.php">Inicio</a></li>
<li class="breadcrumb-item"><a href="<?= URL_CAMINHO_PAINEL . FILTROS ?>sheep-produtos/criar&token=<?= $_SESSION['timeWT'] ?> ">Novo</a></li>
<li class="breadcrumb-item active" aria-current="page">Compras Recentes</li>
</ol>
</nav>
<!-- FIM NAVEGAÇÃO MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

<section class="section">
<div class="section-body">
            
<!-- INICIO TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<?php include_once('./token.php'); ?>
<!-- FIM TOKEN URL MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->

<!-- INICIO TABELA  MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA -->
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-header">
<h4>Compras Recentes</h4>
</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-striped table-hover" id="save-stage" style="width:100%;">
<thead>
<tr>
<th>Nº</th>
<th>Foto</th>
<th>Add Carrinho</th>
<th>Produto</th>
<th>QTD</th>
<th>Valor</th>
<th>Cliente</th>
<th>Frete</th>
<th>Entrega</th>
<th>Valor Total</th>
<th>Ver +</th>

</tr>
</thead>
<tbody>
<?php
                                        
?>
<tr>
<td>77</td>
<td>
<a href="#" data-toggle="modal" data-target="#ver">
<img alt="" src="assets/img/sem-imagem.png" width="35">
</a>
</td>
<td>data</td>
<td>Titulo</td>
<td>7</td>
<td><b>R$ 77</b></td>
<td>Cliente</td>
<td>Transportadora</td>
<td>3 dias</td>
<td>R$ 77</td>
<td> <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ver">Ver </a></td>
</tr>
<?php ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- INICIO MODAL SUPORTE MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<!-- basic modal -->
<div class="modal fade" id="ver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Titulo </h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<p>
<img alt="" src="assets/img/sem-imagem.png" style="width:100%;">
</p>
<p>Criado(a): data</p>
<p>Produto: 77</p>
<p>Valor: R$ 77</p>
<p>Adicionou ao Carrinho: Data</p>
<p>Quantidade: 3</p>
<p>Valor: <b> R$ 77</b></p>
<p>Cliente: Maykon Silveira</p>
<p>Transportadora: Correios</p>
<p>Valor do Frete: R$ 77</p>
<p>Prazo de Entrega: 3 dias</p>
<p>Grupo do Produto: idSessao</td>
<p>Valor Total Com Frete: R$ 77</p>
<p>Endereco: Rua Jesus Te Ama e Tem um plano na sua vida</td>
<p>Numero: 777</td>
<p>CEP: CEP</td>
<p>Cidade: Cidade</td>
<p>EStado: Estado</td>
</div>
<div class="modal-footer bg-whitesmoke br">
<button type="button" class="btn btn-danger" data-dismiss="modal">x</button>
</div>
</div>
</div>
</div>

<!-- FIM MODAL SUPORTE MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA--->
<?php
$sheep = null;
?>

</div>