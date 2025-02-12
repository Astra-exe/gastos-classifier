<?php

namespace App\Controllers;

/**
 * Bienvenida de la API.
 */
class HomeController extends BaseController
{
    public function welcome()
    {
        $this->app->json([
            'message' => 'Hello World!',
        ]);
    }
}
