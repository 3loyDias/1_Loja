<?php

namespace core\controllers;
use core\classes\store;

class Loja
{
    public function index()
    {
        // Apresenta a pagina da loja 
        store::Layout([
            'layouts/html_header',
            'layouts/header',
            'inicio',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }
}