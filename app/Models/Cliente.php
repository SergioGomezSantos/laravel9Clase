<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ["DNI", "Nombre", "Apellidos", "Telefono", "Email"];

    public function orders() {
        // return $this->hasOne(Order::class);
        // return $this->hasMany(Order::class);
        return $this->belongsToMany(Order::class);
    }
}
