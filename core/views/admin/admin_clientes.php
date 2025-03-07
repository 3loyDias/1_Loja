<?php
// Iniciar a sessão e importar as classes necessárias
use core\classes\Store;
use core\models\Clientes;

// Verifica se a solicitação de exclusão foi feita
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_cliente = $_GET['id'];
    $clientes = new Clientes();

    // Verifica se o cliente existe e se está em condições de ser apagado
    if ($clientes->apagarCliente($id_cliente)) {
        $_SESSION['msg'] = 'Cliente apagado com sucesso!';
    } else {
        $_SESSION['msg'] = 'Erro ao apagar cliente!';
    }

    // Redireciona de volta para a lista de clientes
    header('Location: admin_clientes.php');
    exit;
}

// Buscar todos os clientes
$clientes = new Clientes();
$clientes_list = $clientes->lista_clientes(); // Método que retorna todos os clientes
?>

<!-- Exibição da lista de clientes -->
<div>
    <h1>Listagem de Clientes</h1>
</div>
<button class="btn btn-primary">Novo </button>
<?php if (count($clientes_list) == 0) : ?>
    <?= $_SESSION['erro'] = "Não existem Clientes" ?>
<?php else : ?>
    <table class="table">
        <thead>
            <tr>
                <th class="text-center" scope="col">#</th>
                <th class="text-center" scope="col">Nome</th>
                <th class="text-center" scope="col">Email</th>
                <th class="text-center" scope="col">Morada</th>
                <th class="text-center" scope="col">Ativo</th>
                <th class="text-center" scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes_list as $index => $cliente) : ?>
                <tr>
                    <th class="text-center" scope="row"><?= $index + 1 ?></th>
                    <td><?= htmlspecialchars($cliente->nome_completo) ?></td>
                    <td><?= htmlspecialchars($cliente->email) ?></td>
                    <td><?= htmlspecialchars($cliente->morada) ?></td>
                    <td>
                        <?= $cliente->ativo == 1
                            ? '<i class="fa-duotone fa-solid fa-check" style="--fa-primary-color: #04ff00; --fa-secondary-color: #026100;"></i>'
                            : '<i class="fa-solid fa-xmark" style="color: #ff0000;"></i>' 
                        ?>
                    </td>
                    <td class="text-center">
                        <a href="?a=Cliente_editar&id=<?= $cliente->id_cliente ?>" class="btn btn-editar btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button type="button" class="btn btn-apagar btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="<?= $cliente->id_cliente ?>">
                            <i class="fas fa-trash-alt"></i> Apagar
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title main-title text-center" id="exampleModalLabel">
                    <i class="fas fa-exclamation-triangle"></i> Apagar Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mt-5">
                    <div class="col-lg-8 offset-l g-2 col-sm-8 offset-sm-2">
                        <div class="new-user-wraper">
                            <p class="main-title">Confirma Apagar o Cliente?</p>
                            <div class="mb-3">
                                <label for="text_email" class="form-label">Email</label>
                                <input type="email" name="text_email" id="text_email" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="text_username" class="form-label">Username</label>
                                <input type="text" name="text_username" id="text_username" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" id="confirmDeleteLink" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Apagar Definitivamente
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Preenche os campos do modal com as informações do cliente
    const modal = document.getElementById('confirmDeleteModal');
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Botão que abriu o modal
        const clienteId = button.getAttribute('data-id'); // ID do cliente a ser apagado
        const link = document.getElementById('confirmDeleteLink');
        link.href = `admin_clientes.php?action=delete&id=${clienteId}`; // Atualiza o link de exclusão
    });
</script>

