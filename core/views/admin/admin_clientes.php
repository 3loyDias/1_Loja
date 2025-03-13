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

// Verifica se existe mensagem de feedback
if(isset($_SESSION['sucesso'])) {
    $sucesso = $_SESSION['sucesso'];
    unset($_SESSION['sucesso']);
}
if(isset($_SESSION['erro'])) {
    $erro = $_SESSION['erro'];
    unset($_SESSION['erro']);
}
?>

<!-- Link para o arquivo CSS externo -->
<link rel="stylesheet" href="assets/css/style_admin.css">

<div class="container-fluid px-4 py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">
                <i class="fas fa-users"></i> Gestão de Clientes
            </h1>
            <p class="mb-0 text-gray-600">Gerencie todos os clientes do sistema</p>
        </div>
        <a href="?a=novo_cliente" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Novo Cliente
        </a>
    </div>

    <!-- Mensagens de Feedback -->
    <?php if(isset($sucesso)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= $sucesso ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(isset($erro)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= $erro ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Card com a Tabela -->
    <div class="card shadow-sm">
        <div class="card-body">
            <?php if(count($clientes_list) == 0): ?>
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>Não existem clientes cadastrados.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="60">#</th>
                                <th>
                                    <i class="fas fa-user me-2"></i>Nome
                                </th>
                                <th>
                                    <i class="fas fa-envelope me-2"></i>Email
                                </th>
                                <th>
                                    <i class="fas fa-map-marker-alt me-2"></i>Morada
                                </th>
                                <th class="text-center">
                                    <i class="fas fa-check-circle me-2"></i>Status
                                </th>
                                <th class="text-center" width="200">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($clientes_list as $index => $cliente): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($cliente->nome_completo) ?></td>
                                    <td><?= htmlspecialchars($cliente->email) ?></td>
                                    <td><?= htmlspecialchars($cliente->morada) ?></td>
                                    <td class="text-center">
                                        <?php if($cliente->ativo == 1): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Ativo
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Inativo
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" 
                                                    class="btn btn-warning btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal"
                                                    data-id="<?= $cliente->id_cliente ?>"
                                                    data-nome="<?= htmlspecialchars($cliente->nome_completo) ?>"
                                                    data-email="<?= htmlspecialchars($cliente->email) ?>"
                                                    data-morada="<?= htmlspecialchars($cliente->morada) ?>"
                                                    data-cidade="<?= htmlspecialchars($cliente->cidade) ?>"
                                                    data-telefone="<?= htmlspecialchars($cliente->telefone) ?>"
                                                    data-ativo="<?= $cliente->ativo ?>"
                                                    title="Editar Cliente">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal"
                                                    data-id="<?= $cliente->id_cliente ?>"
                                                    data-nome="<?= htmlspecialchars($cliente->nome_completo) ?>"
                                                    title="Apagar Cliente">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2"></i>Editar Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="?a=cliente_atualizar" method="post" id="formEditarCliente">
                <div class="modal-body">
                    <input type="hidden" name="id_cliente" id="edit_id_cliente">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nome" class="form-label">
                                <i class="fas fa-user me-2"></i>Nome Completo
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="edit_nome" 
                                   name="text_nome_completo" 
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="edit_email" 
                                   name="text_email" 
                                   required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="edit_morada" class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Morada
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="edit_morada" 
                                   name="text_morada" 
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_cidade" class="form-label">
                                <i class="fas fa-city me-2"></i>Cidade
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="edit_cidade" 
                                   name="text_cidade" 
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_telefone" class="form-label">
                                <i class="fas fa-phone me-2"></i>Telefone
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="edit_telefone" 
                                   name="text_telefone" 
                                   required>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="edit_ativo" 
                                       name="check_ativo">
                                <label class="form-check-label" for="edit_ativo">
                                    Cliente Ativo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" id="save" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Salvar Alterações
                    </button>
                </div>
            </form>


        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o cliente <strong id="clienteNome"></strong>?</p>
                <p class="mb-0 text-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>Esta ação não pode ser desfeita!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <a href="#" id="btnConfirmarExclusao" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Confirmar Exclusão
                </a>
            </div>
        </div>
    </div>
</div>

<script>

// Editar


// Quando clicar id close, será fechado o modal 
document.getElementById('close').addEventListener('click', function() {
    $('#editModal').modal('hide');
});

// Quando clicar id save, será feita requisição ajax para a página cliente_atualizar.php
document.getElementById('save').addEventListener('click', function() {
    // dar prioridade à função e não ao submit do formulário
    event.preventDefault();
    $.ajax({
        url: '?a=cliente_atualizar',
        type: 'POST',
        data: $('#formEditarCliente').serialize(),  
        success: function(response) {
            alert('Cliente atualizado com sucesso!');
        },
        error: function() {
            alert('Erro ao atualizar cliente!');
        }
    }); 

});

document.addEventListener('DOMContentLoaded', function() {
    // Configuração do Modal de Edição
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nome = button.getAttribute('data-nome');
        const email = button.getAttribute('data-email');
        const morada = button.getAttribute('data-morada');
        const cidade = button.getAttribute('data-cidade');
        const telefone = button.getAttribute('data-telefone');
        const ativo = button.getAttribute('data-ativo') === '1';
        
        // Preencher os campos do formulário
        document.getElementById('edit_id_cliente').value = id;
        document.getElementById('edit_nome').value = nome;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_morada').value = morada;
        document.getElementById('edit_cidade').value = cidade;
        document.getElementById('edit_telefone').value = telefone;
        document.getElementById('edit_ativo').checked = ativo;
        
        // Atualiza a action do formulário com o formato correto
        document.getElementById('formEditarCliente').action = `?a=cliente_atualizar&id=${id}`;
    });

    // Validação do formulário antes do envio
    document.getElementById('formEditarCliente').addEventListener('submit', function(event) {
        const campos = [
            'edit_nome',
            'edit_email',
            'edit_morada',
            'edit_cidade',
            'edit_telefone'
        ];
        let temErro = false;
        campos.forEach(campo => {
            const elemento = document.getElementById(campo);
            if (!elemento.value.trim()) {
                elemento.classList.add('is-invalid');
                temErro = true;
            } else {
                elemento.classList.remove('is-invalid');
            }
        });
        if (temErro) {
            event.preventDefault();
            alert('Por favor, preencha todos os campos obrigatórios.');
        }
    });
});

    // Configuração do Modal de Exclusão
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nome = button.getAttribute('data-nome');
        
        document.getElementById('clienteNome').textContent = nome;
        document.getElementById('btnConfirmarExclusao').href = `?a=cliente_delete&id=${id}`;
    });

    // Auto-close para alertas
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

</script>

