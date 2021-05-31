<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;


class HomeController extends Controller
{
    public function getHome(){
        return view('index');
    }
    public function getLogin(){
        return view('login');
    }

    public function postLogin(Request $request){
        $validate = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required'

        ]);

        if($validate->fails()){
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
        $name = $request->username;
        $password = $request->password;
        if(Auth::attempt(['name'=>$name,'password'=>$password])){
            return \redirect()->intended('admin/');
        }else{
            return back()->withInput()->with('error','Mật khẩu hoặc tài khoản không đúng!');
        }

    }
    public function logout(){
        Auth::logout();
        return \redirect()->intended('login');
    }

}
