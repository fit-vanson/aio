<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dev_Huawei extends Model
{
    use HasFactory;

    protected $table = 'ngocphandang_dev_huawei';
    protected $guarded = [];
    public function ga(){
        return $this->belongsTo(Ga::class,'huawei_ga_name');
    }

}

