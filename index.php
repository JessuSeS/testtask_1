<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Factory\ControllerFactory;
use App\Router;

try {
    $router = new Router(new ControllerFactory());
    $router->dispatch($_SERVER['REQUEST_URI']);
} catch (Throwable $e) {
    echo '<PRE>';
    echo $e;
}
