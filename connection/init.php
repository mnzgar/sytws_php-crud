<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/connection.php';

if (empty($noRequireAuth) && !isset($_SESSION['user'])) {
    $projectName = basename(dirname(__DIR__));
    redirect("/$projectName/auth/login.php");
}
