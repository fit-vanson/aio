<?php

use App\Http\Controllers\CocsimController;
use App\Http\Controllers\DaController;
use App\Http\Controllers\DevAmazonController;
use App\Http\Controllers\DevController;

use App\Http\Controllers\DevOppoController;
use App\Http\Controllers\DevSamsungController;
use App\Http\Controllers\DevVivoController;
use App\Http\Controllers\DevXiaomiController;
use App\Http\Controllers\Ga_devController;
use App\Http\Controllers\GaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HubController;
use App\Http\Controllers\KhosimController;
use App\Http\Controllers\MailManageController;
use App\Http\Controllers\MailParentController;
use App\Http\Controllers\MailRegController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TwoFaceAuthsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyTwoFaceController;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear-cache',function (){
    $exitCode = Artisan::call('cache:clear');
});

Route::group(['prefix'=>'login','middleware'=>'CheckUser'], function (){
    Route::get('/',[HomeController::class,'getLogin']);
    Route::post('/',[HomeController::class,'postLogin'])->name('login');
});
Route::get('logout',[HomeController::class,'logout'])->name('logout');
Route::group(['prefix'=>'admin','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[HomeController::class,'getHome'])->name('index');
});

Route::get('/',[HomeController::class,'getHome'])->middleware(['CheckLogout','2fa'])->name('index');

Route::group(['prefix'=>'user','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[UserController::class,'index'])->name('user.index');
    Route::post('/create',[UserController::class,'create'])->name('user.create');
    Route::get('/edit/{id}',[UserController::class,'edit'])->name('user.edit');
    Route::get('/show/{id}',[UserController::class,'show'])->name('user.show');
    Route::post('/update',[UserController::class,'update'])->name('user.update');
    Route::get('/delete/{id}',[UserController::class,'delete'])->name('user.delete');
});
Route::group(['prefix'=>'role','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[RoleController::class,'index'])->name('role.index');
    Route::post('/create',[RoleController::class,'create'])->name('role.create');
    Route::get('/edit/{id}',[RoleController::class,'edit'])->name('role.edit');
    Route::get('/show/{id}',[RoleController::class,'show'])->name('role.show');
    Route::post('/update',[RoleController::class,'update'])->name('role.update');
    Route::get('/delete/{id}',[RoleController::class,'delete'])->name('role.delete');
});
Route::group(['prefix'=>'permission','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[PermissionController::class,'index'])->name('permission.index')->middleware('can:phan_quyen-index');
    Route::post('/create',[PermissionController::class,'create'])->name('permission.create')->middleware('can:phan_quyen-add');
    Route::get('/edit/{id}',[PermissionController::class,'edit'])->name('permission.edit')->middleware('can:phan_quyen-edit');
    Route::get('/show/{id}',[PermissionController::class,'show'])->name('permission.show')->middleware('can:phan_quyen-show');
    Route::post('/update',[PermissionController::class,'update'])->name('permission.update')->middleware('can:phan_quyen-update');
    Route::get('/delete/{id}',[PermissionController::class,'delete'])->name('permission.delete')->middleware('can:phan_quyen-delete');
});



