<?php

use core\classes\Store;
use core\models\Clientes;

if (!isset($_GET['id']) || empty($_GET['id'])) {
    Store::redirect('admin_cliente');
    exit;
}

$id_cliente = $_GET['id'];

$clientes = new Clientes();
$cliente = $clientes->buscarClientePorId($id_cliente);

// Verifica se o cliente existe antes de tentar deletar
if ($cliente) {
    $clientes->apagarCliente($id_cliente);
    Store::redirect('admin_cliente');
} else {
    // Se o cliente não for encontrado, redireciona de volta para a lista
    Store::redirect('admin_cliente');
}

?>
