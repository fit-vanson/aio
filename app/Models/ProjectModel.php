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
    public function log(){
        return $this->hasOne(log::class,'projectname','projectname');
    }

    public function da(){
        return $this->belongsTo(Da::class,'ma_da');
    }
    public function matemplate(){
        return $this->belongsTo(Template::class,'template');
    }
}
