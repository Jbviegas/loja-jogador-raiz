<body>

    <div class="container" style="margin-top: 100px;">

        <span>
            <?php
            $carrinhoCompras = new Ler();
            $carrinhoCompras->Leitura('produto_cliente', "WHERE tipo = 'produto' AND usuario = :id", "id={$_SESSION['sheep_user']['id']}"
            );
            if (!empty($carrinhoCompras->getResultado())) {
                echo '<h4>Suas imagens enviadas</h4>';
            } else {
                echo '<h4>Você ainda não enviou nenhuma imagem</h4>';
            }
            ?>
        </span>
        <br><br>

        <?php
        // Leitura da tabela, ordenando pela data mais recente primeiro
        $sheep->Leitura(
            'produto_cliente',
            "WHERE tipo = 'produto' AND usuario = :id ORDER BY data DESC",
            "id={$_SESSION['sheep_user']['id']}"
        );

        $minhasCompras = Formata::Resultado($sheep);

        if ($minhasCompras) {
            foreach ($sheep->getResultado() as $compras) {
                $compras = (object) $compras;

                // Caminho da imagem (verifica se é URL ou arquivo local)
                $imgSrc = (!empty($compras->capa))
                    ? (filter_var($compras->capa, FILTER_VALIDATE_URL)
                        ? $compras->capa
                        : SHEEP_IMG_PRODUTOS . $compras->capa)
                    : "assets/img/sem-imagem.png";
        ?>
                <p>
                    <img alt="<?= htmlspecialchars($compras->produto) ?>"
                        src="<?= $imgSrc ?>"
                        style="width:100px;">
                </p>
                <p>Foto: <?= $compras->titulo_b ?> </p>
                <p>Produto: <?= $compras->titulo ?> </p>
                <p>N° Pedido: <?= $compras->transacao ?> </p>
        <?php
            }
        }
        ?>

    </div>
</body>