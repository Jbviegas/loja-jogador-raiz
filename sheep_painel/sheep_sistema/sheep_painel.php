<?php
$ano = date('Y');
$mes = date('m');

//soma pagamento finalizado AAA
$somaFinalizadosTopo = 0;
$sheep->Leitura('minhas_compras', "WHERE (finalizado = 'S' AND status != 'canceled' AND status != 'refunded' AND status != 'unpaid') AND mes = :mes AND ano = :ano ORDER BY data DESC", "mes={$mes}&ano={$ano}");
$minhasComprasFinalizadas = Formata::Resultado($sheep);
if ($minhasComprasFinalizadas) {
  foreach ($sheep->getResultado() as $compras) {
    $compras = (object) $compras;
    $somaFinalizadosTopo += $compras->valor_produto * $compras->quantidade;;
  }
}

//soma pagamento aprovado
$somaAprovadosTopo = 0;
$sheep->Leitura('minhas_compras', "WHERE status = 'paid' AND mes = :mes AND ano = :ano ORDER BY data DESC", "mes={$mes}&ano={$ano}");
$minhasComprasAprovadas = Formata::Resultado($sheep);
if ($minhasComprasAprovadas) {
  foreach ($sheep->getResultado() as $compras) {
    $compras = (object) $compras;
    $somaAprovadosTopo += $compras->valor_produto * $compras->quantidade;;
  }
}


//soma pagamento pendente
$somaPendentesTopo = 0;
$sheep->Leitura('minhas_compras', "WHERE status = 'waiting' AND finalizado != 'C' AND mes = :mes ORDER BY data DESC", "mes={$mes}");
$minhasComprasPendentes = Formata::Resultado($sheep);
if ($minhasComprasPendentes) {
  foreach ($sheep->getResultado() as $compras) {
    $compras = (object) $compras;
    $somaPendentesTopo += $compras->valor_produto * $compras->quantidade;
  }
}

//soma pagamentos processados
$somaProcessandoTopo = 0;
$sheep->Leitura('minhas_compras', "WHERE (finalizado = 'N' OR finalizado = 'S' OR finalizado = 'C') AND mes = :mes AND ano = :ano ORDER BY data DESC", "mes={$mes}&ano={$ano}");
$minhasComprasProcessando = Formata::Resultado($sheep);
if ($minhasComprasProcessando) {
  foreach ($sheep->getResultado() as $compras) {
    $compras = (object) $compras;
    $somaProcessandoTopo += $compras->valor_produto * $compras->quantidade;;
  }
}

//soma pagamento em recusado
$somaRecusadoTopo = 0;
$sheep->Leitura('minhas_compras', "WHERE status = 'unpaid' AND mes = :mes ORDER BY data DESC", "mes={$mes}");
$minhasComprasRecusadas = Formata::Resultado($sheep);
if ($minhasComprasRecusadas) {
  foreach ($sheep->getResultado() as $compras) {
    $compras = (object) $compras;
    $somaRecusadoTopo += $compras->valor_produto * $compras->quantidade;;
  }
}

// Soma pagamento cancelado do mês atual
$somaCanceladosTopo = 0;

// Corrigindo a condição para pegar apenas cancelados do mês atual
$sheep->Leitura('minhas_compras', "WHERE (finalizado = 'C' OR status = 'canceled' OR status = 'refunded') AND mes = :mes ORDER BY data DESC", "mes={$mes}");

$minhasComprasCanceladas = Formata::Resultado($sheep);

if ($minhasComprasCanceladas) {
  foreach ($sheep->getResultado() as $compras) {
    $compras = (object) $compras;
    $somaCanceladosTopo += $compras->valor_produto * $compras->quantidade;
  }
}




//total de produtos
$lerTopoHome = new Ler();
$lerTopoHome->Leitura('produto');
if ($lerTopoHome->getResultado()) {
  $contaProdutoTopo = $lerTopoHome->getContaLinhas();
} else {
  $contaProdutoTopo = 0;
}


//total de clientes
$lerTopoHome->Leitura('usuarios');
$totalClientesTopo = Formata::Resultado($lerTopoHome);
if ($totalClientesTopo) {
  $contaClienteTopo = $lerTopoHome->getContaLinhas();
} else {
  $contaClienteTopo = 0;
}
?>

