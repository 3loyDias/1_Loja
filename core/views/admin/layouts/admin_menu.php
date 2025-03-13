<div class="d-flex flex-column flex-shrink-0 p-4 shadow-sm" style="width: 280px; height: 100vh; background-color: var(--light-bg); border-right: 1px solid var(--border-color);">
  <a href="/" class="d-flex align-items-center mb-4 me-md-auto text-decoration-none">
    <i class="fas fa-cut me-2 fs-3" style="color: var(--primary-color);"></i>
    <span class="fs-4 fw-bold" style="color: var(--dark-text); letter-spacing: 0.5px;">Visual Barbers</span>
  </a>
  <hr class="my-3 bg-secondary opacity-25">
  
  <ul class="nav nav-pills flex-column mb-auto gap-1">
    <li class="nav-item">
      <a href="index.php" class="nav-link d-flex align-items-center rounded-3 px-3 py-2 <?= strpos($_SERVER['REQUEST_URI'], 'index.php') !== false ? 'active' : 'link-dark' ?>" style="transition: all 0.3s ease;">
        <i class="fas fa-home me-3"></i>
        <span>Início</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="dashboard.php" class="nav-link d-flex align-items-center rounded-3 px-3 py-2 <?= strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false ? 'active' : 'link-dark' ?>" style="transition: all 0.3s ease;">
        <i class="fas fa-tachometer-alt me-3"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="orders.php" class="nav-link d-flex align-items-center rounded-3 px-3 py-2 <?= strpos($_SERVER['REQUEST_URI'], 'orders.php') !== false ? 'active' : 'link-dark' ?>" style="transition: all 0.3s ease;">
        <i class="fas fa-list me-3"></i>
        <span>Pedidos</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="products.php" class="nav-link d-flex align-items-center rounded-3 px-3 py-2 <?= strpos($_SERVER['REQUEST_URI'], 'products.php') !== false ? 'active' : 'link-dark' ?>" style="transition: all 0.3s ease;">
        <i class="fas fa-box me-3"></i>
        <span>Produtos</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="?a=admin_clientes" class="nav-link d-flex align-items-center rounded-3 px-3 py-2 <?= isset($_GET['a']) && $_GET['a'] == 'admin_clientes' ? 'active' : 'link-dark' ?>" style="transition: all 0.3s ease;">
        <i class="fas fa-users me-3"></i>
        <span>Clientes</span>
      </a>
    </li>
  </ul>
  
  <hr class="my-3 bg-secondary opacity-25">
  
  <div class="dropdown">
    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle p-2 rounded-3" 
       id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" 
       style="color: var(--dark-text); transition: all 0.2s ease;">
      <img src="https://github.com/mdo.png" alt="Profile" width="36" height="36" class="rounded-circle me-2 border shadow-sm">
      <strong><?= $_SESSION['admin_utilizador'] ?></strong>
    </a>
    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="dropdownUser">
      <li><a class="dropdown-item py-2" href="settings.php"><i class="fas fa-cog me-2 text-muted"></i>Configurações</a></li>
      <li><a class="dropdown-item py-2" href="profile.php"><i class="fas fa-user me-2 text-muted"></i>Perfil</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item py-2" href="?a=logout"><i class="fas fa-sign-out-alt me-2 text-muted"></i>Logout</a></li>
    </ul>
  </div>
</div>

