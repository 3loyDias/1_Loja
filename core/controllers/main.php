<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\store;
use core\models\Clientes;

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
        // Criação de um novo Cliente
        // 1- Verificar se a password 1 coincide com password 2
        if ($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
            // AS passwords são diferentes
            $_SESSION['erro'] = 'Senhas são Diferentes!!!!';
            $this->novo_cliente();
            return;
        }

        // 2- Verificar se o email já está registado
        $clientes = new Clientes();
        if ($clientes->verificar_email_registado($_POST['text_email'])) {
            // O email já está registado
            $_SESSION['erro'] = 'Email já está registado';
            $this->novo_cliente();
            return;
        }

        $bd = new Database();

        $purl = store::criarHash();

        // Inserir o novo cliente na BD
        $parametros = [
            ':email' => strtolower(trim($_POST['text_email'])),
            ':senha' => password_hash($_POST['text_senha_1'], PASSWORD_DEFAULT),
            ':nome_completo' => trim($_POST['text_nome_completo']),
            ':morada' => trim($_POST['text_morada']),
            ':cidade' => trim($_POST['text_cidade']),
            ':telefone' => trim($_POST['text_telefone']),
            ':purl' => $purl,
            ':ativo' => 0,
        ];
        $bd->insert(
            "INSERT INTO clientes VALUES (0, :email, :senha, :nome_completo, :morada, :cidade, :telefone, :purl, :ativo, NOW(), NOW(), NULL)", $parametros);
            
        Die('Cliente Criado com Sucesso');
    }


}