Route::group(['prefix'=>'project','middleware'=>['CheckLogout','2fa']], function (){

//    Route::get('/get',[ProjectController2::class,'getProject']);
    Route::get('/',[ProjectController::class,'index'])->name('project.index')->middleware('can:project-index');
    Route::get('/indexBuild',[ProjectController::class,'indexBuild'])->name('project.indexBuild')->middleware('can:project-index');
    Route::post('/getIndex',[ProjectController::class,'getIndex'])->name('project.getIndex')->middleware('can:project-index');
    Route::post('/getIndexBuild',[ProjectController::class,'getIndexBuild'])->name('project.getIndexBuild')->middleware('can:project-index');
    Route::post('/create',[ProjectController::class,'create'])->name('project.create')->middleware('can:project-add');
    Route::get('/edit/{id}',[ProjectController::class,'edit'])->name('project.edit')->middleware('can:project-edit');
    Route::get('/show/{id}',[ProjectController::class,'show'])->name('project.show')->middleware('can:project-show');
    Route::post('/update',[ProjectController::class,'update'])->name('project.update')->middleware('can:project-update');
    Route::post('/updateQuick',[ProjectController::class,'updateQuick'])->name('project.updateQuick')->middleware('can:project-update');
    Route::get('/delete/{id}',[ProjectController::class,'delete'])->name('project.delete')->middleware('can:project-delete');
    Route::get('/removeProject/{id}',[ProjectController::class,'removeProject'])->name('project.removeProject')->middleware('can:project-edit');

    Route::get('/appChplay',[ProjectController::class,'appChplay'])->name('project.appChplay')->middleware('can:project-index');
    Route::post('/getChplay',[ProjectController::class,'getChplay'])->name('project.getChplay')->middleware('can:project-index');

    Route::get('/appAmazon',[ProjectController::class,'appAmazon'])->name('project.appAmazon')->middleware('can:project-index');
    Route::post('/getAmazon',[ProjectController::class,'getAmazon'])->name('project.getAmazon')->middleware('can:project-index');

    Route::get('/appSamsung',[ProjectController::class,'appSamsung'])->name('project.appSamsung')->middleware('can:project-index');
    Route::post('/getSamsung',[ProjectController::class,'getSamsung'])->name('project.getSamsung')->middleware('can:project-index');

    Route::get('/appXiaomi',[ProjectController::class,'appXiaomi'])->name('project.appXiaomi')->middleware('can:project-index');
    Route::post('/getXiaomi',[ProjectController::class,'getXiaomi'])->name('project.getXiaomi')->middleware('can:project-index');

    Route::get('/appOppo',[ProjectController::class,'appOppo'])->name('project.appOppo')->middleware('can:project-index');
    Route::post('/getOppo',[ProjectController::class,'getOppo'])->name('project.getOppo')->middleware('can:project-index');

    Route::get('/appVivo',[ProjectController::class,'appVivo'])->name('project.appVivo')->middleware('can:project-index');
    Route::post('/getVivo',[ProjectController::class,'getVivo'])->name('project.getVivo')->middleware('can:project-index');




});


Route::group(['prefix'=>'template','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[TemplateController::class,'index'])->name('template.index')->middleware('can:template-index');
    Route::post('/getIndex',[TemplateController::class,'getIndex'])->name('template.getIndex')->middleware('can:project-index');
    Route::post('/create',[TemplateController::class,'create'])->name('template.create')->middleware('can:template-add');
    Route::get('/edit/{id}',[TemplateController::class,'edit'])->name('template.edit')->middleware('can:template-edit');
    Route::get('/show/{id}',[TemplateController::class,'edit'])->name('template.show')->middleware('can:template-show');
    Route::post('/update',[TemplateController::class,'update'])->name('template.update')->middleware('can:template-update');
    Route::get('/delete/{id}',[TemplateController::class,'delete'])->name('template.delete')->middleware('can:template-delete');
});
Route::group(['prefix'=>'ga_dev','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[Ga_devController::class,'index'])->name('gadev.index')->middleware('can:gadev-index');

    Route::post('/create',[Ga_devController::class,'create'])->name('gadev.create')->middleware('can:gadev-add');
    Route::get('/edit/{id}',[Ga_devController::class,'edit'])->name('gadev.edit')->middleware('can:gadev-edit');
    Route::get('/show/{id}',[Ga_devController::class,'show'])->name('gadev.show')->middleware('can:gadev-show');
    Route::post('/update',[Ga_devController::class,'update'])->name('gadev.update')->middleware('can:gadev-update');
    Route::get('/delete/{id}',[Ga_devController::class,'delete'])->name('gadev.delete')->middleware('can:gadev-delete');
});

Route::group(['prefix'=>'dev','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[DevController::class,'index'])->name('dev.index')->middleware('can:dev-index');
    Route::post('/getIndex',[DevController::class,'getIndex'])->name('dev.getIndex')->middleware('can:dev-index');
    Route::post('/create',[DevController::class,'create'])->name('dev.create')->middleware('can:dev-add');
    Route::get('/edit/{id}',[DevController::class,'edit'])->name('dev.edit')->middleware('can:dev-edit');
    Route::get('/show/{id}',[DevController::class,'show'])->name('dev.show')->middleware('can:dev-show');
    Route::post('/update',[DevController::class,'update'])->name('dev.update')->middleware('can:dev-update');
    Route::get('/delete/{id}',[DevController::class,'delete'])->name('dev.delete')->middleware('can:dev-delete');
});

