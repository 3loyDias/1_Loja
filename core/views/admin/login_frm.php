<div class="container">
<div class="row my-5">
    <div class="col-sm-4 offset-sm-4">
        <div>
            <h3 class="text-center">LOGIN DE ADMIN</h3>
            <form action="?a=admin_login_submit" method="post">
                <div class="my-3">
                    <label>Administrador:</label>
                    <input type="email" name="text_admin" id=""
                        placeholder="Admin" required class="form-control">
                </div>
                <div class="my-3">
                    <label>Password::</label>
                    <input type="password" name="text_password" id=""
                        placeholder="Password" required class="form-control">
                </div>
                <div class="text-center my-3">
                    <h3 class="text-center"></h3> 
                    <input type="submit" value="Login" class="btn btn-primary">
                </div>
            </form>
            <!-- SweetAlert error -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '<?= $_SESSION['erro'] ?>',
                        });
                    </script>
        </div>
    </div>
</div>
</div>