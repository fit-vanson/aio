<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dev_Vivo extends Model
{
    use HasFactory;

    protected $table = 'ngocphandang_dev_vivo';
    protected $guarded = [];

    public function ga(){
        return $this->belongsTo(Ga::class,'vivo_ga_name');
    }
}