<div class="main-content">
  <section class="section">
    <div class="section-body">

      <!-- INICIO BLOCOS MAYKONSILVEIRA.COM.BR -->
      <div class="row ">

        <!-- INICIO PAGAMENTO FINALIZADO BLOCO  MAYKONSILVEIRA.COM.BR -->
        <div class="col-xl-3 col-lg-6">
          <div class="card bg-green">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-award"></i></div>
              <div class="card-content">
                <h4 class="card-title">PG Finalizados</h4>
                <span>R$ <?= Formata::vr($somaFinalizadosTopo) ?></span>
                <div class="progress mt-1 mb-1" data-height="8">
                  <div class="progress-bar l-bg-purple" role="progressbar" data-width="100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-0 text-sm">
                  <span class="mr-2"><i class="fa fa-arrow-up"></i></span>
                  <span class="text-nowrap">Pagamentos Finalizados</span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- FIM PAGAMENTO FINALIZADO BLOCO  MAYKONSILVEIRA.COM.BR -->

        <!-- INICIO PAGAMENTO APROVADO BLOCO  MAYKONSILVEIRA.COM.BR -->
        <div class="col-xl-3 col-lg-6">
          <div class="card l-bg-green">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-award"></i></div>
              <div class="card-content">
                <h4 class="card-title">PG Aprovados</h4>
                <span>R$ <?= Formata::vr($somaAprovadosTopo) ?></span>
                <div class="progress mt-1 mb-1" data-height="8">
                  <div class="progress-bar l-bg-purple" role="progressbar" data-width="100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-0 text-sm">
                  <span class="mr-2"><i class="fa fa-arrow-up"></i></span>
                  <span class="text-nowrap">Pagamentos Aprovados</span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- FIM PAGAMENTO APROVADO BLOCO  MAYKONSILVEIRA.COM.BR -->

        <!-- INICIO PAGAMENTO PENDENTE BLOCO  MAYKONSILVEIRA.COM.BR -->
        <div class="col-xl-3 col-lg-6">
          <div class="card bg-yellow">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
              <div class="card-content">
                <h4 class="card-title" style="color: black">PG Pendentes</h4>
                <span style="color: black">R$ <?= Formata::vr($somaPendentesTopo) ?></span>
                <div class="progress mt-1 mb-1" data-height="8">
                  <div class="progress-bar l-bg-green" role="progressbar" data-width="100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-0 text-sm">
                  <span class="mr-2"><i class="fa fa-arrow-up"></i></span>
                  <span class="text-nowrap" style="color: black">Pagamentos Pendentes</span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- FIM PAGAMENTO PENDENTE BLOCO  MAYKONSILVEIRA.COM.BR -->

        <!-- INICIO PAGAMENTOS PROCESSADOS BLOCO  MAYKONSILVEIRA.COM.BR -->
        <div class="col-xl-3 col-lg-6">
          <div class="card l-bg-orange">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
              <div class="card-content">
                <h4 class="card-title">PG Processados</h4>
                <span>R$ <?= Formata::vr($somaProcessandoTopo) ?></span>
                <div class="progress mt-1 mb-1" data-height="8">
                  <div class="progress-bar l-bg-green" role="progressbar" data-width="100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-0 text-sm">
                  <span class="mr-2"><i class="fa fa-arrow-up"></i></span>
                  <span class="text-nowrap">Pagamentos Processados</span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- FIM PAGAMENTO PROCESSANDO BLOCO  MAYKONSILVEIRA.COM.BR -->

        <!-- INICIO PAGAMENTO RECUSADO BLOCO  MAYKONSILVEIRA.COM.BR -->
        <div class="col-xl-3 col-lg-6">
          <div class="card bg-black">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
              <div class="card-content">
                <h4 class="card-title">PG Recusado</h4>
                <span>R$ <?= Formata::vr($somaRecusadoTopo) ?></span>
                <div class="progress mt-1 mb-1" data-height="8">
                  <div class="progress-bar l-bg-green" role="progressbar" data-width="100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-0 text-sm">
                  <span class="mr-2"><i class="fa fa-arrow-up"></i></span>
                  <span class="text-nowrap">Pagamentos Recusados</span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- FIM PAGAMENTO RECUSADO BLOCO  MAYKONSILVEIRA.COM.BR -->

        <!-- INICIO PAGAMENTO CANCELADO BLOCO  MAYKONSILVEIRA.COM.BR -->
        <div class="col-xl-3 col-lg-6">
          <div class="card bg-red">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-money-bill-alt"></i></div>
              <div class="card-content">
                <h4 class="card-title">PG Cancelados</h4>
                <span>R$ <?= Formata::vr($somaCanceladosTopo) ?></span>
                <div class="progress mt-1 mb-1" data-height="8">
                  <div class="progress-bar l-bg-red" role="progressbar" data-width="100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-0 text-sm">
                  <span class="mr-2"><i class="fa fa-arrow-up"></i></span>
                  <span class="text-nowrap">Pagamentos Cancelados</span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- FIM PAGAMENTO CANCELADO BLOCO  MAYKONSILVEIRA.COM.BR -->

        <!-- INICIO PRODUTOS BLOCO  MAYKONSILVEIRA.COM.BR -->
        <div class="col-xl-3 col-lg-6">
          <div class="card l-bg-cyan">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-briefcase"></i></div>
              <div class="card-content">
                <h4 class="card-title">Total de Produtos</h4>
                <span><?= $contaProdutoTopo ?></span>
                <div class="progress mt-1 mb-1" data-height="8">
                  <div class="progress-bar l-bg-orange" role="progressbar" data-width="100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-0 text-sm">
                  <span class="mr-2"><i class="fa fa-arrow-up"></i></span>
                  <span class="text-nowrap">Produtos em Estoque</span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- FIM PRODUTOS BLOCO  MAYKONSILVEIRA.COM.BR -->

        <!-- INICIO CLIENTES BLOCO  MAYKONSILVEIRA.COM.BR -->
        <div class="col-xl-3 col-lg-6">
          <div class="card l-bg-purple">
            <div class="card-statistic-3">
              <div class="card-icon card-icon-large"><i class="fa fa-globe"></i></div>
              <div class="card-content">
                <h4 class="card-title">Clientes</h4>
                <span><?= $contaClienteTopo ?></span>
                <div class="progress mt-1 mb-1" data-height="8">
                  <div class="progress-bar l-bg-cyan" role="progressbar" data-width="100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="mb-0 text-sm">
                  <span class="mr-2"><i class="fa fa-arrow-up"></i></span>
                  <span class="text-nowrap">Clientes Cadastrados</span>
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- FIM CLIENTES BLOCO  MAYKONSILVEIRA.COM.BR -->

      </div>
      <!-- FIM BLOCOS MAYKONSILVEIRA.COM.BR -->






      <!-- INICIO CONTADOR DE VISITAS EM PRODUTOS MAYKONSILVEIRA.COM.BR -->
      <div class="row clearfix">

        <!-- INICIO CONTADOR DE VISITAS EM PRODUTOS MAYKONSILVEIRA.COM.BR -->
        <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12 col-6">
          <div class="card">
            <div class="card-header">
              <h4>Visitas em Produtos</h4>
            </div>
            <div class="card-body">
              <div class="recent-report__chart">
                <div id="barChart"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- FIM CONTADOR DE VISITAS EM PRODUTOS MAYKONSILVEIRA.COM.BR -->
        <!--
        INICIO CONTADOR DE VISITAS EM CATEGORIA DE PRODUTOS MAYKONSILVEIRA.COM.BR 

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-6">
          <div class="card">
            <div class="card-header">
              <h4>Categorias mais Visitas</h4>
            </div>
            <div class="card-body">
              <div class="recent-report__chart">
                <div id="pieChart"></div>
              </div>
            </div>
          </div>
        </div>

        FIM CONTADOR DE VISITAS EM CATEGORIA DE PRODUTOS MAYKONSILVEIRA.COM.BR 

