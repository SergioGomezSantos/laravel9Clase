<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;

class Order extends Model
{
    use HasFactory;

    public function clientes() {
        // return $this->belongsTo(Cliente::class);
        return $this->belongsToMany(Cliente::class);
    }

    protected $dates = ['fecha', ];

    // $user->fecha->format('d-m-Y')
    // $user->fecha->addDays(30)
    // $fecha->diffInDays($dt->copy()->addMonth())
}
