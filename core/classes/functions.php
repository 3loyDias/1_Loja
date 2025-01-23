<?php

namespace core\classes;
class functions
{

    public static function Layout($estruturas, $dados)
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
    

}