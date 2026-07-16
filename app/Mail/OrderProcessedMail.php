<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderProcessedMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $orderData;

    /**
     * Create a new message instance.
     */
    public function __construct(array $orderData)
    {
        $this->orderData = $orderData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Gracias por tu Pedido #' . $this->orderData['order_id'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: "
                <h1>¡Hola, {$this->orderData['user_name']}!</h1>
                <p>Gracias por tu pedido. Hemos procesado tu compra con éxito.</p>
                <hr>
                <h3>Detalle del Pedido:</h3>
                <ul>
                    <li><strong>Producto:</strong> {$this->orderData['product_name']}</li>
                    <li><strong>Cantidad:</strong> {$this->orderData['quantity']}</li>
                    <li><strong>Total Pagado:</strong> \${$this->orderData['total_price']}</li>
                </ul>
                <p>Saludos,<br>El equipo de la Tienda.</p>
            ",
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
