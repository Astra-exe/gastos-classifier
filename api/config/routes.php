<?php

declare(strict_types=1);

/**
 * Definición de rutas y middlewares de la aplicación.
 */
(static function () use ($router) {
    $router->get('/', \App\Controllers\HomeController::class.'->welcome');
    $router->post('/expenses', \App\Controllers\ExpenseController::class.'->index');
})();
