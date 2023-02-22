<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surnames', 'address', 'phone', 'email'];

    public function centers(){
        return $this->belongsToMany(Center::class)->withTimestamps();
    }

    public function treatments(){
        return $this->belongsToMany(Treatment::class)->withPivot('id', 'date')->withTimestamps();
    }
}
