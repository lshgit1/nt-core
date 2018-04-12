<?php
require_once './_common.php';

// Routing
$route = new Klein\Klein();

$route->respond('GET', '/', function() {
    require_once NT_HOME_PATH.DIRECTORY_SEPARATOR.'index.php';
});

$route->onHttpError(function ($code, $router) {
    global $html;
    switch ($code) {
        case 404:
            require_once NT_HOME_PATH.DIRECTORY_SEPARATOR.'index.php';
            break;
        default:
            break;
    }
});

$route->dispatch();