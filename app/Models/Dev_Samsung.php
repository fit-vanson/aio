<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dev_Samsung extends Model
{
    use HasFactory;

    protected $table = 'ngocphandang_dev_samsung';
    protected $guarded = [];
    public function ga(){
        return $this->belongsTo(Ga::class,'samsung_ga_name');
    }

}

