<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;


class Clientes
{
    public function verificar_email_registado($email)
    {
        // Verfifica na BD se o email já existe
        // e criado o namespace da database
        // parametro por exemplo :email podia ser e: PDO
        // este metodo evita SQL injection

        $bd = new Database();
        $parametros = [
            ':email' => strtolower(trim($_POST['text_email']))
        ];
        $resultados = $bd->select(
            'SELECT email FROM clientes WHERE email = :email',
            $parametros
        );

        if (count($resultados) != 0) {
            // O email ja existe
            return true;
        } else {
            // O email não existe
            return false;
        }
    }

    //============================ REGISTRAR CLIENTE ============================
    //CLIENTE PRONTO PARA SER INSERIDO NA BD
    public function registrar_cliente()
    {
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
        return $purl;
    }

    //============================ CRIAR CLIENTE  ============================
};
