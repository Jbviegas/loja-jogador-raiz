<div class="main-content">
    <section class="section">
        <div class="section-body">


            <!-- INICIO CONTADOR DE VISITAS EM PRODUTOS MAYKONSILVEIRA.COM.BR -->
            <div class="row clearfix">

                <!-- INICIO CONTADOR DE VISITAS EM PRODUTOS MAYKONSILVEIRA.COM.BR -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Visitas em Produtos</h4>
                        </div>
                        <div class="card-body">
                            <div class="recent-report__chart">
                                <canvas id="meuGrafico" style="height:300px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIM CONTADOR DE VISITAS EM PRODUTOS MAYKONSILVEIRA.COM.BR -->


            </div>
            <!-- FIM CONTADOR DE VISITAS EM PRODUTOS MAYKONSILVEIRA.COM.BR -->



            <!-- INICIO TABELA MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA -->
            <div class="row">
                <div class="col-12">
                 
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                                    
                                    <tbody>
                                        <?php
                                        $lerRelatorio = new Ler();
                                        $lerRelatorio->Leitura('produto', "ORDER BY visitas DESC");
                                        if ($lerRelatorio->getResultado()) {
                                            foreach ($lerRelatorio->getResultado() as $relatorio) {
                                                $relatorio = (object) $relatorio;

                                        ?>
                                               
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
           
            <!-- fim TABELA MAYKONSILVEIRA.COM.BR MAYKON SILVEIRA -->


        </div>
    </section>


</div>


<script>
    const ctx = document.getElementById('meuGrafico').getContext('2d');
    const meuGrafico = new Chart(ctx, {
        type: 'bar',
        data: {


            labels: [
                <?php
                $lerRelatorio->Leitura('produto', "ORDER BY visitas DESC");
                if ($lerRelatorio->getResultado()) {
                    foreach ($lerRelatorio->getResultado() as $relatorio) {
                        $relatorio = (object) $relatorio;

                ?> '<?= Formata::LimitaTextos($relatorio->titulo, 2) ?>',
                <?php }
                } ?>

            ],


            datasets: [{
                label: 'Visitas por Produto',


                data: [

                    <?php
                    if ($lerRelatorio->getResultado()) {
                        foreach ($lerRelatorio->getResultado() as $relatorio) {
                            $relatorio = (object) $relatorio;
                    ?>
                            <?= $relatorio->visitas ?>,
                    <?php }
                    } ?>

                ],

                backgroundColor: 'rgba(84, 3, 138, 0.7)',
                borderColor: 'rgba(50,3, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>