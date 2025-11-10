<?php

namespace App\Notifications;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RentalApprovedNotification extends Notification
{
    use Queueable;

    public $rental;

    /**
     * Create a new notification instance.
     */
    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Bisa dikirim ke email & disimpan di DB
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Penyewaan Disetujui ✅')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Penyewaan Anda untuk produk **' . $this->rental->product->name . '** telah disetujui oleh admin.')
            ->line('Durasi sewa: ' . $this->rental->days . ' hari')
            ->line('Total harga: Rp' . number_format($this->rental->total_price, 0, ',', '.'))
            ->action('Lihat Detail Sewa', url('/user/rentals'))
            ->line('Terima kasih telah menggunakan layanan GoCamp!');
    }

    /**
     * Get the array representation of the notification for database storage.
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Penyewaan Anda untuk ' . $this->rental->product->name . ' telah disetujui!',
            'rental_id' => $this->rental->id,
        ];
    }
}
