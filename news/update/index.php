<?php

require_once __DIR__ . '/../../connection/init.php';

/** @var mysqli $connection */

// Obtener el ID de la noticia a editar
$id = (int)getRequestParam('id');
if ($id <= 0) {
    redirect('../index.php');
}

// Leer mensajes 'flash' de la sesión (si existen)
$flash_errors = getSessionParam('flash_errors');
$flash_old = getSessionParam('flash_old');

// Borrar flash después de leer
unset($_SESSION['flash_errors'], $_SESSION['flash_old']);

// Cargar datos de la noticia desde la DB
$stmt = $connection->prepare("SELECT titulo, idarea FROM noticias WHERE id = ?");
if ($stmt) {
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $rs = $stmt->get_result();
    $news = $rs->fetch_assoc();
    $stmt->close();
} else {
    redirect('../index.php');
}

// Valores para mostrar en el formulario
$title = $flash_old['title'] ?? $news['titulo'];
$area  = $flash_old['area']  ?? $news['idarea'];

// Cargar áreas para el select
$areas = getNewsAreas($connection);

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h1 class="mb-4">Editar noticia</h1>

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
        <input type="hidden" name="id" value="<?= $id ?>">

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

        <button type="submit" name="boton" class="btn btn-primary">Actualizar</button>
        <a href="../index.php" class="btn btn-secondary ms-2">Volver al listado</a>
    </form>
</div>
</body>
</html>
