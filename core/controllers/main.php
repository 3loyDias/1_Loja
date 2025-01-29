<?php

namespace core\controllers;
use core\classes\store;

class Main 
{
    public function index()
    {
        
        /*
            1 - Carregar e tratar dados do banco de dados
            2 - Apresentar o Layout (views)
        */
        
        // Listagem dos clientes


        // Carregar e tratar dados do banco de dados

        // Apresentar o Layout (views)
        
        store::Layout([
            'layouts/html_header',
            'layouts/header',
            'loja',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }

    public function loja()
    {
        echo 'Loja';
    }
    
}