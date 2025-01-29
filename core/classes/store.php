<?php

namespace core\classes;
class store
{

    public static function Layout($estruturas, $dados=NULL)
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