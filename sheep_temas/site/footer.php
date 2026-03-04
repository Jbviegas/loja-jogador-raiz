<!--Início Rodapé-->
<footer class="rodape">
    <div class="containner-2">
        <div class="containner-rodape">

            <div class="rodape-coluna-1">
                <h3>Compra Segura</h3>
                <p>Aceitamos diversas opções de Pagamento</p>
                <div>
                    <img src="<?= CAMINHO_TEMAS ?>/assets/img/compra-segura-removebg.png" alt="google" width="250px">
                </div>
            </div>
            <div class="rodape-coluna-2">
                <?php
                $sheep->Leitura('banners', "WHERE titulo_um = 'Logo Preta trasparente'");
                $bannerGoogleApp = Formata::Resultado($sheep);
                if ($bannerGoogleApp):
                ?>
                    <img src="<?= HOME ?>/img-banners/<?= $sheep->getResultado()[0]['capa'] ?>" alt="Logo Preta transparente" width="300px">
                <?php endif; ?>
                <p>Nossa missão é proporcinar a vocês nossos clientes
                    a melhor experiência de compra e o melhor atendimento.</p>
            </div>

        </div>
        <div class="rodape-coluna-3">
            <h3>Mais informações</h3>
            <ul>
                <li style="margin-bottom: 3px;"><a href="<?= HOME ?>/politica-privacidade">Politica de Privacidade</a></li>
                <li style="margin-bottom: 3px;"><a href="<?= HOME ?>/politica-envio-prazo">Políticas de Envio e Prazo de Entrega</a></li>
                <li style="margin-bottom: 3px;"><a href="<?= HOME ?>/politica-reembolso-devolucao">Políticas de Reembolso e Devolução</a></li>
                <li style="margin-bottom: 3px;"><a href="<?= HOME ?>/faq-perguntas">FAQ - Perguntas Frequentes</a></li>
            </ul>
        </div>
        <div class="rodape-coluna-4" style="margin-left: 7px;">
            <h3>Redes Sociais</h3>
            <ul>
                <li><a href="">Instagram</a></li>
                <li><a href="">Facebook</a></li>
                <li><a href="">YouTube</a></li>
                <li><a href="">TikTok</a></li>
            </ul>
        </div>

    </div>
    <div class="copyright">
        <p class="copy">&#9400; <?= SITENAME ?> - Todos os Direitos Reservados</p>
    </div>
</footer>
<!--Fim Rodapé-->