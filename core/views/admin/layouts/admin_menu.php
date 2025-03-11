<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height: 100vh;">
  <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
    <span class="fs-4 fw-bold">Visual Barbers</span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-10">
    <li class="nav-item">
      <a href="index.php" class="nav-link active" aria-current="page">
        <i class="fas fa-home me-2"></i>
        Início
      </a>
    </li>
    <li>
      <a href="dashboard.php" class="nav-link link-dark">
        <i class="fas fa-tachometer-alt me-2"></i>
        Dashboard
      </a>
    </li>
    <li>
      <a href="orders.php" class="nav-link link-dark">
        <i class="fas fa-list me-2"></i>
        Pedidos
      </a>
    </li>
    <li>
      <a href="products.php" class="nav-link link-dark">
        <i class="fas fa-box me-2"></i>
        Produtos
      </a>
    </li>
    <li>
      <a href="?a=admin_clientes" class="nav-link link-dark">
        <i class="fas fa-users me-2"></i>
        Clientes
      </a>
    </li>
  </ul>
  <hr>
  <div class="dropdown mt-6">
    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
      <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
      <strong><?= $_SESSION['admin'] ?></strong>
    </a>
    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
      <li><a class="dropdown-item" href="settings.php">Configurações</a></li>
      <li><a class="dropdown-item" href="profile.php">Perfil</a></li>
      <li>
        <hr class="dropdown-divider">
      </li>
      <li><a class="dropdown-item" href="?a=logout">Logout</a></li>
    </ul>
  </div>
</div>