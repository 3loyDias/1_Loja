<?php

namespace core\controllers;

use Exception;
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


    //**********************    SUBMIT */
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
            // store::printData($_SESSION);
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

    public function cliente_delete()
    {
        // Verifica se o ID foi fornecido
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            $_SESSION['erro'] = 'ID do cliente não fornecido';
            Store::redirect('admin_clientes', true);
            return;
        }

        $id_cliente = $_GET['id'];
        
        // Instanciar o modelo de clientes
        $clientes = new Clientes();
        
        // Tenta apagar o cliente
        if ($clientes->apagarCliente($id_cliente)) {
            $_SESSION['sucesso'] = 'Cliente excluído com sucesso!';
        } else {
            $_SESSION['erro'] = 'Não foi possível excluir o cliente';
        }
        
        // Redireciona de volta para a lista de clientes
        Store::redirect('admin_clientes', true);
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

    public function cliente_editar()
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
            'admin/cliente_atualizar',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ], $data);
    }

    public function cliente_atualizar()
    {

        store::printData($_POST);
        // Verifica se o método é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['erro'] = 'Acesso inválido ao recurso';
            Store::redirect('admin_clientes', true);
            return;
        }

        // Verifica se o ID do cliente foi fornecido
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            $_SESSION['erro'] = 'ID do cliente não fornecido';
            Store::redirect('admin_clientes', true);
            return;
        }

        $id_cliente = $_GET['id'];
        $nome_completo = trim($_POST['text_nome_completo'] ?? '');
        $email = trim($_POST['text_email'] ?? '');
        $morada = trim($_POST['text_morada'] ?? '');
        $cidade = trim($_POST['text_cidade'] ?? '');
        $telefone = trim($_POST['text_telefone'] ?? '');
        $ativo = isset($_POST['check_ativo']) ? 1 : 0;

        // Validação dos campos
        if (empty($nome_completo) || empty($email) || empty($morada) || empty($cidade) || empty($telefone)) {
            $_SESSION['erro'] = 'Todos os campos são obrigatórios';
            Store::redirect('admin_clientes', true);
            return;
        }

        // Validação do formato do email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro'] = 'O email fornecido é inválido';
            Store::redirect('admin_clientes', true);
            return;
        }

        // Instanciar o modelo de clientes
        $clientes = new Clientes();

        // Verificar se o email já está em uso por outro cliente
        if ($clientes->emailExiste($email, $id_cliente)) {
            $_SESSION['erro'] = 'O email fornecido já está em uso por outro cliente';
            Store::redirect('admin_clientes', true);
            return;
        }

        try {
            // Atualizar os dados do cliente no banco de dados
            $bd = new Database();
            $parametros = [
                ':id_cliente'     => $id_cliente,
                ':nome_completo'  => $nome_completo,
                ':email'          => $email,
                ':morada'         => $morada,
                ':cidade'         => $cidade,
                ':telefone'       => $telefone,
                ':ativo'          => $ativo
            ];

            $sql = "UPDATE clientes 
                    SET nome_completo = :nome_completo,
                        email = :email,
                        morada = :morada,
                        cidade = :cidade,
                        telefone = :telefone,
                        ativo = :ativo,
                        updated_at = NOW()
                    WHERE id_cliente = :id_cliente";

            if ($bd->update($sql, $parametros)) {
                $_SESSION['sucesso'] = 'Cliente atualizado com sucesso!';
            } else {
                $_SESSION['erro'] = 'Não foi possível atualizar o cliente';
            }
        } catch (Exception $e) {
            $_SESSION['erro'] = 'Erro ao atualizar o cliente: ' . $e->getMessage();
        }

        // Redireciona de volta para a página de clientes
        Store::redirect('admin_clientes', true);
    }

    public function novo_cliente()
    {
        // Verifica se existe sessão admin
        if (!Store::adminLogado()) {
            Store::redirect('admin_login', true);
            return;
        }

        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/novo_cliente',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ]);
    }

    public function criar_cliente()
    {
        // Verifica se existe sessão admin
        if (!Store::adminLogado()) {
            Store::redirect('admin_login', true);
            return;
        }

        // Verifica se houve submissão de formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect('admin_clientes', true);
            return;
        }

        // Verifica se senha e confirmação são iguais
        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
            $_SESSION['erro'] = 'As senhas não coincidem';
            Store::redirect('novo_cliente', true);
            return;
        }

        // Verifica preenchimento dos campos obrigatórios
        if (
            empty($_POST['text_nome_completo']) ||
            empty($_POST['text_email']) ||
            empty($_POST['text_senha_1']) ||
            empty($_POST['text_morada']) ||
            empty($_POST['text_cidade']) ||
            empty($_POST['text_telefone'])
        ) {
            $_SESSION['erro'] = 'Preencha todos os campos obrigatórios';
            Store::redirect('novo_cliente', true);
            return;
        }

        // Verifica se email é válido
        if (!filter_var($_POST['text_email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro'] = 'Email inválido';
            Store::redirect('novo_cliente', true);
            return;
        }

        $clientes = new Clientes();

        // Verifica se email já está registrado
        if ($clientes->verificar_email_registado($_POST['text_email'])) {
            $_SESSION['erro'] = 'O email já está registrado';
            Store::redirect('novo_cliente', true);
            return;
        }

        // Registra o novo cliente
        try {
            $purl = $clientes->registrar_cliente();
            $_SESSION['sucesso'] = 'Cliente cadastrado com sucesso!';
            Store::redirect('admin_clientes', true);
        } catch (Exception $e) {
            $_SESSION['erro'] = 'Erro ao cadastrar cliente: ' . $e->getMessage();
            Store::redirect('novo_cliente', true);
        }
    }
}


