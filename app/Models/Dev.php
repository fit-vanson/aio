<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dev extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ngocphandang_dev';
    protected $fillable = [
        'store_name','gmail_gadev_chinh','gmail_gadev_phu_1','gmail_gadev_phu_2','info_phone','info_andress','info_url','info_logo','info_banner','info_policydev','info_fanpage','info_web','status'
    ];
}

