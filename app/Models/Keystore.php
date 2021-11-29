<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keystore extends Model
{
    use HasFactory;
    protected $table= 'ngocphandang_keystores';
    protected $guarded = [];
}
