<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;

class admin
{
    public function index()
    {
        // VERIFICA SE EXISTE SESSÃO ADMIN ABERTA
        if (!Store::adminLogado()) {
            Store::redirect('admin_login', true);

            return;
        }
        //apresenta backoffice
        Store::Layout([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/home',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ]);
    }
    //***************************************************************** 
    public function lista_clientes()
    {
        // Lista de lista_clientes
    }
    //***************************************************************** 
    public function admin_login()
    {
        // VERIFICA SE EXISTE SESSÃO ADMIN ABERTA
        if (Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        //apresenta backoffice
        // QUADRO DE LOGIN
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/layouts/header',
            'admin/login_frm',
            'admin/layouts/footer',
            'admin/layouts/html_footer',
        ]);
    }
}
