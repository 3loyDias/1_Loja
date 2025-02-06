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
            echo "Email Confirmado";
        } else {
            echo "Email Não Confirmado";
        }
    }
        
}
