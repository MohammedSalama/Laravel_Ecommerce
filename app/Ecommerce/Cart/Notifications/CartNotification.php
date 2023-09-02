<?php

namespace Ecommerce\Cart\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CartNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $cart ,$create_order;
    public $product_id;
    public function __construct($cart,$create_order,$product_id)
    {
        $this->cart= $cart;
        $this->create_order=$create_order;
        $this->product_id=$product_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'cart'=>$this->cart,
            'create_order'=>$this->create_order,
            'product_id'=>$this->product_id
        ];
    }
}
