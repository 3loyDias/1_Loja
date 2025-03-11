<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\AdminModel;
use core\models\Clientes;

class admin
{

    public function index()
    {

        // VERIFICA SE EXISTE SESSÃO ADMIN ABERTA
        if (!Store::adminLogado()) {
            Store::redirect('admin_login', true);
            return;
        }
        //apresenta backoffice
        Store::Layout_Admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/home',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ]);
    }
    //***************************************************************** 
    public function lista_clientes()
    {
        // Lista de lista_clientes
    }
    //***************************************************************** 
    public function admin_login()
    {
        // VERIFICA SE EXISTE SESSÃO ADMIN ABERTA
        if (Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        //apresenta backoffice
        // QUADRO DE LOGIN
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/login_frm',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ]);
    }

    public function admin_login_submit()
    {
        // veriifca se foi efetuado um post do Formulário de Login Admin
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            if (Store::adminLogado()) {
                Store::redirect('inicio', true);
                return;
            }
        }


        // Validar campos vieram devidamente preenchidos
        if (
            !isset($_POST['text_admin']) ||
            !isset($_POST['text_password']) ||
            !filter_var(trim($_POST['text_admin']), FILTER_VALIDATE_EMAIL)
        ) {
            // erro de preenchimento do form
            $_SESSION['erro'] = 'Login Inválido';
            store::redirect('admin_login', true);
            return;
        }

        // Prepara os dados para o model
        $admin = trim(strtolower($_POST['text_admin']));
        $password = trim($_POST['text_password']);
        // Ir à bd (ver login)
        // carrega o model e verifica se o login é correto
        $admin_model = new AdminModel();
        // Para verificar user e pass

        $resultado = $admin_model->validar_login($admin, $password);
        // analisa o resultado
        if (is_bool($resultado)) {
            //Login inválido
            $_SESSION['erro'] = 'Login Inválido';
            Store::redirect('admin_login', true);
            return;
        } else {
            // Login Válido, criar sessão admin
            // Coloca os dados na sessão / Criar sessão do administrador
            $_SESSION['admin'] = $resultado->id_admin;
            $_SESSION['admin_utilizador'] = $resultado->utilizador;
            // redirecionar para a páginal inicial Backoffice
            Store::redirect('inicio', true);
        }
    }

    public function admin_logout()
    {
        // Eliminar a sessão
        unset($_SESSION['admin']);
        unset($_SESSION['admin_utilizador']);
        // redirecionar para a páginal inicial Backoffice
        Store::redirect('inicio', true);
    }

    public function admin_clientes()
    {

        $clientes = new Clientes();
        $results = $clientes->lista_clientes();

        $data = [
            'clientes' => $results
        ];

        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/admin_clientes',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ], $data);
    }

    public function cliente_delete_hard()
    {
        $id = $_GET['id'];
        $clientes = new Clientes();
        $results = $clientes->cliente_pesquisar_id($id);
    }

    public function cliente_delete_hard_confirm()
    {
        $id = $_GET['id'];
        $clientes = new Clientes();
        $results = $clientes->cliente_pesquisar_id($id);
        $data = [
            'cliente' => $results
        ];

        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/cliente_delete_hard_confirm',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ], $data);
        
        Store::redirect('admin_clientes', true);
    }

    public function processa_delete_cliente()
    {
        $id = $_GET['id'];
        $clientes = new Clientes();
        $clientes->apagarCliente($id);
        store::Layout_Admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/cliente_delete_hard_confirm',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ]);
        Store::redirect('admin_clientes', true);

        
    }
}

