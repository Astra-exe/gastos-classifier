<?php

namespace App\Controllers;

class ExpenseController extends BaseController
{
    public function index()
    {
        $this->app->json([
            'expenses' => 2500,
        ]);
    }
}
