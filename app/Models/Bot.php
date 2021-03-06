<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    public $timestamps = false;
    protected $table = 'ngocphandang_bot';
    protected $fillable = [
        'botname',
        'type',
        'console',
        'time',
    ];
    use HasFactory;


    public function botlog(){
        return $this->hasMany(Botlog::class);
    }
}
