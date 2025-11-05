<?php

require_once __DIR__ . '/../../connection/init.php';

/** @var mysqli $connection */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['boton'])) {
    $title = trim(getRequestParam('title'));
    $area = getRequestParam('area');
    $errors = [];

    if ($title === '') {
        $errors[] = 'El título es obligatorio.';
    }
    if ($area === '' || !is_numeric($area)) {
        $errors[] = 'Debes seleccionar un área válida.';
    }

    if (empty($errors)) {
        $stmt = $connection->prepare("INSERT INTO noticias (titulo, idarea) VALUES (?, ?)");
        if ($stmt) {
            $areaInt = (int)$area;
            $stmt->bind_param('si', $title, $areaInt);
            if ($stmt->execute()) {
                $_SESSION['flash_success'] = 'La noticia se creó correctamente.';
                redirect('../index.php');
            } else {
                $errors[] = 'Error al insertar en la base de datos.';
            }
            $stmt->close();
        } else {
            $errors[] = 'Error en la preparación de la consulta.';
        }
    }

    if (!empty($errors)) {
        $_SESSION['flash_errors'] = $errors;
        $_SESSION['flash_old'] = ['title' => $title, 'area' => $area];
        redirect('index.php');
    }
}

redirect('index.php');
