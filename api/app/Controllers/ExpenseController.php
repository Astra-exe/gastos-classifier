<?php

namespace App\Controllers;

use Exception;

class ExpenseController extends BaseController
{
    public function index()
    {
        $data = $this->app->request()->data['expenses'] ?? null;

        try {
            $response = \WpOrg\Requests\Requests::post('http://0.0.0.0:3000/classify', [], ['expenses' => $data]);
        } catch (Exception $e) {
            return $this->app->json(['error' => $e->getMessage()]);

        }

        return $this->app->json($response->body ?? ['error' => 'No se encontró la respuesta']);
    }
}
