<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    public function centers(){
        return $this->belongsToMany(Center::class);
    }

    public function treatments(){
        return $this->belongsToMany(Treatment::class);
    }
}