Route::group(['prefix'=>'dev-amazon','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[DevAmazonController::class,'index'])->name('dev_amazon.index')->middleware('can:dev_amazon-index');
    Route::post('/getIndex',[DevAmazonController::class,'getIndex'])->name('dev_amazon.getIndex')->middleware('can:dev_amazon-index');
    Route::post('/create',[DevAmazonController::class,'create'])->name('dev_amazon.create')->middleware('can:dev_amazon-add');
    Route::get('/edit/{id}',[DevAmazonController::class,'edit'])->name('dev_amazon.edit')->middleware('can:dev_amazon-edit');
    Route::get('/show/{id}',[DevAmazonController::class,'show'])->name('dev_amazon.show')->middleware('can:dev_amazon-show');
    Route::post('/update',[DevAmazonController::class,'update'])->name('dev_amazon.update')->middleware('can:dev_amazon-update');
    Route::get('/delete/{id}',[DevAmazonController::class,'delete'])->name('dev_amazon.delete')->middleware('can:dev_amazon-delete');
});

Route::group(['prefix'=>'dev-samsung','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[DevSamsungController::class,'index'])->name('dev_samsung.index')->middleware('can:dev_samsung-index');
    Route::post('/getIndex',[DevSamsungController::class,'getIndex'])->name('dev_samsung.getIndex')->middleware('can:dev_samsung-index');

    Route::post('/create',[DevSamsungController::class,'create'])->name('dev_samsung.create')->middleware('can:dev_samsung-add');
    Route::get('/edit/{id}',[DevSamsungController::class,'edit'])->name('dev_samsung.edit')->middleware('can:dev_samsung-edit');
    Route::get('/show/{id}',[DevSamsungController::class,'show'])->name('dev_samsung.show')->middleware('can:dev_samsung-show');
    Route::post('/update',[DevSamsungController::class,'update'])->name('dev_samsung.update')->middleware('can:dev_samsung-update');
    Route::get('/delete/{id}',[DevSamsungController::class,'delete'])->name('dev_samsung.delete')->middleware('can:dev_samsung-delete');
});

Route::group(['prefix'=>'dev-xiaomi','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[DevXiaomiController::class,'index'])->name('dev_xiaomi.index')->middleware('can:dev_xiaomi-index');
    Route::post('/getIndex',[DevXiaomiController::class,'getIndex'])->name('dev_xiaomi.getIndex')->middleware('can:dev_xiaomi-index');

    Route::post('/create',[DevXiaomiController::class,'create'])->name('dev_xiaomi.create')->middleware('can:dev_xiaomi-add');
    Route::get('/edit/{id}',[DevXiaomiController::class,'edit'])->name('dev_xiaomi.edit')->middleware('can:dev_xiaomi-edit');
    Route::get('/show/{id}',[DevXiaomiController::class,'show'])->name('dev_xiaomi.show')->middleware('can:dev_xiaomi-show');
    Route::post('/update',[DevXiaomiController::class,'update'])->name('dev_xiaomi.update')->middleware('can:dev_xiaomi-update');
    Route::get('/delete/{id}',[DevXiaomiController::class,'delete'])->name('dev_xiaomi.delete')->middleware('can:dev_xiaomi-delete');
});

Route::group(['prefix'=>'dev-oppo','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[DevOppoController::class,'index'])->name('dev_oppo.index')->middleware('can:dev_oppo-index');
    Route::post('/getIndex',[DevOppoController::class,'getIndex'])->name('dev_oppo.getIndex')->middleware('can:dev_oppo-index');

    Route::post('/create',[DevOppoController::class,'create'])->name('dev_oppo.create')->middleware('can:dev_oppo-add');
    Route::get('/edit/{id}',[DevOppoController::class,'edit'])->name('dev_oppo.edit')->middleware('can:dev_oppo-edit');
    Route::get('/show/{id}',[DevOppoController::class,'show'])->name('dev_oppo.show')->middleware('can:dev_oppo-show');
    Route::post('/update',[DevOppoController::class,'update'])->name('dev_oppo.update')->middleware('can:dev_oppo-update');
    Route::get('/delete/{id}',[DevOppoController::class,'delete'])->name('dev_oppo.delete')->middleware('can:dev_oppo-delete');
});

