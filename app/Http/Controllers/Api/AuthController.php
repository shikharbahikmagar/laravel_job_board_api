<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();

        $response = [
            'success' => true,
            'message' => 'user registered successfully',
            'name' => $data['name'],
        ];

        return response()->json($response, 200);
    }
}
