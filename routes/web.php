<?php

use App\Http\Controllers\Ga_devController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckLogout;
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

Route::group(['prefix'=>'login','middleware'=>'CheckUser'], function (){
    Route::get('/',[HomeController::class,'getLogin']);
    Route::post('/',[HomeController::class,'postLogin'])->name('login');
});
Route::get('logout',[HomeController::class,'logout'])->name('logout');

Route::group(['prefix'=>'admin','middleware'=>'CheckLogout'], function (){
    Route::get('/',[HomeController::class,'getHome'])->name('index');
});
Route::get('/',[HomeController::class,'getHome'])->middleware('CheckLogout')->name('index');


Route::group(['prefix'=>'user'], function (){
    Route::get('/',[UserController::class,'index'])->name('user.index');
    Route::post('/create',[UserController::class,'create'])->name('user.create');
    Route::get('/edit/{id}',[UserController::class,'edit'])->name('user.edit');
    Route::post('/update',[UserController::class,'update'])->name('user.update');
    Route::get('/delete/{id}',[UserController::class,'delete'])->name('user.delete');
});

Route::group(['prefix'=>'project','middleware'=>'CheckLogout'], function (){
    Route::get('/',[ProjectController::class,'index'])->name('project.index');
    Route::post('/create',[ProjectController::class,'create'])->name('project.create');
    Route::get('/edit/{id}',[ProjectController::class,'edit'])->name('project.edit');
    Route::post('/update',[ProjectController::class,'update'])->name('project.update');
    Route::get('/delete/{id}',[ProjectController::class,'delete'])->name('project.delete');
});
Route::group(['prefix'=>'template','middleware'=>'CheckLogout'], function (){
    Route::get('/',[TemplateController::class,'index'])->name('template.index');
    Route::post('/create',[TemplateController::class,'create'])->name('template.create');
    Route::get('/edit/{id}',[TemplateController::class,'edit'])->name('template.edit');
    Route::post('/update',[TemplateController::class,'update'])->name('template.update');
    Route::get('/delete/{id}',[TemplateController::class,'delete'])->name('template.delete');
});
Route::group(['prefix'=>'ga_dev','middleware'=>'CheckLogout'], function (){
    Route::get('/',[Ga_devController::class,'index'])->name('gadev.index');
    Route::post('/create',[Ga_devController::class,'create'])->name('gadev.create');
    Route::get('/edit/{id}',[Ga_devController::class,'edit'])->name('gadev.edit');
    Route::post('/update',[Ga_devController::class,'update'])->name('gadev.update');
    Route::get('/delete/{id}',[Ga_devController::class,'delete'])->name('gadev.delete');
});











