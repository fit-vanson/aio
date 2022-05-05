<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ga_dev extends Model
{
    use HasFactory;
    use Compoships;

    public $timestamps = false;
    protected $table = 'ngocphandang_gadev';
    protected $fillable = [
        'gmail','mailrecovery','vpn_iplogin'
    ];
}
