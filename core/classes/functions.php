<?php

namespace core\classes;
class functions
{

    public static function Layout($estruturas)
    {
        if (!is_array($estruturas)) {
            throw new \Exception("Erro: O parametro passado para a funcao Layout() deve ser um array.");
        }

        foreach ($estruturas as $estrutura) {
            include("../core/views/$estrutura.php");
        }


    }
    

}