<?php

namespace core\controllers;

use core\classes\store;

class Loja
{
    public static function Layout_admin($estruturas, $dados = NULL)
    {
        if (!is_array($estruturas)) {
            throw new \Exception("Colecao de estruturas invalida");
        }
        if (!empty($dados) && is_array($dados)) {
            extract($dados);
        }
        foreach ($estruturas as $estrutura) {
            include("../../core/views/$estrutura.php");
        }
    }
}
