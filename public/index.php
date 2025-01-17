<?php
use core\classes\database;
use core\classes\functions;

include '../core/classes/functions.php';

session_start();

require_once '../config.php';
require_once '../vendor/autoload.php';

$bd = new database();
$clientes = $bd->select("SELECT  nome FROM clientes");
print_r($clientes);
echo "<pre>";
echo $clientes[0]->nome. "<br>";
echo $clientes[2]->nome. "<br>";

