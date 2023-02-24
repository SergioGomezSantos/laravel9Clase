<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    // 1:N Workers
    public function workers(){
        return $this->hasMany(Worker::class);
    }

    // N:M Partners
    public function partners(){
        return $this->belongsToMany(Partner::class)->withTimestamps();
    }

    // N:M Treatments
    public function treatments(){
        return $this->belongsToMany(Treatment::class)->withTimestamps();
    }
}