Route::group(['prefix'=>'dev-vivo','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[DevVivoController::class,'index'])->name('dev_vivo.index')->middleware('can:dev_vivo-index');
    Route::post('/getIndex',[DevVivoController::class,'getIndex'])->name('dev_vivo.getIndex')->middleware('can:dev_vivo-index');

    Route::post('/create',[DevVivoController::class,'create'])->name('dev_vivo.create')->middleware('can:dev_vivo-add');
    Route::get('/edit/{id}',[DevVivoController::class,'edit'])->name('dev_vivo.edit')->middleware('can:dev_vivo-edit');
    Route::get('/show/{id}',[DevVivoController::class,'show'])->name('dev_vivo.show')->middleware('can:dev_vivo-show');
    Route::post('/update',[DevVivoController::class,'update'])->name('dev_vivo.update')->middleware('can:dev_vivo-update');
    Route::get('/delete/{id}',[DevVivoController::class,'delete'])->name('dev_vivo.delete')->middleware('can:dev_vivo-delete');
});

Route::group(['prefix'=>'ga','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[GaController::class,'index'])->name('ga.index')->middleware('can:ga-index');
    Route::post('/create',[GaController::class,'create'])->name('ga.create')->middleware('can:ga-add');
    Route::get('/edit/{id}',[GaController::class,'edit'])->name('ga.edit')->middleware('can:ga-edit');
    Route::get('/showDev/{id}',[GaController::class,'showDev'])->name('ga.showDev')->middleware('can:ga-show');
    Route::post('/update',[GaController::class,'update'])->name('ga.update')->middleware('can:ga-update');
    Route::get('/delete/{id}',[GaController::class,'delete'])->name('ga.delete')->middleware('can:ga-delete');
});


Route::group(['prefix'=>'da','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[DaController::class,'index'])->name('da.index')->middleware('can:du_an-index');
    Route::post('/create',[DaController::class,'create'])->name('da.create')->middleware('can:du_an-add');
    Route::get('/edit/{id}',[DaController::class,'edit'])->name('da.edit')->middleware('can:du_an-edit');
    Route::get('/show/{id}',[DaController::class,'show'])->name('da.show')->middleware('can:du_an-show');
    Route::post('/update',[DaController::class,'update'])->name('da.update')->middleware('can:du_an-update');
    Route::get('/delete/{id}',[DaController::class,'delete'])->name('da.delete')->middleware('can:du_an-delete');
});

Route::group(['prefix'=>'khosim','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[KhosimController::class,'index'])->name('khosim.index')->middleware('can:khosim-index');
    Route::get('/getKhosim/', [KhosimController::class, "getKhosim"])->name('khosim.getKhosim');
    Route::post('/create',[KhosimController::class,'create'])->name('khosim.create')->middleware('can:khosim-add');
    Route::get('/edit/{id}',[KhosimController::class,'edit'])->name('khosim.edit')->middleware('can:khosim-edit');
    Route::get('/show/{id}',[KhosimController::class,'show'])->name('khosim.show')->middleware('can:khosim-show');
    Route::post('/update',[KhosimController::class,'update'])->name('khosim.update')->middleware('can:khosim-update');
    Route::get('/delete/{id}',[KhosimController::class,'delete'])->name('khosim.delete')->middleware('can:khosim-delete');
});

Route::group(['prefix'=>'cocsim','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[CocsimController::class,'index'])->name('cocsim.index')->middleware('can:cocsim-index');
    Route::post('/create',[CocsimController::class,'create'])->name('cocsim.create')->middleware('can:cocsim-add');
    Route::get('/edit/{id}',[CocsimController::class,'edit'])->name('cocsim.edit')->middleware('can:cocsim-edit');
    Route::get('/show/{id}',[CocsimController::class,'show'])->name('cocsim.show')->middleware('can:cocsim-show');
    Route::post('/update',[CocsimController::class,'update'])->name('cocsim.update')->middleware('can:cocsim-update');
    Route::get('/delete/{id}',[CocsimController::class,'delete'])->name('cocsim.delete')->middleware('can:cocsim-delete');
});

