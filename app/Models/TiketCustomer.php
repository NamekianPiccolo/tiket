<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketCustomer extends Model
{
    use HasFactory;

    protected $table = 'tiket_customers';

    protected $fillable = [
        'transaksi_id',
        'tiket_id',
        'user_id',
        'kode_tiket',
        'nama',
        'email',
        'status',
        'tanggal_pembelian',
        'qr_code',
        'tanggal_expired',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'datetime',
        'tanggal_expired' => 'datetime',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate QR Code when creating a new ticket
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->kode_tiket = 'TICKET-' . strtoupper(uniqid());
            $model->tanggal_pembelian = now();
            // You can add QR code generation logic here if needed
        });
    }
}
