<?php

use core\classes\store;
?>

<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-6 p-3">
            <a href="?a=inicio">
                <?= APP_NAME ?>
            </a>
        </div>
        <div class="col-6 text-right p-3">
            <a href="?a=inicio" class="nav-item">Inicio</a>
            <a href="?a=loja" class="nav-item">Loja</a>
            <!-- Verifica se existe cliente na sessão -->
            <?php if (store::clienteLogado()) : ?>
            <?php else : ?>
                <a href="?a=minha_conta" class="nav-item">A minha Conta</a>
                <a href="?a=logout" class="nav-item">Logout</a> 
            <?php endif; ?>
            <a href="?a=login" class="nav-item">Login</a>
            <a href="?a=novo_cliente"class="nav-item">Registrar</a>
            <a href="?a=carrinho"><i class="fa-solid fa-cart-shopping"></i></a>
            <span class="badge bg-warning"></span>
        </div>
    </div>
</div>