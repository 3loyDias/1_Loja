<?php
use core\classes\store;

$rotas = [
    'inicio' => 'admin@index',
    
    'admin_login' => 'admin@admin_login',
    'admin_login_submit' => 'admin@admin_login_submit',
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