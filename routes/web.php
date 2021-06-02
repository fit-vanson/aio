<?php

use App\Http\Controllers\DaController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\Ga_devController;
use App\Http\Controllers\GaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckLogout;
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
Route::group(['prefix'=>'admin','middleware'=>'CheckLogout'], function (){
    Route::get('/',[HomeController::class,'getHome'])->name('index');
});

Route::get('/',[HomeController::class,'getHome'])->middleware('CheckLogout')->name('index');

Route::group(['prefix'=>'user','middleware'=>'CheckLogout'], function (){
    Route::get('/',[UserController::class,'index'])->name('user.index')->middleware('can:user-index');
    Route::post('/create',[UserController::class,'create'])->name('user.create')->middleware('can:user-add');
    Route::get('/edit/{id}',[UserController::class,'edit'])->name('user.edit')->middleware('can:user-edit');
    Route::get('/show/{id}',[UserController::class,'show'])->name('user.show')->middleware('can:user-show');
    Route::post('/update',[UserController::class,'update'])->name('user.update')->middleware('can:user-update');
    Route::get('/delete/{id}',[UserController::class,'delete'])->name('user.delete')->middleware('can:user-delete');
});
Route::group(['prefix'=>'role','middleware'=>'CheckLogout'], function (){
    Route::get('/',[RoleController::class,'index'])->name('role.index')->middleware('can:vai_tro-index');
    Route::post('/create',[RoleController::class,'create'])->name('role.create')->middleware('can:vai_tro-add');
    Route::get('/edit/{id}',[RoleController::class,'edit'])->name('role.edit')->middleware('can:vai_tro-edit');
    Route::get('/show/{id}',[RoleController::class,'show'])->name('role.show')->middleware('can:vai_tro-show');
    Route::post('/update',[RoleController::class,'update'])->name('role.update')->middleware('can:vai_tro-update');
    Route::get('/delete/{id}',[RoleController::class,'delete'])->name('role.delete')->middleware('can:vai_tro-delete');
});
Route::group(['prefix'=>'permission','middleware'=>'CheckLogout'], function (){
    Route::get('/',[PermissionController::class,'index'])->name('permission.index')->middleware('can:phan_quyen-index');
    Route::post('/create',[PermissionController::class,'create'])->name('permission.create')->middleware('can:phan_quyen-add');
    Route::get('/edit/{id}',[PermissionController::class,'edit'])->name('permission.edit')->middleware('can:phan_quyen-edit');
    Route::get('/show/{id}',[PermissionController::class,'show'])->name('permission.show')->middleware('can:phan_quyen-show');
    Route::post('/update',[PermissionController::class,'update'])->name('permission.update')->middleware('can:phan_quyen-update');
    Route::get('/delete/{id}',[PermissionController::class,'delete'])->name('permission.delete')->middleware('can:phan_quyen-delete');
});


Route::group(['prefix'=>'project','middleware'=>'CheckLogout'], function (){
    Route::get('/',[ProjectController::class,'index'])->name('project.index')->middleware('can:project-index');
    Route::post('/create',[ProjectController::class,'create'])->name('project.create')->middleware('can:project-add');
    Route::get('/edit/{id}',[ProjectController::class,'edit'])->name('project.edit')->middleware('can:project-edit');
    Route::get('/show/{id}',[ProjectController::class,'show'])->name('project.show')->middleware('can:project-show');
    Route::post('/update',[ProjectController::class,'update'])->name('project.update')->middleware('can:project-update');
    Route::get('/delete/{id}',[ProjectController::class,'delete'])->name('project.delete')->middleware('can:project-delete');
});
Route::group(['prefix'=>'template','middleware'=>'CheckLogout'], function (){
    Route::get('/',[TemplateController::class,'index'])->name('template.index')->middleware('can:template-index');
    Route::post('/create',[TemplateController::class,'create'])->name('template.create')->middleware('can:template-add');
    Route::get('/edit/{id}',[TemplateController::class,'edit'])->name('template.edit')->middleware('can:template-edit');
    Route::get('/show/{id}',[TemplateController::class,'edit'])->name('template.show')->middleware('can:template-show');
    Route::post('/update',[TemplateController::class,'update'])->name('template.update')->middleware('can:template-update');
    Route::get('/delete/{id}',[TemplateController::class,'delete'])->name('template.delete')->middleware('can:template-delete');
});
Route::group(['prefix'=>'ga_dev','middleware'=>'CheckLogout'], function (){
    Route::get('/',[Ga_devController::class,'index'])->name('gadev.index')->middleware('can:gadev-index');
    Route::post('/create',[Ga_devController::class,'create'])->name('gadev.create')->middleware('can:gadev-add');
    Route::get('/edit/{id}',[Ga_devController::class,'edit'])->name('gadev.edit')->middleware('can:gadev-edit');
    Route::get('/show/{id}',[Ga_devController::class,'show'])->name('gadev.show')->middleware('can:gadev-show');
    Route::post('/update',[Ga_devController::class,'update'])->name('gadev.update')->middleware('can:gadev-update');
    Route::get('/delete/{id}',[Ga_devController::class,'delete'])->name('gadev.delete')->middleware('can:gadev-delete');
});

Route::group(['prefix'=>'dev','middleware'=>'CheckLogout'], function (){
    Route::get('/',[DevController::class,'index'])->name('dev.index')->middleware('can:dev-index');
    Route::post('/create',[DevController::class,'create'])->name('dev.create')->middleware('can:dev-add');
    Route::get('/edit/{id}',[DevController::class,'edit'])->name('dev.edit')->middleware('can:dev-edit');
    Route::get('/show/{id}',[DevController::class,'show'])->name('dev.show')->middleware('can:dev-show');
    Route::post('/update',[DevController::class,'update'])->name('dev.update')->middleware('can:dev-update');
    Route::get('/delete/{id}',[DevController::class,'delete'])->name('dev.delete')->middleware('can:dev-delete');
});

Route::group(['prefix'=>'ga','middleware'=>'CheckLogout'], function (){
    Route::get('/',[GaController::class,'index'])->name('ga.index')->middleware('can:ga-index');
    Route::post('/create',[GaController::class,'create'])->name('ga.create')->middleware('can:ga-add');
    Route::get('/edit/{id}',[GaController::class,'edit'])->name('ga.edit')->middleware('can:ga-edit');
    Route::get('/show/{id}',[GaController::class,'show'])->name('ga.show')->middleware('can:ga-show');
    Route::post('/update',[GaController::class,'update'])->name('ga.update')->middleware('can:ga-update');
    Route::get('/delete/{id}',[GaController::class,'delete'])->name('ga.delete')->middleware('can:ga-delete');
});


Route::group(['prefix'=>'da','middleware'=>'CheckLogout'], function (){
    Route::get('/',[DaController::class,'index'])->name('da.index')->middleware('can:du_an-index');
    Route::post('/create',[DaController::class,'create'])->name('da.create')->middleware('can:du_an-add');
    Route::get('/edit/{id}',[DaController::class,'edit'])->name('da.edit')->middleware('can:du_an-edit');
    Route::get('/show/{id}',[DaController::class,'show'])->name('da.show')->middleware('can:du_an-show');
    Route::post('/update',[DaController::class,'update'])->name('da.update')->middleware('can:du_an-update');
    Route::get('/delete/{id}',[DaController::class,'delete'])->name('da.delete')->middleware('can:du_an-delete');
});











