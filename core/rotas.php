<?php

$rotas = [
    'inicio' => 'main@index',
    'loja' => 'main@loja', 

    # Cliente
    'novo_cliente' => 'main@novo_cliente',
    'criar_cliente' => 'main@criar_cliente',
    'confirmar_email' => 'main@confirmar_email',
    'confirmar_email_sucesso' => 'main@confirmar_email_sucesso',

    # Login
    'login' => 'main@login',
    'login_submit' => 'main@login_submit',
    'logout' => 'main@logout',

    'carrinho' => 'main@carrinho',
];
$acao = 'inicio';

if (isset($_GET['a'])) {
    if (!key_exists($_GET['a'], $rotas)) {
        $acao = 'inicio';
    } else {
        $acao = $_GET['a'];
    } 
}

$partes = explode('@', $rotas[$acao]);

$controller = 'core\\controllers\\' . ucfirst($partes[0]);

$metodo = $partes[1];

$ctr = new $controller();

$ctr -> $metodo();

?>