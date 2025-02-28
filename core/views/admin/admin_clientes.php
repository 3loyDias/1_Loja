<?php

use core\classes\store;

?>



<div class="modal fade" id="Ivan1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content"> <!-- Corrigido: modal-content envolve todo o conteúdo -->
            <div class="modal-header">
                <h5 class="modal-title main-title text-center" id="exampleModalLabel">
                    <i class="fas fa-exclamation-triangle"></i> Apagar Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mt-5">
                    <div class="col-lg-8 offset-lg-2 col-sm-8 offset-sm-2">
                        <div class="new-user-wraper">
                            <p class="main-title">Confirma Apagar User</p>
                            <div class="mb-3">
                                <label for="text_email" class="form-label">Email</label>
                                <input type="email" name="text_email" value="<?= $cliente->email; ?>" id="text_email" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="text_username" class="form-label">Username</label>
                                <input type="text" name="text_username" value="<?= $cliente->username; ?>" id="text_username" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <div class="container mt-5">
                    <div class="col-lg-8 offset-lg-2 col-sm-8 offset-sm-2">
                        <div class="new-user-wraper">
                            <p class="main-title">Confirma Apagar User</p>
                            <div class="mb-3">
                                <label for="text_email" class="form-label">Email</label>
                                <input type="email" name="text_email" value="<?= $cliente[0]->email ?>" id="text_email" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="text_username" class="form-label">Username</label>
                                <input type="text" name="text_username" value="<?= $cliente->username; ?>" id="text_username" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>



<div>
    <h1>Listagem de Clientes</h1>
</div>
<button class="btn btn-primary">Novo </button>
<?php if (count($clientes) == 0) : ?>
    <?= $_SESSION['erro'] = "Não existem Clientes" ?>
<?php else : ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Morada</th>
                <th scope="col">Ativo</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $index => $cliente) : ?>
                <tr>
                    <th scope="row"><?= $index + 1 ?></th>
                    <td><?= htmlspecialchars($cliente->nome_completo) ?></td>
                    <td><?= htmlspecialchars($cliente->email) ?></td>
                    <td><?= htmlspecialchars($cliente->morada) ?></td>
                    <td>
                        <?= $cliente->ativo == 1
                            ? '<i class="fa-duotone fa-solid fa-check" style="--fa-primary-color: #04ff00; --fa-secondary-color: #026100;"></i>'
                            : '<i class="fa-solid fa-xmark" style="color: #ff0000;"></i>'
                        ?>
                    </td>
                    <td>
                        <a href="?a=Cliente_editar&id=<?= $cliente->id_cliente ?>" class="btn btn-editar btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="?a=cliente_delete_hard_confirm&id=<?= $cliente->id_cliente ?>" class="btn btn-apagar btn-danger">
                            <i class="fas fa-trash-alt"></i> Apagar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>


<script>
// Experimenta o seguinte
Botão apagagar evento onclick chamada de função apagagar

function apagarCliente(id) {
    // Aqui podes fazer um fetch para o servidor
    // e apagar o cliente
    // fetch('url_do_servidor', {
    //     method: 'DELETE',
    //     body: JSON.stringify({ id: id })
    // })
    // .then(response => response.json())
    // .then(data => {
    //     console.log(data);
    // })
    // .catch(error => {
    //     console.error('Erro:', error);
    // });
    console.log('Apagar cliente com id:', id);

    /7 Temos o id através de Jquery/Ajax chamar rota para selecionar dados do id
    Retornar dados do Id e coloca na Modal
}   

</script>