<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    // 1:N Centers
    public function center(){
        return $this->belongsTo(Center::class);
    }
}
