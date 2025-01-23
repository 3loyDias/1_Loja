<?php

namespace core\controllers;
use core\classes\functions;

class Main 
{
    public function index()
    {
        $clientes = ["João", "Maria", "José"];
        /*
            1 - Carregar e tratar dados do banco de dados
            2 - Apresentar o Layout (views)
        */
        functions::Layout([
            'layouts/html_header',
            'pagina_inicial',
            'layouts/html_footer',
        ]);
    }

    public function loja()
    {
        echo 'Loja';
    }
    
}