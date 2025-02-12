<?php

namespace App\Controllers;

use Exception;

class ExpenseController extends BaseController
{
    public function index()
    {
        $expenses = $this->app->request()->data['expenses'] ?? null;
        $data = ['expenses' => $expenses];

        try {
            $response = \WpOrg\Requests\Requests::post('http://python-api:5000/classify', [], json_encode($data));
            // $response = \WpOrg\Requests\Requests::get('http://127.0.0.1:5000/');
        } catch (Exception $e) {
            return $this->app->json(['error' => $e->getMessage()]);
        }

        $body = json_decode($response->body ?? '', true);

        return $this->app->json($body ?? ['error' => 'No se encontró la respuesta']);
    }
}
