<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderPlaced extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    // Channels for notification
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    // Email representation
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Received #' . $this->order->id)
            ->line('Your order has been placed successfully.')
            ->action('View Order', url('/orders/' . $this->order->id))
            ->line('Thank you for shopping with us!');
    }

    // Array representation for database
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'total' => $this->order->total_amount,
            'status' => $this->order->status
        ];
    }
}
