<body>

    <div class="container" style="margin-top: 100px;">
        <?php
        // Leitura da tabela, ordenando pela data mais recente primeiro
        $sheep->Leitura(
            'produto_cliente',
            " ORDER BY data DESC",
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

                // Nome seguro para download (produto + ID do pedido + data)
                $produtoSeguro = !empty($compras->produto)
                    ? preg_replace('/[^A-Za-z0-9_\-]/', '_', $compras->produto)
                    : 'produto';

                $idPedido = !empty($compras->transacao) ? $compras->transacao : '0000';
                $dataPedido = !empty($compras->data) ? date('Ymd', strtotime($compras->data)) : '00000000';

                $nomeArquivo = "{$produtoSeguro}_{$idPedido}_{$dataPedido}.jpg";
        ?>
                <div style="position: relative; display: inline-block; margin-bottom: 10px;">
                    <!-- Link para download da imagem -->
                    <a href="<?= $imgSrc ?>" download="<?= $nomeArquivo ?>" style="display: block; position: relative;">
                        <img alt="<?= htmlspecialchars($compras->produto ?? 'Produto') ?>"
                            src="<?= $imgSrc ?>"
                            style="width:100px; display: block;">
                        <!-- Ícone de download SVG sobre a imagem -->
                        <span style="
                    position: absolute;
                    top: 5px;
                    right: 5px;
                    background: rgba(0,0,0,0.5);
                    padding: 2px;
                    border-radius: 3px;
                    cursor: pointer;
                ">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                                <path d="M439-82q-76-8-141.5-42.5t-113.5-88Q136-266 108.5-335T81-481q0-155 102.5-268.5T440-880v80q-121 17-200 107.5T161-481q0 121 79 211.5T439-162v80Zm40-198L278-482l57-57 104 104v-245h80v245l103-103 57 58-200 200Zm40 198v-80q43-6 82.5-23t73.5-43l58 58q-47 37-101 59.5T519-82Zm158-652q-35-26-74.5-43T520-800v-80q59 6 113 28.5T733-792l-56 58Zm112 506-56-57q26-34 42-73.5t22-82.5h82q-8 59-30 113.5T789-228Zm8-293q-6-43-22-82.5T733-677l56-57q38 45 61 99.5T879-521h-82Z" />
                            </svg>
                        </span>
                    </a>
                </div>
                <p>Foto: <?= $compras->titulo_b ?> </p>
                <p>Produto: <?= $compras->titulo ?> </p>
                <p>ID Cliente: <?= $compras->usuario ?> </p>
                <p>N° Pedido: <?= $compras->transacao ?> </p>
                <p>Data: <?= date('d/m/Y', strtotime($compras->data)) ?></p>
        <?php
            }
        }
        ?>

    </div>

</body>