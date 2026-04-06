<?php

namespace App\Models;
use App\Models\Regencie;
use App\Models\Tiket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'reg_provinces';
    public $incrementing = false;

    public function regencies()
    {
        return $this->hasMany(Regencie::class, 'province_id', 'id');
    }
    public function tikets()
    {
        return $this->hasManyThrough(Tiket::class, Regencie::class, 'province_id', 'regencie_id', 'id', 'id');
    }
    // Di model Province.php


}
// $province = \App\Models\Province::find('12');
// $villages = $province->villages;


