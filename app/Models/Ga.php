<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ga extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ngocphandang_ga';
    protected $fillable = [
        'ga_name','gmail_gadev_chinh','gmail_gadev_phu_1','gmail_gadev_phu_2','info_phone','info_andress','payment','app_ads','note','status'
    ];
}
