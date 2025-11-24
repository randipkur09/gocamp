<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BuktiPembayaranUploadedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $rental;

    public function __construct($rental)
    {
        $this->rental = $rental;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Bukti Pembayaran Telah Diupload')
            ->line('User telah mengupload bukti pembayaran.')
            ->line('Nama Penyewa: ' . $this->rental->user->name)
            ->line('Produk: ' . $this->rental->product->name)
            ->action('Lihat Transaksi', url('/admin/rentals/' . $this->rental->id));
    }

    public function toArray($notifiable)
    {
        return [
            'rental_id' => $this->rental->id,
            'user' => $this->rental->user->name,
            'product' => $this->rental->product->name,
            'message' => 'User mengupload bukti pembayaran.'
        ];
    }
}
