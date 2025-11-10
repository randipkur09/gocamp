<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransaksiBaruNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $transaksi;

    /**
     * Buat instance notifikasi baru.
     *
     * @param  mixed  $transaksi
     */
    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * Tentukan channel notifikasi (database + email).
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Format notifikasi via email.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Transaksi Baru Telah Dibuat')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Transaksi baru telah berhasil dibuat.')
            ->line('Detail Transaksi:')
            ->line('Nama Penyewa: ' . $this->transaksi->user->name)
            ->line('Produk: ' . $this->transaksi->product->name)
            ->line('Tanggal: ' . $this->transaksi->created_at->format('d M Y H:i'))
            ->action('Lihat Detail Transaksi', url('/admin/rentals/' . $this->transaksi->id))
            ->line('Terima kasih telah menggunakan GoCamp!');
    }

    /**
     * Format data yang disimpan ke tabel notifications (database).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'transaksi_id' => $this->transaksi->id,
            'nama_penyewa' => $this->transaksi->user->name,
            'produk' => $this->transaksi->product->name,
            'tanggal' => $this->transaksi->created_at->format('d M Y H:i'),
            'pesan' => 'Transaksi baru telah dibuat oleh ' . $this->transaksi->user->name,
        ];
    }
}
