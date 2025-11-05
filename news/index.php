<?php

require_once __DIR__ . '/../connection/init.php';

/** @var mysqli $connection */

$flash_success = getSessionParam('flash_success');
$flash_errors  = getSessionParam('flash_errors');
unset($_SESSION['flash_success'], $_SESSION['flash_errors']);

$user = getSessionParam('user');

$text = getRequestParam('text');
$area = getRequestParam('area');

$areas = getNewsAreas($connection);

$params = [];
$types = '';
$sql = "SELECT * FROM noticias WHERE 1=1";
if ($text !== '') {
    $sql .= " AND titulo LIKE ?";
    $params[] = '%' . $text . '%';
    $types .= 's';
}
if ($area !== '') {
    $sql .= " AND idarea = ?";
    $params[] = (int)$area;
    $types .= 'i';
}
$sql .= " ORDER BY id DESC";

$rr = false;
$stmt = $connection->prepare($sql);
if ($stmt) {
    if (!empty($params)) {
        $bind_params = [];
        $bind_params[] = $types;
        foreach ($params as $k => $v) {
            $bind_params[] = & $params[$k];
        }
        call_user_func_array([$stmt, 'bind_param'], $bind_params);
    }
    $stmt->execute();
    $rr = $stmt->get_result();
    $stmt->close();
} else {
    $rr = false;
}

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de noticias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
</head>
<body class="p-4">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-0">Noticias</h1>
            <small class="text-muted">
                Conectado como <strong><?= e($user) ?></strong>
            </small>
        </div>
        <a href="../auth/logout.php" class="btn btn-outline-secondary">
            <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión
        </a>
    </div>

    <form class="row g-3 mb-4" action="index.php" method="post">
        <div class="col-auto">
            <label class="visually-hidden" for="text">Texto</label>
            <input id="text" name="text" type="text" class="form-control" placeholder="Texto a localizar" value="<?= e($text) ?>">
        </div>
        <div class="col-auto">
            <label class="visually-hidden" for="area">Área</label>
            <select id="area" name="area" class="form-select">
                <option value="">(todas)</option>
                <?php foreach ($areas as $idArea => $nombreArea): ?>
                    <option value="<?= e($idArea) ?>"<?= ($idArea == $area) ? ' selected' : '' ?>>
                        <?= e($nombreArea) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Buscar</button>
            <a href="add" class="btn btn-success mb-3 ms-2"><i class="fa-solid fa-plus"></i> Añadir</a>
        </div>
    </form>

    <?php if (!empty($flash_success)): ?>
        <div class="alert alert-success"><?= e($flash_success) ?></div>
    <?php endif; ?>

    <?php if (!empty($flash_errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($flash_errors as $error): ?>
                    <li><?= e($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Título</th>
                <th scope="col">Área</th>
                <th scope="col" colspan="2" class="text-center">Opciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($rr && $rr->num_rows > 0): ?>
                <?php while ($row = $rr->fetch_assoc()): ?>
                    <tr>
                        <td><?= e($row['id']) ?></td>
                        <td><?= e($row['titulo'] ?? $row['text'] ?? '') ?></td>
                        <td><?= e($areas[$row['idarea']] ?? '') ?></td>
                        <td class="text-center">
                            <a href="update?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="delete/submit.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('¿Estás seguro de que deseas eliminar este elemento?');">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay resultados.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
