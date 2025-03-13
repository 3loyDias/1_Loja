  </div><!-- Fechamento da div content-wrapper -->

<footer class="admin-footer">
  <div class="footer-particles"></div>
  <div class="container">
    <div class="row">
      <!-- Logo e slogan -->
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <div class="footer-brand">
          <div class="footer-logo-container">
            <img src="<?= BASE_URL . 'assets/images/logo-w.png'?>" alt="Logo" class="footer-logo">
            <div class="logo-pulse"></div>
          </div>
          <div class="footer-brand-text">
            <h4>Visual Barbers</h4>
            <p>Estilo e qualidade em cada corte</p>
          </div>
        </div>
      </div>
      
      <!-- Links rápidos -->
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <h5 class="footer-title">Acesso Rápido</h5>
        <div class="footer-links">
          <a href="?a=admin" class="footer-link">
            <i class="fas fa-angle-right"></i> Dashboard
          </a>
          <a href="?a=admin_clientes" class="footer-link">
            <i class="fas fa-angle-right"></i> Clientes
          </a>
          <a href="?a=admin_produtos" class="footer-link">
            <i class="fas fa-angle-right"></i> Produtos
          </a>
          <a href="?a=admin_encomendas" class="footer-link">
            <i class="fas fa-angle-right"></i> Encomendas
          </a>
        </div>
      </div>
      
      <!-- Contato -->
      <div class="col-lg-4 col-md-12">
        <h5 class="footer-title">Suporte</h5>
        <div class="footer-contact">
          <div class="contact-item">
            <div class="icon-container">
              <i class="fas fa-envelope"></i>
            </div>
            <div>
              <p>suporte@visualbarbers.com</p>
            </div>
          </div>
          <div class="contact-item">
            <div class="icon-container">
              <i class="fas fa-phone-alt"></i>
            </div>
            <div>
              <p>+351 123 456 789</p>
            </div>
          </div>
          <div class="contact-item">
            <div class="icon-container">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div>
              <p>Rua Principal, 123, Lisboa</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Copyright e redes sociais -->
    <div class="footer-bottom">
      <div class="copyright">
        <p>&copy; <?= date('Y') ?> Visual Barbers. Todos os direitos reservados.</p>
        <p class="developer">Desenvolvido por <span class="highlight">PROJETO IVAN</span></p>
      </div>
      <div class="social-links">
        <a href="#" class="social-link" aria-label="Facebook">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="social-link" aria-label="Instagram">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="#" class="social-link" aria-label="Twitter">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="#" class="social-link" aria-label="LinkedIn">
          <i class="fab fa-linkedin-in"></i>
        </a>
      </div>
    </div>
  </div>
</footer>

<a href="#" class="back-to-top" aria-label="Voltar ao topo">
  <i class="fas fa-arrow-up"></i>
</a>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Back to top button
    const backToTopButton = document.querySelector('.back-to-top');
    
    window.addEventListener('scroll', () => {
      if (window.pageYOffset > 300) {
        backToTopButton.classList.add('active');
      } else {
        backToTopButton.classList.remove('active');
      }
    });
    
    backToTopButton.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
    
    // Animação de partículas
    const footerParticles = document.querySelector('.footer-particles');
    
    for (let i = 0; i < 50; i++) {
      const particle = document.createElement('span');
      particle.style.setProperty('--i', Math.random() * 10);
      particle.style.setProperty('--x', Math.random() * 100);
      particle.style.setProperty('--y', Math.random() * 100);
      particle.style.setProperty('--size', Math.random() * 5 + 2 + 'px');
      footerParticles.appendChild(particle);
    }
  });
</script>
