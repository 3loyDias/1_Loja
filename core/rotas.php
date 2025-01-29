<?php

$rotas = [
    'inicio' => 'main@index',
    'loja' => 'main@loja', 
    'carrinho' => 'loja@carrinho',

    //Clientes
    'cli_listar' => 'main@Cli_listar',  


    //Cabelo


    //Marcações



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