<?php

$noRequireAuth = true;
require_once __DIR__ . '/../connection/init.php';

$flash_success = getSessionParam('flash_success');
$flash_errors = getSessionParam('flash_errors');
$flash_old = getSessionParam('flash_old');
unset($_SESSION['flash_success'], $_SESSION['flash_errors'], $_SESSION['flash_old']);

$username = $flash_old['username'] ?? '';

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container" style="max-width:560px;">
    <h1 class="mb-4">Acceder</h1>

    <?php if (!empty($flash_success)): ?>
        <div class="alert alert-success"><?= e($flash_success) ?></div>
    <?php endif; ?>

    <?php if (!empty($flash_errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($flash_errors as $e): ?>
                    <li><?= e($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="submit.php" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input id="username" name="username" type="text" class="form-control" value="<?= e($username) ?>">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" name="password" type="password" class="form-control">
        </div>

        <div class="text-center">
            <button type="submit" name="boton" class="btn btn-primary">Iniciar sesión</button>
        </div>
    </form>
</div>
</body>
</html>
