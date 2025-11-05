<?php

function getRequestParam(string $param, $default = '') {
    return $_REQUEST[$param] ?? $default;
}

function getSessionParam(string $param, $default = []) {
    return $_SESSION[$param] ?? $default;
}

function getNewsAreas(mysqli $connection): array {
    $areas = [];
    $sqlAreas = "SELECT * FROM areas ORDER BY area ASC";
    $rr = $connection->query($sqlAreas);
    if ($rr) {
        while ($r = $rr->fetch_assoc()) {
            $areas[$r['id']] = $r['area'];
        }
    }
    return $areas;
}

function e(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): void {
    header("Location: $url");
    exit;
}
