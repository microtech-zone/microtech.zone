<?php
// Enrutador para el servidor de desarrollo local PHP (php -S localhost:8000 router.php)
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = __DIR__ . $uri;

// Si es un archivo estático o script que existe directamente
if ($uri !== '/' && file_exists($path)) {
    if (is_dir($path)) {
        $indexPath = rtrim($path, '/\\') . DIRECTORY_SEPARATOR . 'index.php';
        if (file_exists($indexPath)) {
            require $indexPath;
            return;
        }
    } else {
        // Servir archivos estáticos directamente (CSS, imágenes, JS, etc.)
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if ($ext !== 'php') {
            return false;
        }
        require $path;
        return;
    }
}

// Para la raíz u otras rutas
require __DIR__ . '/index.php';
