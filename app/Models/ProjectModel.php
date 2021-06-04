<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    use HasFactory;
    protected $table = 'ngocphandang_project';
    protected $primaryKey = 'projectid';
    protected $guarded =[];
//    protected $fillable = [
//        'projectname',
//        'template',
//        'ma_da',
//        'package',
//        'title_app',
//        'buildinfo_app_name_x',
//        'buildinfo_store_name_x',
//        'buildinfo_link_policy_x',
//        'buildinfo_link_fanpage',
//        'buildinfo_link_website',
//        'buildinfo_link_store',
//        'buildinfo_vernum',
//        'buildinfo_verstr',
//        'buildinfo_keystore',
//        'ads_id',
//        'ads_banner',
//        'ads_inter',
//        'ads_reward',
//        'ads_native',
//        'ads_open',
//        'buildinfo_console',
//        'buildinfo_time',
//        'buildinfo_mess',
//        'time_mess',
//    ];
}
