<?php

require_once __DIR__ . '/../connection/init.php';

session_unset();
session_destroy();

session_start();
$_SESSION['flash_success'] = 'Has cerrado sesión correctamente.';

redirect('login.php');
