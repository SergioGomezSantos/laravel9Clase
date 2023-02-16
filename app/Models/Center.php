<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    public function workers(){
        return $this->hasMany(Worker::class)->withPivot('date');;
    }

    public function partners(){
        return $this->belongsToMany(Partner::class);
    }

    public function treatments(){
        return $this->belongsToMany(Treatment::class);
    }
}
