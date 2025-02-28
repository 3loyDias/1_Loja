<?php
use core\classes\store;

$rotas = [
    // Admin 
    'inicio' => 'admin@index',
    'admin_clientes' => 'admin@admin_clientes',
    
    // Manipulção com Clientes
    'cliente_delete_hard' => 'admin@cliente_delete_hard',
    'cliente_delete_hard_confirm' => 'admin@cliente_delete_hard_confirm',
    
    // Manipulção com contas do admin
    'admin_login' => 'admin@admin_login',
    'admin_login_submit' => 'admin@admin_login_submit',
    'admin_logout' => 'admin@admin_logout',
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