<?php

require __DIR__.'/../vendor/autoload.php';

// Crea una instancia del framework.
$app = \Flight::app();

$app->before('start', static function() use ($app) {
  $app->response()->header('X-Frame-Options', '*');
});

// Crea una instancia del enrutador.
$router = $app->router();

// Carga rutas y middlewares de la aplicación.
// Se pasa la variable "$router" al archivo.
require __DIR__.'/routes.php';

// Inicia la ejecución del framework.
$app->start();
