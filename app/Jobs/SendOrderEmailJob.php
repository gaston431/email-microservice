<?php

namespace App\Jobs;

use App\Mail\OrderProcessedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendOrderEmailJob implements ShouldQueue
{
    use Queueable;

    public array $orderData;

    public function __construct(array $orderData = [])
    {
        $this->orderData = $orderData;
    }

    public function handle(): void
    {
        $emailPayload = [
            'order_id'     => $this->orderData['order_id'] ?? 0,
            'user_name'    => $this->orderData['user_name'] ?? 'Usuario',
            'user_email'   => $this->orderData['user_email'] ?? '',
            'product_name' => $this->orderData['product_name'] ?? 'Producto',
            'quantity'     => $this->orderData['quantity'] ?? 1,
            'total_price'  => $this->orderData['total_price'] ?? 0,
        ];

        Mail::to($emailPayload['user_email'])->send(new OrderProcessedMail($emailPayload));
    }
}