<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    // N:M Partners
    public function partners(){
        return $this->belongsToMany(Partner::class)->withPivot('date')->withTimestamps();
    }

    // N:M Centers
    public function centers(){
        return $this->belongsToMany(Center::class)->withTimestamps();
    }
}
