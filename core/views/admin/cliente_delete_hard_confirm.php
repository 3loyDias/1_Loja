<?php

use core\classes\Store;


?>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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