<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderEmailJob;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EmailController extends Controller
{
    public function sendOrderEmail(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|integer',
            'user_name' => 'required|string',
            'user_email' => 'required|email',
            'product_name' => 'required|string',
            'quantity' => 'required|integer',
            'total_price' => 'required'
        ]);

        // Encolar el Job de forma asíncrona usando el driver 'database'
        SendOrderEmailJob::dispatch($request->all());

        // Responder de inmediato (HTTP 202 Accepted) sin esperar a Mailtrap
        return response()->json(['message' => 'Notificación de correo encolada con éxito.'], 202);
    }

}
