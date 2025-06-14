<?php
declare(strict_types=1);

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$file = __DIR__ . $path;

if(file_exists($file) && $path === "redirect.php"){
    return false;
}

require_once __DIR__ . '/index.php';
