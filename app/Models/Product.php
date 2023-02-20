<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ["nombre", "descripcion", "precio"];

    protected function Nombre(): Attribute
    {
        return new Attribute(
            fn ($value) => strtoupper($value),
            fn ($value) => ucfirst(strtolower($value))
        );
    }

    // public function setNombreAttribute($value) {
    //     $this->attributes['nombre'] = ucfirst(strtolower($value));
    // }

    // public function getNombreAttribute($value) {
    //     return $this->attributes['nombre'] = strtoupper($value);
    // }

    public function getPrecioAttribute($value) {
        return $this->attributes['precio'] = $value . " €";
    }
}