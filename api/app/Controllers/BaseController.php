<?php

declare(strict_types=1);

namespace App\Controllers;

use flight\Engine;

/**
 * Controlador base para todos los controladores
 */
abstract class BaseController
{
    protected Engine $app;

    /**
     * Constructor de la clase.
     */
    public function __construct($app)
    {
        $this->app = $app;
    }
}
