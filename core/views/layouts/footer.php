<!-- Wrapper para garantir que o footer fique sempre no fim -->
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Conteúdo da página vai aqui -->
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row py-4">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="assets/images/logo-w.png" alt="Logo da Empresa" class="footer-logo mb-3">
                    <p class="footer-text">
                        Sua loja online de confiança para encontrar os melhores produtos com os melhores preços.
                    </p>
                </div>
                
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="footer-heading">Links Úteis</h5>
                    <ul class="footer-links">
                        <li><a href="?a=inicio">Início</a></li>
                        <li><a href="?a=loja">Produtos</a></li>
                        <li><a href="?a=carrinho">Carrinho</a></li>
                        <li><a href="?a=minha_conta">Minha Conta</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4">
                    <h5 class="footer-heading">Contato</h5>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            Rua Principal, 123
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            +351 123 456 789
                        </li>
                        <li>
                            <i class="fas fa-envelope"></i>
                            contato@loja.com
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="row py-3">
                    <div class="col-12 text-center">
                        <p class="mb-0">
                            &copy; <?= date('Y') ?> <?= APP_NAME ?> - Todos os direitos reservados
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>