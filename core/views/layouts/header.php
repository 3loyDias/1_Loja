<?php

use core\classes\store;
?>

<nav class="navbar navbar-expand-lg custom-header shadow">
    <div class="container">
        <div class="navbar-brand">
            <a href="?a=inicio" class="logo-link">
                <img src="assets/images/logo-w.png" alt="Logo da Empresa" class="logo-img">
            </a>
        </div>
        
        <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a href="?a=inicio" class="nav-link">
                        <i class="fa-solid fa-house"></i> Início
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?a=loja" class="nav-link">
                        <i class="fa-solid fa-shop"></i> Loja
                    </a>
                </li>
                
                <?php if (store::clienteLogado()) : ?>
                    <li class="nav-item">
                        <a href="?a=minha_conta" class="nav-link">
                            <i class="fas fa-user"></i> <?= $_SESSION['utilizador'] ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?a=logout" class="nav-link">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a href="?a=login" class="nav-link">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
                
                <li class="nav-item">
                    <a href="?a=carrinho" class="nav-link cart-link">
                        <i class="fa-solid fa-cart-shopping"></i> 
                        <span class="cart-text">Carrinho</span>
                        <span class="badge bg-warning cart-badge"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
