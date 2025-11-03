<?php

require_once __DIR__ . '/../../connection/init.php';

/** @var mysqli $connection */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['boton'])) {
    $id = (int)getRequestParam('id');
    $title = trim(getRequestParam('title'));
    $area = getRequestParam('area');
    $errors = [];

    // Validaciones
    if ($id <= 0) {
        redirect('../index.php');
    }
    if ($title === '') {
        $errors[] = 'El título es obligatorio.';
    }
    if ($area === '' || !is_numeric($area)) {
        $errors[] = 'Debes seleccionar un área válida.';
    }

    if (empty($errors)) {
        $stmt = $connection->prepare("UPDATE noticias SET titulo = ?, idarea = ? WHERE id = ?");
        if ($stmt) {
            $areaInt = (int)$area;
            $stmt->bind_param('sii', $title, $areaInt, $id);
            if ($stmt->execute()) {
                $_SESSION['flash_success'] = 'La noticia se actualizó correctamente.';
                redirect('../index.php');
            } else {
                $errors[] = 'Error al actualizar en la base de datos.';
            }
            $stmt->close();
        } else {
            $errors[] = 'Error en la preparación de la consulta.';
        }
    }

    // Si hay errores, guardar en sesión para mostrarlos en el formulario
    if (!empty($errors)) {
        $_SESSION['flash_errors'] = $errors;
        $_SESSION['flash_old'] = ['title' => $title, 'area' => $area];
        redirect('index.php?id=' . $id);
    }
}

// Si se accede sin POST, redirigir al formulario
redirect('../index.php');