-->

      </div>
      <!-- FIM CONTADOR DE VISITAS EM PRODUTOS MAYKONSILVEIRA.COM.BR -->

      <!-- INICIO CONTROLES EM GERAL DE ESTOQUE E PRODUTOS MAYKONSILVEIRA.COM.BR -->

    </div>
  </section>


  <div class="settingSidebar">
    <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
    </a>
    <div class="settingSidebar-body ps-container ps-theme-default">
      <div class=" fade show active">
        <div class="setting-panel-header">Personalize seu painel
        </div>
        <div class="p-15 border-bottom">
          <h6 class="font-medium m-b-10">Layout</h6>
          <div class="selectgroup layout-color w-50">
            <label class="selectgroup-item">
              <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
              <span class="selectgroup-button">Claro</span>
            </label>
            <label class="selectgroup-item">
              <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
              <span class="selectgroup-button">Escuro</span>
            </label>
          </div>
        </div>
        <div class="p-15 border-bottom">
          <h6 class="font-medium m-b-10">Cor da Lateral</h6>
          <div class="selectgroup selectgroup-pills sidebar-color">
            <label class="selectgroup-item">
              <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
              <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
            </label>
            <label class="selectgroup-item">
              <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
              <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
            </label>
          </div>
        </div>
        <div class="p-15 border-bottom">
          <h6 class="font-medium m-b-10">Cor do Tema</h6>
          <div class="theme-setting-options">
            <ul class="choose-theme list-unstyled mb-0">
              <li title="white" class="active">
                <div class="white"></div>
              </li>
              <li title="cyan">
                <div class="cyan"></div>
              </li>
              <li title="black">
                <div class="black"></div>
              </li>
              <li title="purple">
                <div class="purple"></div>
              </li>
              <li title="orange">
                <div class="orange"></div>
              </li>
              <li title="green">
                <div class="green"></div>
              </li>
              <li title="red">
                <div class="red"></div>
              </li>
            </ul>
          </div>
        </div>
        <div class="p-15 border-bottom">
          <div class="theme-setting-options">
            <label class="m-b-0">
              <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="mini_sidebar_setting">
              <span class="custom-switch-indicator"></span>
              <span class="control-label p-l-10">Mini Lateral</span>
            </label>
          </div>
        </div>
        <div class="p-15 border-bottom">
          <div class="theme-setting-options">
            <label class="m-b-0">
              <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="sticky_header_setting">
              <span class="custom-switch-indicator"></span>
              <span class="control-label p-l-10">Esticar Topo</span>
            </label>
          </div>
        </div>
        <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
          <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
            <i class="fas fa-undo"></i> Restaurar
          </a>
        </div>
      </div>
    </div>


  </div>


