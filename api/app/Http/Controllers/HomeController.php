<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function index(): JsonResponse
    {
         return response()->json([
            'success' => false,
            'code' => 404,
            'message' => 'Pagina nao encontrada.',
            'data' => []
        ], 404);
    }
}