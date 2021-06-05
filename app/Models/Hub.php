<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table= 'ngocphandang_hubinfo';
    protected $guarded = [];
}
