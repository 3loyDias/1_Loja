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

// Se o cliente não existir, redireciona de volta para a página de administração
if (!$cliente) {
    Store::redirect('admin_cliente');
    exit;
}

// Se quiser apagar o cliente sem exibir o modal, descomente a linha abaixo
// Store::redirect("processa_delete_cliente.php?id=" . $id_cliente);

?>

<div class="modal fade show d-block" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title main-title text-center" id="exampleModalLabel">
                    <i class="fas fa-exclamation-triangle"></i> Apagar Cliente
                </h5>
                <button type="button" class="btn-close" onclick="window.location.href='admin_cliente.php'" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mt-5">
                    <div class="col-lg-8 offset-lg-2 col-sm-8 offset-sm-2">
                        <div class="new-user-wraper">
                            <p class="main-title text-center">Confirma Apagar o Cliente?</p>
                            <div class="mb-3">
                                <label for="text_email" class="form-label">Email</label>
                                <input type="email" name="text_email" value="<?= htmlspecialchars($cliente->email); ?>" id="text_email" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="text_username" class="form-label">Username</label>
                                <input type="text" name="text_username" value="<?= htmlspecialchars($cliente->nome_completo); ?>" id="text_username" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="processa_delete_cliente.php?id=<?= $cliente->id_cliente ?>" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Apagar Definitivamente
                </a>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='admin_cliente.php'">Cancelar</button>
            </div>
        </div>
    </div>
</div>
