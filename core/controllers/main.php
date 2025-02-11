<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\store;
use core\models\clientes;
use core\classes\enviaremail;

class Main
{
    public function index()
    {
        store::Layout([
            'layouts/html_header',
            'layouts/header',
            'inicio',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }

    //============================ LOJA ============================

    public function loja()
    {
        // Apresenta a pagina da loja 
        store::Layout([
            'layouts/html_header',
            'layouts/header',
            'loja',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }
    //============================ NOVO CLIENTE ============================
    public function novo_cliente()
    {
        if (store::clienteLogado()) {
            $this->index();
            return;
        }

        // Apresenta a pagina de registro de novo cliente
        store::Layout([
            'layouts/html_header',
            'layouts/header',
            'novo_cliente',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }

    //============================ CRIAR CLIENTE ============================
    public function criar_cliente()
    {
        //*********************************************************************

        // Vamos agora verificar se o utilizador já existe
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }
        // Alguém pode querer entrar de forma forçada
        // colocando endereço no browser, não seguindo a sequência
        // do programa
        // Verifica se houve submissão de um formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        //*********************************************************************

        // Criação de um novo Cliente
        // 1- Verificar se a password 1 coincide com password 2
        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
            // AS passwords são diferentes
            $_SESSION['erro'] = 'Senhas são Diferentes!!!!';
            $this->novo_cliente();
            return;
        }
        //*********************************************************************

        // verifica se na base de dados existe cliente com o mesmo email
        $cliente = new Clientes();
        if ($cliente->verificar_email_registado($_POST['text_email'])) {
            $_SESSION['erro'] = 'Já existe um Cliente com Esse EMAIL';
            $this->novo_cliente();
            return;
        }
        //*********************************************************************

        //*********************************************************************

        // criar o link purl para enviar por email
        // link será algo tipo "http://localhost/01-LOJA/public/?a=confirmar_email@$purl";"
        // INSERIDO NOVO CLIENTE NA BD E DEVOLVER O PURL 
        $email_cliente = strtolower(trim($_POST['text_email']));
        $purl = $cliente->registrar_cliente();
        //envio do email para o cliente
        $email = new EnviarEmail();

        $resultado = $email->enviar_email_confirmacao_novo_cliente($email_cliente, $purl);
        if ($resultado) {
            store::Layout([
                'layouts/html_header',
                'layouts/header',
                'criar_cliente_sucesso',
                'layouts/footer',
                'layouts/html_footer',
            ]);
            return;
        } else {
            echo "Aconteceu um Erro";
        }
    }

    //============================ CONFIRMAR EMAIL ============================

    public function confirmar_email()
    {
        //*********************************************************************
        // Verifica se o utilizador já está logado
        if (store::clienteLogado()) {
            $this->index();
            return;
        }
        //Se existe na DB string com o purl do utilizador
        if (!isset($_GET['purl'])) {
            $this->index();
            return;
        }

        //Verifica se o purl é valido 12 caracteres
        $purl = $_GET['purl'];
        if (strlen($_GET['purl']) != 12) {
            $this->index();
            return;
        }

        $cliente = new Clientes();
        $resultado = $cliente->validar_email($purl);
        if ($resultado) {
            store::Layout([
                'layouts/html_header',
                'layouts/header',
                'confirmar_email_sucesso',
                'layouts/footer',
                'layouts/html_footer',
            ]);
            return;
        } else {
            store::redirect();
        }
    }

    //============================ LOGIN ============================
    public function login()
    {
        //*********************************************************************
        // Verifica se o utilizador já está logado
        if (store::clienteLogado()) {
            $this->index();
            return;
        }
        //*********************************************************************
        // Apresenta a pagina de login
        store::Layout([
            'layouts/html_header',
            'layouts/header',
            'login_frm',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }

    //============================ LOGIN SUBMIT ============================
    public function login_submit()
    {
        /* Verificar se existe um utilizador logado */
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        // veriifca se foi efetuado um post do Formulário de Login
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            if (Store::clienteLogado()) {
                Store::redirect();
                return;
            }
        }
        // Validar campos
        if (
            !isset($_POST['text_utilizador']) ||
            !isset($_POST['text_password']) || !filter_var(
                trim($_POST['text_utilizador']),
                FILTER_VALIDATE_EMAIL
            )
        ) {
            // erro de preenchimento do form
            $_SESSION['erro'] = 'Login Inválido';
            store::redirect('login');
            return;
        }
        // Prepara os dados para o model
        $utilizador = trim(strtolower($_POST['text_utilizador']));
        $password = trim($_POST['text_password']);
        // Ir à bd (ver login)
        // carrega o model e verifica se o login é correto
        $cliente = new Clientes();
        // chama model Clientes, validar_login
        // Para verificar user e pass
        $resultado = $cliente->validar_login($utilizador, $password);
        // analisa o resultado
        if (is_bool($resultado)) {
            //Login inválido
            $_SESSION['erro'] = 'Login Inválido';
            Store::redirect('login');
            return;
        } else {
            // Login Válido, criar sessão cliente
            // Coloca os dados na sessão / Criar sessão do cliente
            // Optamos por estes três códigos na sessão
            $_SESSION['cliente'] = $resultado->id_cliente;
            $_SESSION['utilizador'] = $resultado->email;
            $_SESSION['nome_cliente'] = $resultado->nome_completo;
            // redirecionar para o inicio
            Store::redirect();
        }
    }

    //============================ LOGOUT ============================
    public function logout()
    {
        // Elimina a sessão
        unset($_SESSION['cliente']);
        unset($_SESSION['utilizador']);
        unset($_SESSION['nome_cliente']);
        // redirecionar para o inicio
        Store::redirect();
    }
}
