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
            "INSERT INTO clientes VALUES (0, :email, :senha, :nome_completo, :morada, :cidade, :telefone, :purl, :ativo, NOW(), NOW(), NULL)",
            $parametros
        );
        return $purl;
    }

    //============================ VALIDAR EMAIL COM PURL ============================
    public function validar_email($purl)
    {

        $bd = new Database();
        $parametros = [
            ':purl' => $purl
        ];
        $resultados = $bd->select(
            'SELECT * FROM clientes WHERE purl = :purl',
            $parametros
        );

        // Verifica se foi encontrado o cliente
        if (count($resultados) != 1) {
            return false;
        }

        // Fui encontrado o Purl
        $id_cliente = $resultados[0]->id_cliente;

        $parametros = [
            ':id_cliente' => $id_cliente
        ];

        // echo '<pre>';
        // print_r($resultados);
        // die('AQUI');

        //Atualiza o cliente na BD para ativo
        $bd->update("UPDATE clientes SET purl = NULL,  ativo=1, updated_at=NOW() WHERE id_cliente = :id_cliente ", $parametros);
        return true;
    }

    //============================ LOGIN CLIENTE ============================
    public function validar_login($utilizador, $password)
    {
        $bd = new Database();
        $parametros = [
            ':utilizador' => $utilizador
        ];
        $resultados = $bd->select("
        SELECT * FROM clientes
        WHERE email = :utilizador
        AND ATIVO = 1
        AND deleted_at IS NULL", $parametros);

        if (count($resultados) != 1) {
            return false;
        } else {
            $utilizador = $resultados[0];
        }

        if (!password_verify($password, $utilizador->senha)) {
            return false;
        } else {
            return $utilizador;
        }
    }

    //============================ Listar Clientes ============================
    public function lista_clientes()
    {
        $bd = new Database();
        $resultados = $bd->select(
            'SELECT * FROM clientes'
        );
        return $resultados;
    }

    //============================ Pesquisar Cliente por ID ============================
    public function cliente_pesquisar_id($id)
    {
        $bd = new Database();
        $parametros = [
            ':id' => strtolower(trim($id))
        ];
        $resultados = $bd->select(
            'SELECT * FROM clientes WHERE id_cliente = :id',
            $parametros
        );
        return $resultados[0];
    }


    //============================ Buscar Id Cliente ============================
    public static function buscarClienteporId($id)
    {
        $db = new Database();
        $sql = "SELECT * FROM clientes WHERE id_cliente = :id LIMIT 1";
        $params = [':id' => $id];

        $resultado = $db->select($sql, $params);

        return count($resultado) > 0 ? $resultado[0] : null;
    }

    //============================ Apagar Cliente ============================
    public function apagarCliente($id_cliente)
    {
        $bd = new Database();

        // Verifica se o cliente existe antes de apagar
        $cliente = $this->buscarClienteporId($id_cliente);
        if (!$cliente) {
            return false; // Cliente não encontrado
        }

        // Query para apagar o cliente
        $sql = "DELETE FROM clientes WHERE id_cliente = :id_cliente";
        $parametros = [':id_cliente' => $id_cliente];

        return $bd->delete($sql, $parametros);
    }

    /**
     * Verifica se um email já existe na base de dados (excluindo o cliente atual)
     */
    public function emailExiste($email, $id_cliente = null) {
        $bd = new Database();
        
        // Preparar a query base
        $sql = "SELECT id_cliente FROM clientes WHERE email = :email AND deleted_at IS NULL";
        $params = [':email' => $email];

        // Se foi fornecido um ID, excluir o cliente atual da verificação
        if ($id_cliente !== null) {
            $sql .= " AND id_cliente != :id_cliente";
            $params[':id_cliente'] = $id_cliente;
        }

        // Executar a query
        $resultados = $bd->select($sql, $params);
        
        // Retorna true se encontrou algum resultado
        return count($resultados) > 0;
    }
};
