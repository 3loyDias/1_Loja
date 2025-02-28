<?php

use core\classes\store;
?>

<div class="container navegacao">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-auto logo">
            <a href="?a=inicio">
                <img src="assets/images/logo-w.png" alt="Logo da Empresa" class="logo-img">
            </a>
        </div>
        <div class="col-auto menu">
            <a href="?a=inicio" class="button"><i class="fa-solid fa-house"></i> Inicio</a>
            <a href="?a=loja" class="button"><i class="fa-solid fa-shop"></i> Loja</a>
            
            <?php if (store::clienteLogado()) : ?>
                <a href="?a=logout" class="button">Logout</a>
                <a href="?a=minha_conta" class="button">
                    <i class="fas fa-user mr-6"></i> <?= $_SESSION['utilizador'] ?></a>
            <?php else : ?>
                <a href="?a=login" class="button"><i class="fas fa-sign-out-alt"></i> Login</a>
            <?php endif; ?>
            
            <a href="?a=carrinho" class="button"><i class="fa-solid fa-cart-shopping"></i> Carrinho</a>
            <span class="badge bg-warning"></span>
        </div>
    </div>
</div>
