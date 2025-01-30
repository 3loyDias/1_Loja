<?php

namespace core\controllers;
use core\classes\store;

class Loja
{
    public function carrinho()
    {
        // Apresenta a pagina da loja 
        store::Layout([
            'layouts/html_header',
            'layouts/header',
            'carrinho',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }
}