<?php

namespace App\Jobs;

use App\Mail\OrderProcessedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendOrderEmailJob implements ShouldQueue
{
    use Queueable;

    protected array $orderData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $orderData)
    {
        $this->orderData = $orderData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->orderData['user_email'])->send(new OrderProcessedMail($this->orderData));
    }
}