</div>


<script>
  /** 
   * 
   * grafico de visitas nos produtos 
   * MAYKONSILVEIRA.COM.BR
   * 
   */
  function barChart() {
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end



    // Create chart instance
    var chart = am4core.create("barChart", am4charts.XYChart);
    chart.scrollbarX = new am4core.Scrollbar();



    // Add data
    chart.data = [
      <?php
      $lerTopoHome->Leitura('produto', "WHERE tipo = 'produto' ORDER BY visitas DESC LIMIT 5");
      $graficoProdutosTopo = Formata::Resultado($lerTopoHome);
      if ($graficoProdutosTopo) {
        foreach ($lerTopoHome->getResultado() as $produtoTopo) {
          $produtoTopo = (object) $produtoTopo;
      ?> {
            "country": "<?= Formata::LimitaTextos($produtoTopo->titulo, 2) ?>",
            "visits": <?= $produtoTopo->visitas ?>
          },
      <?php }
      } ?>

    ];

    // Create axes
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "country";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.minGridDistance = 30;
    categoryAxis.renderer.labels.template.horizontalCenter = "right";
    categoryAxis.renderer.labels.template.verticalCenter = "middle";
    categoryAxis.renderer.labels.template.rotation = 270;
    categoryAxis.tooltip.disabled = true;
    categoryAxis.renderer.minHeight = 110;
    categoryAxis.renderer.labels.template.fill = am4core.color("#9aa0ac");

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.renderer.minWidth = 50;
    valueAxis.renderer.labels.template.fill = am4core.color("#9aa0ac");

    // Create series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.sequencedInterpolation = true;
    series.dataFields.valueY = "visits";
    series.dataFields.categoryX = "country";
    series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
    series.columns.template.strokeWidth = 0;


    series.tooltip.pointerOrientation = "vertical";

    series.columns.template.column.cornerRadiusTopLeft = 10;
    series.columns.template.column.cornerRadiusTopRight = 10;
    series.columns.template.column.fillOpacity = 0.8;

    // on hover, make corner radiuses bigger
    let hoverState = series.columns.template.column.states.create("hover");
    hoverState.properties.cornerRadiusTopLeft = 0;
    hoverState.properties.cornerRadiusTopRight = 0;
    hoverState.properties.fillOpacity = 1;

    series.columns.template.adapter.add("fill", (fill, target) => {
      return chart.colors.getIndex(target.dataItem.index);
    })

    // Cursor
    chart.cursor = new am4charts.XYCursor();
  }


  /** 
   * 
   * grafico de visitas nas categorias
   * MAYKONSILVEIRA.COM.BR
   * 
   */


  function pieChart() {
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("pieChart", am4charts.PieChart);

    // Add data
    chart.data = [


      <?php
      $lerTopoHome->Leitura('categorias', "WHERE tipo = 'categoria' ORDER BY visitas DESC LIMIT 5");
      $graficoCategoriaTopo = Formata::Resultado($lerTopoHome);
      if ($graficoCategoriaTopo) {
        foreach ($lerTopoHome->getResultado() as $departamentoTopo) {
          $departamentoTopo = (object) $departamentoTopo;
      ?> {
            "country": "<?= $departamentoTopo->nome ?>",
            "litres": <?= $departamentoTopo->visitas ?>
          },
      <?php }
      } ?>


    ];

    // Add and configure Series
    var pieSeries = chart.series.push(new am4charts.PieSeries());
    pieSeries.dataFields.value = "litres";
    pieSeries.dataFields.category = "country";
    pieSeries.slices.template.stroke = am4core.color("#fff");
    pieSeries.slices.template.strokeWidth = 2;
    pieSeries.slices.template.strokeOpacity = 1;
    pieSeries.labels.template.fill = am4core.color("#9aa0ac");

    // This creates initial animation
    pieSeries.hiddenState.properties.opacity = 1;
    pieSeries.hiddenState.properties.endAngle = -90;
    pieSeries.hiddenState.properties.startAngle = -90;
  }
</script>