<?php
/**
 * connection/init.php
 * -------------------
 * Punto de arranque común del proyecto.
 * Inicia sesión, conecta a la base de datos y carga funciones comunes.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir funciones comunes
require_once __DIR__ . '/functions.php';

// Incluir la conexión a la base de datos
require_once __DIR__ . '/connection.php';

if (empty($noRequireAuth) && !isset($_SESSION['user'])) {
    $projectName = basename(dirname(__DIR__));
    redirect("/$projectName/auth/login.php");
}
