<?php
use core\classes\database;
use core\classes\store;

session_start();

//Permite a utilizacao de variaveis de sessao
// Já incluído pelo autoloader
// require_once '../../config.php';

require_once '../../vendor/autoload.php';

require_once '../../core/rotas_admin.php';