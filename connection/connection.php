<?php

$connection = new mysqli('localhost', 'root', '', 'php-crud_cpganoticias');
if ($connection->connect_errno) {
    die('Error de conexión: ' . $connection->connect_error);
}
$connection->set_charset('utf8mb4');
