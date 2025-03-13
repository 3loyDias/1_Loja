<?php

use core\classes\store;
?>

<style>
/* Estilo fallback para quando o CSS principal não carrega */
.admin-header {
  background-color: #1a1a1a;
  color: white;
  padding: 15px 0;
}
/* Esconde os itens de menu por padrão, serão mostrados pelo CSS principal */
.admin-nav {
  display: none;
}
/* Com CSS carregado, esta classe é ativada via JavaScript */
.css-loaded .admin-nav {
  display: flex;
}
</style>

<header class="admin-header">
  <div class="container">
    <div class="row align-items-center">
      <!-- Logo -->
      <div class="col-auto">
        <a href="?a=admin" class="logo-container">
          <div class="logo-wrapper">
            <img src="<?= BASE_URL . 'assets/images/logo-w.png'?>" alt="Logo da Empresa" class="logo-img">
            <div class="logo-glow"></div>
          </div>
          <div class="logo-text">
            <span class="brand-name">Visual Barbers</span>
            <span class="brand-tagline">Painel Administrativo</span>
          </div>
        </a>
      </div>
      
      <!-- Menu (oculto por padrão) -->
      <div class="col">
        <div class="admin-nav">
          <a href="?a=admin" class="nav-item" data-tooltip="Dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
          <a href="?a=admin_clientes" class="nav-item" data-tooltip="Clientes">
            <i class="fas fa-users"></i>
            <span>Clientes</span>
          </a>
          <a href="?a=admin_produtos" class="nav-item" data-tooltip="Produtos">
            <i class="fas fa-box"></i>
            <span>Produtos</span>
          </a>
          <a href="?a=admin_encomendas" class="nav-item" data-tooltip="Encomendas">
            <i class="fas fa-shopping-bag"></i>
            <span>Encomendas</span>
          </a>
          
          <?php if (store::adminLogado()) : ?>
            <div class="dropdown admin-dropdown">
              <a href="#" class="nav-item profile-item dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-avatar">
                  <i class="fas fa-user-circle"></i>
                </div>
                <span><?= $_SESSION['admin_utilizador'] ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li>
                  <a class="dropdown-item" href="?a=admin_perfil">
                    <i class="fas fa-user-cog me-2"></i> Meu Perfil
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item" href="?a=admin_logout">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                  </a>
                </li>
              </ul>
            </div>
          <?php else : ?>
            <a href="?a=admin_login" class="nav-item">
              <i class="fas fa-sign-in-alt"></i>
              <span>Login</span>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Barra de navegação móvel (oculta por padrão) -->
<div class="mobile-nav-toggle" style="display: none;">
  <button class="hamburger-menu">
    <span></span>
    <span></span>
    <span></span>
  </button>
</div>

<div class="mobile-nav" style="display: none;">
  <div class="mobile-nav-header">
    <img src="<?= BASE_URL . 'assets/images/logo-w.png'?>" alt="Logo" class="mobile-logo">
    <button class="mobile-nav-close">
      <i class="fas fa-times"></i>
    </button>
  </div>
  <div class="mobile-nav-content">
    <a href="?a=admin" class="mobile-nav-item">
      <i class="fas fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
    <a href="?a=admin_clientes" class="mobile-nav-item">
      <i class="fas fa-users"></i>
      <span>Clientes</span>
    </a>
    <a href="?a=admin_produtos" class="mobile-nav-item">
      <i class="fas fa-box"></i>
      <span>Produtos</span>
    </a>
    <a href="?a=admin_encomendas" class="mobile-nav-item">
      <i class="fas fa-shopping-bag"></i>
      <span>Encomendas</span>
    </a>
    <?php if (store::adminLogado()) : ?>
      <a href="?a=admin_perfil" class="mobile-nav-item">
        <i class="fas fa-user-cog"></i>
        <span>Meu Perfil</span>
      </a>
      <a href="?a=admin_logout" class="mobile-nav-item">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
      </a>
    <?php else : ?>
      <a href="?a=admin_login" class="mobile-nav-item">
        <i class="fas fa-sign-in-alt"></i>
        <span>Login</span>
      </a>
    <?php endif; ?>
  </div>
</div>

<!-- Espaçador para compensar o header fixo -->
<div class="header-spacer"></div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Verificar se o CSS foi carregado
    const cssLoaded = getComputedStyle(document.body).getPropertyValue('--css-loaded');
    if (cssLoaded || document.body.classList.contains('admin-page')) {
      document.body.classList.add('css-loaded');
    }
    
    // Mostrar/esconder menu móvel
    const mobileToggle = document.querySelector('.hamburger-menu');
    const mobileNav = document.querySelector('.mobile-nav');
    const mobileClose = document.querySelector('.mobile-nav-close');
    
    if (mobileToggle && mobileNav && mobileClose) {
      // Mostrar botão de menu móvel se CSS carregado
      document.querySelector('.mobile-nav-toggle').style.display = 'block';
      
      mobileToggle.addEventListener('click', function() {
        mobileNav.classList.toggle('active');
        document.body.classList.toggle('mobile-menu-open');
      });
      
      mobileClose.addEventListener('click', function() {
        mobileNav.classList.remove('active');
        document.body.classList.remove('mobile-menu-open');
      });
    }
    
    // Adicionar classe ativa no menu atual
    const currentPath = window.location.search;
    const navItems = document.querySelectorAll('.nav-item, .mobile-nav-item');
    
    navItems.forEach(item => {
      const href = item.getAttribute('href');
      if (href && currentPath.includes(href.substring(href.indexOf('?')))) {
        item.classList.add('active');
      }
    });
  });
</script>