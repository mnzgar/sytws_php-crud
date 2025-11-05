<?php

require_once __DIR__ . '/../../connection/init.php';

/** @var mysqli $connection */

$flash_errors = getSessionParam('flash_errors');
$flash_old = getSessionParam('flash_old');
unset($_SESSION['flash_errors'], $_SESSION['flash_old']);

$title = $flash_old['title'] ?? '';
$area = $flash_old['area'] ?? '';

$areas = getNewsAreas($connection);

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Añadir noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h1 class="mb-4">Añadir noticia</h1>

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
            <label for="title" class="form-label">Título</label>
            <input id="title" name="title" type="text" class="form-control" value="<?= e($title) ?>">
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">Área</label>
            <select id="area" name="area" class="form-select">
                <option value="">(selecciona)</option>
                <?php foreach ($areas as $idArea => $nombreArea): ?>
                    <option value="<?= e($idArea) ?>"<?= ($idArea == $area) ? ' selected' : '' ?>>
                        <?= e($nombreArea) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="boton" class="btn btn-primary">Añadir</button>
        <a href="../index.php" class="btn btn-secondary ms-2">Volver al listado</a>
    </form>
</div>
</body>
</html>
