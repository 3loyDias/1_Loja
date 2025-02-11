<?php

namespace core\classes;

class store
{
    public static function Layout($estruturas, $dados = NULL)
    {
        if (!is_array($estruturas)) {
            throw new \Exception("Erro: O parametro passado para a funcao Layout() deve ser um array.");
        }

        if (!empty($dados) && is_array($dados)) {
            extract($dados);
        }

        foreach ($estruturas as $estrutura) {
            include("../core/views/$estrutura.php");
        }
    }

    public static function clienteLogado()
    {
        return isset($_SESSION['cliente']);
    }

    public static function criarHash($num_caraters = 12)
    {
        $chars =
            '01234567890123456789abcdefghijlmnopqrstuvwxyzabcdefghijlmnopqrstuvwxyzABCDEFGH
IJLMNOPQRSTUVWXYZABCDEFGHIJLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($chars), 0, $num_caraters);
    }

    public static function redirect($rota = '')
    {
        header('Location: ' . BASE_URL . "?A=$rota");
    }
}