Route::group(['prefix'=>'hub','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[HubController::class,'index'])->name('hub.index')->middleware('can:hub-index');
    Route::post('/create',[HubController::class,'create'])->name('hub.create')->middleware('can:hub-add');
    Route::get('/edit/{id}',[HubController::class,'edit'])->name('hub.edit')->middleware('can:hub-edit');
    Route::get('/checkbox/{id}',[HubController::class,'checkbox'])->name('hub.checkbox')->middleware('can:hub-edit');
    Route::get('/checkboxAll/{id}',[HubController::class,'checkboxAll'])->name('hub.checkboxAll')->middleware('can:hub-edit');
    Route::get('/show/{id}',[HubController::class,'show'])->name('hub.show')->middleware('can:hub-show');
    Route::post('/update',[HubController::class,'update'])->name('hub.update')->middleware('can:hub-update');
    Route::get('/delete/{id}',[HubController::class,'delete'])->name('hub.delete')->middleware('can:hub-delete');
});


Route::group(['prefix'=>'sms','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[SmsController::class,'index'])->name('sms.index')->middleware('can:sms-index');
    Route::post('/create',[SmsController::class,'create'])->name('sms.create')->middleware('can:sms-add');
    Route::get('/edit/{id}',[SmsController::class,'edit'])->name('sms.edit')->middleware('can:sms-edit');
//    Route::get('/show',[SmsController::class,'show'])->name('sms.show');
    Route::post('/show',[SmsController::class,'showHub'])->name('sms.showHub');
    Route::post('/update',[SmsController::class,'update'])->name('sms.update')->middleware('can:sms-update');
    Route::get('/delete/{id}',[SmsController::class,'delete'])->name('sms.delete')->middleware('can:sms-delete');
});


Route::group(['prefix'=>'mail_manage','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[MailManageController::class,'index'])->name('mail_manage.index')->middleware('can:mail_manage-index');
    Route::post('/create',[MailManageController::class,'create'])->name('mail_manage.create')->middleware('can:mail_manage-add');
    Route::get('/edit/{id}',[MailManageController::class,'edit'])->name('mail_manage.edit')->middleware('can:mail_manage-edit');

    Route::post('/update',[MailManageController::class,'update'])->name('mail_manage.update')->middleware('can:mail_manage-update');
    Route::get('/delete/{id}',[MailManageController::class,'delete'])->name('mail_manage.delete')->middleware('can:mail_manage-delete');
});
Route::get('/2fa/{id}',[MailManageController::class,'show'])->name('mail_manage.show');


Route::group(['prefix'=>'mail_parent','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[MailParentController::class,'index'])->name('mail_parent.index')->middleware('can:mail_parent-index');
    Route::get('/getMailParents/', [MailParentController::class, "getMailParents"])->name('mail_parent.getMailParents');
    Route::get('/noPhone',[MailParentController::class,'indexNo'])->name('mail_parent.indexNo')->middleware('can:mail_parent-index');
    Route::get('/getMailParentsNo/', [MailParentController::class, "getMailParentsNo"])->name('mail_parent.getMailParentsNo');
//    Route::post('/create',[MailManageController::class,'create'])->name('mail_manage.create')->middleware('can:mail_manage-add');
//    Route::get('/edit/{id}',[MailManageController::class,'edit'])->name('mail_manage.edit')->middleware('can:mail_manage-edit');
//    Route::get('/show/{id}',[MailManageController::class,'show'])->name('mail_manage.show')->middleware('can:mail_manage-show');
//    Route::post('/update',[MailManageController::class,'update'])->name('mail_manage.update')->middleware('can:mail_manage-update');
//    Route::get('/delete/{id}',[MailManageController::class,'delete'])->name('mail_manage.delete')->middleware('can:mail_manage-delete');
});


Route::group(['prefix'=>'mail_reg','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[MailRegController::class,'index'])->name('mail_reg.index')->middleware('can:mail_reg-index');
    Route::get('/getMailRegs/', [MailRegController::class, "getMailRegs"])->name('mail_reg.getMailRegs');

});





Route::group(["middleware" => ["auth", "2fa"]], function() {
    Route::get('/home',[HomeController::class,'index']);
    Route::group(["prefix" => "two_face_auths"], function() {
        Route::get('/',[TwoFaceAuthsController::class,'index'])->name('2fa_setting');
        Route::post('/enable',[TwoFaceAuthsController::class,'enable'])->name('enable_2fa_setting');


    });
});

Route::group(["middleware" => ["auth"], "prefix" => "two_face"], function() {
    Route::get('/',[VerifyTwoFaceController::class,'index'])->name('two_face.index');
    Route::post('/verify',[VerifyTwoFaceController::class,'verify'])->name('two_face.verify');
});











