<?php

use App\Http\Controllers\CocsimController;
use App\Http\Controllers\DaController;
use App\Http\Controllers\DevController;

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
use App\Http\Controllers\ProjectController2;
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
    Route::get('/',[UserController::class,'index'])->name('user.index')->middleware('can:user-index');
    Route::post('/create',[UserController::class,'create'])->name('user.create')->middleware('can:user-add');
    Route::get('/edit/{id}',[UserController::class,'edit'])->name('user.edit')->middleware('can:user-edit');
    Route::get('/show/{id}',[UserController::class,'show'])->name('user.show')->middleware('can:user-show');
    Route::post('/update',[UserController::class,'update'])->name('user.update')->middleware('can:user-update');
    Route::get('/delete/{id}',[UserController::class,'delete'])->name('user.delete')->middleware('can:user-delete');
});
Route::group(['prefix'=>'role','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[RoleController::class,'index'])->name('role.index')->middleware('can:vai_tro-index');
    Route::post('/create',[RoleController::class,'create'])->name('role.create')->middleware('can:vai_tro-add');
    Route::get('/edit/{id}',[RoleController::class,'edit'])->name('role.edit')->middleware('can:vai_tro-edit');
    Route::get('/show/{id}',[RoleController::class,'show'])->name('role.show')->middleware('can:vai_tro-show');
    Route::post('/update',[RoleController::class,'update'])->name('role.update')->middleware('can:vai_tro-update');
    Route::get('/delete/{id}',[RoleController::class,'delete'])->name('role.delete')->middleware('can:vai_tro-delete');
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
    Route::get('/',[ProjectController::class,'index'])->name('project.index')->middleware('can:project-index');
    Route::post('/create',[ProjectController::class,'create'])->name('project.create')->middleware('can:project-add');
    Route::get('/edit/{id}',[ProjectController::class,'edit'])->name('project.edit')->middleware('can:project-edit');
    Route::get('/show/{id}',[ProjectController::class,'show'])->name('project.show')->middleware('can:project-show');
    Route::post('/update',[ProjectController::class,'update'])->name('project.update')->middleware('can:project-update');
    Route::get('/delete/{id}',[ProjectController::class,'delete'])->name('project.delete')->middleware('can:project-delete');
    Route::get('/getlist',[ProjectController::class,'getList'])->name('project.get_content');
});

Route::group(['prefix'=>'project2','middleware'=>['CheckLogout','2fa']], function (){
    Route::get('/',[ProjectController2::class,'index'])->name('project2.index')->middleware('can:project-index');
    Route::post('/getIndex',[ProjectController2::class,'getIndex'])->name('project2.getIndex')->middleware('can:project-index');
    Route::post('/create',[ProjectController2::class,'create'])->name('project2.create')->middleware('can:project-add');
    Route::get('/edit/{id}',[ProjectController2::class,'edit'])->name('project2.edit')->middleware('can:project-edit');
    Route::get('/show/{id}',[ProjectController2::class,'show'])->name('project2.show')->middleware('can:project-show');
    Route::post('/update',[ProjectController2::class,'update'])->name('project2.update')->middleware('can:project-update');
    Route::post('/updateQuick',[ProjectController2::class,'updateQuick'])->name('project2.updateQuick')->middleware('can:project-update');
    Route::get('/delete/{id}',[ProjectController2::class,'delete'])->name('project2.delete')->middleware('can:project-delete');
    Route::get('/getlist',[ProjectController2::class,'getList'])->name('project2.get_content');
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
    Route::post('/create',[DevController::class,'create'])->name('dev.create')->middleware('can:dev-add');
    Route::get('/edit/{id}',[DevController::class,'edit'])->name('dev.edit')->middleware('can:dev-edit');
    Route::get('/show/{id}',[DevController::class,'show'])->name('dev.show')->middleware('can:dev-show');
    Route::post('/update',[DevController::class,'update'])->name('dev.update')->middleware('can:dev-update');
    Route::get('/delete/{id}',[DevController::class,'delete'])->name('dev.delete')->middleware('can:dev-delete');
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











