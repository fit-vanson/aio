<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dev_Xiaomi extends Model
{
    use HasFactory;

    protected $table = 'ngocphandang_dev_xiaomi';
    protected $guarded = [];

    public function ga(){
        return $this->belongsTo(Ga::class,'xiaomi_ga_name');
    }

}

