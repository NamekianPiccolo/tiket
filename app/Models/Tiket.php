<?php

namespace App\Models;
use App\Models\Regencie;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi plural dari nama model
    protected $table = 'tikets';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'namaTiket', 'harga', 'stok', 'lokawebsi','gambar', 'deskripsi', 'regencie_id', 'tanggal_pelaksanaan', 'status', 'tanggal_selesai_pelaksanaan', 'waktu_mulai', 'waktu_selesai'
    ];
    protected $dates =['tanggal_pelaksanaan']; // kolom tanggal_pelaksanaan sebagai tanggal

    // Tentukan kolom yang tidak boleh diisi (untuk menghindari mass-assignment)
    protected $guarded = [];

    // Kolom-kolom yang harus diperlakukan sebagai timestamp
    public $timestamps = true;

    // Menentukan format angka desimal untuk harga jika diperlukan
    protected $casts = [
        'harga' => 'decimal:2',
    ];
     public function regency()
    {
        return $this->belongsTo(Regency::class, 'regencie_id');
    }
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }



    public function province()
    {
        return $this->regency->province; // indirect access
    }
}
