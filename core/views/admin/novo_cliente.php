<?php
// Verifica se existem mensagens de erro ou sucesso
if(isset($_SESSION['erro'])) {
    $erro = $_SESSION['erro'];
    unset($_SESSION['erro']);
}
if(isset($_SESSION['sucesso'])) {
    $sucesso = $_SESSION['sucesso'];
    unset($_SESSION['sucesso']);
}
?>

<div class="container-fluid px-4 py-4">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">
                <i class="fas fa-user-plus"></i> Novo Cliente
            </h1>
            <p class="mb-0 text-gray-600">Preencha os dados para cadastrar um novo cliente</p>
        </div>
        <a href="?a=admin_clientes" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <!-- Mensagens de Feedback -->
    <?php if(isset($erro)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= $erro ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(isset($sucesso)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= $sucesso ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Formulário -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="?a=criar_cliente" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="text_nome_completo" class="form-label">
                            <i class="fas fa-user me-2"></i>Nome Completo
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="text_nome_completo" 
                               name="text_nome_completo" 
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="text_email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <input type="email" 
                               class="form-control" 
                               id="text_email" 
                               name="text_email" 
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="text_senha_1" class="form-label">
                            <i class="fas fa-lock me-2"></i>Senha
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="text_senha_1" 
                               name="text_senha_1" 
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="text_senha_2" class="form-label">
                            <i class="fas fa-lock me-2"></i>Confirmar Senha
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="text_senha_2" 
                               name="text_senha_2" 
                               required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="text_morada" class="form-label">
                            <i class="fas fa-map-marker-alt me-2"></i>Morada
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="text_morada" 
                               name="text_morada" 
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="text_cidade" class="form-label">
                            <i class="fas fa-city me-2"></i>Cidade
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="text_cidade" 
                               name="text_cidade" 
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="text_telefone" class="form-label">
                            <i class="fas fa-phone me-2"></i>Telefone
                        </label>
                        <input type="text" 
                               class="form-control" 
                               id="text_telefone" 
                               name="text_telefone" 
                               required>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="check_ativo" 
                                   name="check_ativo">
                            <label class="form-check-label" for="check_ativo">
                                Cliente Ativo
                            </label>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="?a=admin_clientes" class="btn btn-secondary me-2">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Cadastrar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Estilo para o formulário */
.form-control:focus,
.form-check-input:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-label {
    font-weight: 500;
    color: #495057;
}

/* Estilo para o card */
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-body {
    padding: 2rem;
}

/* Responsividade */
@media (max-width: 768px) {
    .card-body {
        padding: 1.25rem;
    }
}
</style>

<script>
// Auto-close para alertas
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Validação de senhas iguais
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        const senha1 = document.getElementById('text_senha_1').value;
        const senha2 = document.getElementById('text_senha_2').value;

        if (senha1 !== senha2) {
            event.preventDefault();
            alert('As senhas não coincidem!');
        }
    });
});
</script> 