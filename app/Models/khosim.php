<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class khosim extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table= 'ngocphandang_khosim';
    protected $guarded = [];

}
