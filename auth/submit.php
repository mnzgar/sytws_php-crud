<?php

$noRequireAuth = true;
require_once __DIR__ . '/../connection/init.php';

/** @var mysqli $connection */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['boton'])) {
    $username = trim(getRequestParam('username'));
    $password = getRequestParam('password');
    $errors = [];
    $old = ['username' => $username];

    if ($username === '') {
        $errors[] = 'El nombre de usuario es obligatorio.';
    }
    if ($password === '') {
        $errors[] = 'La contraseña es obligatoria.';
    }

    if (!empty($errors)) {
        $_SESSION['flash_errors'] = $errors;
        $_SESSION['flash_old'] = $old;
        redirect('login.php');
    }

    $stmt = $connection->prepare('SELECT * FROM usuarios WHERE usuario = ? LIMIT 1');
    if (!$stmt) {
        $errors[] = 'Error en la preparación de la consulta.';
        $_SESSION['flash_errors'] = $errors;
        $_SESSION['flash_old'] = $old;
        redirect('login.php');
    }

    $stmt->bind_param('s', $username);
    $stmt->execute();
    $rs = $stmt->get_result();
    $user = $rs->fetch_assoc();
    $stmt->close();

    if (!$user || !password_verify($password, $user['contraseña'])) {
        $errors[] = 'Credenciales inválidas.';
        $_SESSION['flash_errors'] = $errors;
        $_SESSION['flash_old'] = $old;
        redirect('login.php');
    }

    $_SESSION['user'] = $user['usuario'];
    $_SESSION['flash_success'] = 'Inicio de sesión correcto.';

    redirect('../news/index.php');
}

redirect('login.php');
