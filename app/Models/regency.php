<?php

namespace App\Models;
use App\Models\Province;
use App\Models\Tiket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $table = 'reg_regencies';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'regencie_id');
    }
}
