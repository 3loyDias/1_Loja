<?php

use core\classes\store;
?>

<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-5 text-right p-3">
            <a href="?a=inicio">
                <?= APP_NAME ?>
            </a>
        </div>
        <div class="col-6 text-right p-3">
            <a href="?a=inicio" class="nav-item">Inicio</a>
            <a href="?a=loja" class="nav-item">Loja</a>
            <!-- Verifica se existe cliente na sessão -->
            <?php if (store::clienteLogado()) : ?>
                <a href="?a=logout" class="nav-item">Logout</a>
                <a href="?a=minha_conta" class="nav-item">
                    <i class="fas fa-user mr-6"></i> <?= $_SESSION['utilizador'] ?></a>
            <?php else : ?>
                <a href="?a=login" class="nav-item"><i class="fas fa-sign-out-alt"></i></a>
                <a href="?a=novo_cliente" class="nav-item">Registrar</a>
            <?php endif; ?>
            <a href="?a=carrinho"><i class="fa-solid fa-cart-shopping"></i></a>
            <span class="badge bg-warning"></span>
        </div>
    </div>
</div>