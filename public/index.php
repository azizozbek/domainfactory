<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config;
use App\Controllers\DomainController;

Config::init();
session_start();

if (!isset($_SESSION['nonce'])) {
    $_SESSION['nonce'] = bin2hex(random_bytes(12));
}
header("Content-Security-Policy: script-src 'nonce-{$_SESSION['nonce']}'");

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = rtrim($path, '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'];

$domainController = new DomainController();

if ($path === '/' && $method === 'GET') {
    $domainController->index();
}
elseif ($path === '/create' && $method === 'POST') {
    $domainController->index();
}
elseif ($path === '/refresh' && $method === 'GET') {
    $domainController->refreshDomainList();
}
else {
    http_response_code(404);
    echo "404 - Page Not Found";
}