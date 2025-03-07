<?php

namespace core\models;

use core\classes\Database;

class AdminModel
{
    public function validar_login($utilizador_admin, $password)
    {
        $parametros = [
            ':utilizador_admin' => $utilizador_admin
        ];
        $bd = new Database();
        $resultados = $bd->select("
            SELECT * FROM admins
            WHERE utilizador = :utilizador_admin
            AND deleted_at IS NULL", $parametros);

        if (count($resultados) != 1) {
            return false;
        } else {
            $utilizador_admin = $resultados[0];
            if (!password_verify($password, $utilizador_admin->senha)) {
                return false;
            } else {
                return $utilizador_admin;
            }
        }
    }
}
