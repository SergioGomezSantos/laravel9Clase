<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    // Fillable
    protected $fillable = ['name', 'surnames', 'address', 'phone', 'email'];

    // N:M Centers
    public function centers(){
        return $this->belongsToMany(Center::class)->withTimestamps();
    }

    // N:M Treatments
    public function treatments(){
        return $this->belongsToMany(Treatment::class)->withPivot('id', 'date')->withTimestamps();
    }
}
