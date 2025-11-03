<?php

require_once __DIR__ . '/../../connection/init.php';

/** @var mysqli $connection */

// Obtener el ID de la noticia a editar
$id = (int)getRequestParam('id');
if ($id <= 0) {
    redirect('../index.php');
}

$stmt = $connection->prepare("DELETE FROM noticias WHERE id = ?");
if ($stmt) {
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $_SESSION['flash_success'] = 'La noticia se eliminó correctamente.';
    } else {
        $_SESSION['flash_errors'] = ['Error al eliminar la noticia de la base de datos.'];
    }
    $stmt->close();
} else {
    $_SESSION['flash_errors'] = ['Error al preparar la consulta de eliminación.'];
}

// Redirigir al listado
redirect('../index.php');
