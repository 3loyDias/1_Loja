<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class AdminModel
{
    //========================================================
    //*******************************************************************
    // ADMIN - VALIDAR LOGIN
    public function validar_login($utilizador_admin, $password)
    {
        // Vai verificar se o login é válido
        $parametros = [
            ':utilizador_admin' => $utilizador_admin
        ];

        $bd = new Database();
        $resultados = $bd->select("
            SELECT * FROM admins 
            WHERE utilizador = :utilizador_admin 
            AND deleted_at IS NULL", $parametros);

        // echo '<pre>';
        // print_r($resultados);
        // die('fim');
        if (count($resultados) != 1) {

            // Não existe Admin
            return false;
        } else {
            // Temos utilizador Admin, verifcar a password
            // Que está codificada

            $utilizador_admin = $resultados[0];

            // Verifar a pass
            if (!password_verify($password, $utilizador_admin->senha)) {
                // password inválida
                return false;
            } else {
                // Login é válido // Utilizador existe e a pass está OK
                return $utilizador_admin;
            }
        }
    }
    public function cliente_delete_hard_confirm()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['erro'] = "ID inválido!";
            return;
        }

        $id_cliente = $_GET['id'];
        $cliente = Clientes::buscarClienteporId($id_cliente);

        if (!$cliente) {
            $_SESSION['erro'] = "Cliente não encontrado!";
            return;
        }

        // Aqui podes renderizar a página/modal com os dados do cliente
        require_once 'views/admin/cliente_delete_hard_confirm.php';
    }

    public function cliente_editar()
    {
        $id = $_GET['id'];
        $cliente = Clientes::buscarClienteporId($id);
        require_once 'views/admin/cliente_editar.php';
    }
}
