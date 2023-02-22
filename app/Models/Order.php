<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    public function clientes() {
        // return $this->belongsTo(Cliente::class);
        return $this->belongsToMany(Cliente::class);
    }

    // protected $dates = ['fecha', ];
    // $user->fecha->format('d-m-Y')
    // $user->fecha->addDays(30)
    // $fecha->diffInDays($dt->copy()->addMonth())

    protected $casts = [
        "fecha" => "datetime:d-m-Y"
    ];

    protected function Fecha(): Attribute
    {
        return new Attribute(
            fn ($value) => Carbon::parse($value)->format('d-m-Y'),
            fn ($value) => Carbon::parse($value)->format('d/m/Y'),
        );
    }
}
