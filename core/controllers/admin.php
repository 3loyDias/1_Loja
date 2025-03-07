<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\AdminModel;
use core\models\Clientes;

class Admin
{
    // Utilizador: admin@admin.com
    // Senha: 123456
    public function index()
    {
        if (!Store::adminLogado()) {
            Store::redirect('admin_login', true);
            return;
        }

        // Carregar o layout do Backoffice com a página de clientes
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/inicio', // A view que será carregada
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ]);
    }

    // ******************* Método corrigido: listar_clientes() *******************
    public function listar_clientes()
    {
        // Criar instância do modelo Clientes
        $clientesModel = new Clientes();

        // Obter a lista de clientes do banco de dados
        $clientes = $clientesModel->lista_clientes();

        // Enviar os dados para a View
        $data = [
            'clientes' => $clientes
        ];

        // Carregar o layout do Backoffice
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/listar_clientes', // Arquivo de view separado
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ], $data);
    }

    // ******************* Método admin_login() ****************************
    public function admin_login()
    {
        // Verifica se já existe sessão admin aberta
        if (Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // Apresenta backoffice com o quadro de login
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/login_frm',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ]);
    }

    public function admin_logout()
    {
        // Destroi a sessão do administrador e redireciona para a página de login
        session_start();
        session_destroy();
        \core\classes\Store::redirect('admin_logout');
    }
    // ******************* Método admin_login_submit() ****************************
    public function admin_login_submit()
    {
        if (Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect('admin_login', true);
            return;
        }

        if (
            !isset($_POST['text_admin']) ||
            !isset($_POST['text_password']) ||
            !filter_var(trim($_POST['text_admin']), FILTER_VALIDATE_EMAIL)
        ) {
            $_SESSION['login_erro'] = 'Email ou Senha Inválidos!';
            Store::redirect('admin_login', true);
            return;
        }

        $admin = trim(strtolower($_POST['text_admin']));
        $password = trim($_POST['text_password']);

        $admin_model = new AdminModel();
        $resultado = $admin_model->validar_login($admin, $password);

        if (is_bool($resultado)) {
            $_SESSION['login_erro'] = 'Senha ou Email Inválidos!';
            Store::redirect('admin_login', true);
            return;
        } else {
            $_SESSION['admin'] = $resultado->id_admin;
            $_SESSION['admin_utilizador'] = $resultado->utilizador;

            // Define uma variável de sessão para exibir o SweetAlert de sucesso
            $_SESSION['login_sucesso'] = true;

            Store::redirect('inicio', true);
        }
    }

    // ******************* Método cliente_apagar_hard() ****************************
    public function cliente_apagar_Hard()
    {

        //
        //primeiro fazer validações
        if (!isset($_GET['id'])) {
            Store::redirect('listar_clientes', true);
            //Sai
        }

        //agora pegamos no id
        //e executamos CRUD, a parte do Delete

        $id = $_GET['id'];

        //Instanciar o nosso model
        $cliente = new Clientes();
        $results = $cliente->cliente_apagar_hard($id);
        Store::redirect('listar_clientes', true);
        return;
    }

    // ******************* Método cliente_apagar_hard_confurn() ****************************
    public function cliente_apagar_Hard_confirm()
    {
        //recebe o id do cliente
        //Instancia o modelclientes
        //no model cria um metodo para trazer todos os dados do cliente   
        //Apresentar a view de confirmacao com os dados do cliente

    }
}
