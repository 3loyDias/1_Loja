<?php

namespace core\models;

use core\classes\Database;


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
};
