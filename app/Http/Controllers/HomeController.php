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
//    public function __construct()
//    {
//        $this->middleware('auth',['except'=>['getlogin']]);
//    }
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


//    public function postlogin(Request $request){
//
//        $validate = Validator::make($request->all(),[
//            'username' => 'required',
//            'password' => 'required'
//
//        ]);
//
//        if($validate->fails()){
//            return redirect()->back()
//                ->withErrors($validate)
//                ->withInput();
//        }
//        $user = $request->username;
//        $password = md5($request->userpassword);
//
//        if(Auth::check()){
//            if(Auth::attempt(['user'=>$user, 'pass'=>$password])){
//                return view('index');
//            }
//        }
//
//
//
//
////    public function AuthLogin(){
////        $id = Session::get('id');
////        if($id){
////            return Redirect::to('home');
////        } else{
////            return Redirect::to('/')->send();
////        }
////    }
////
////    public function AuthLogout(){
////        $id = Session::get('id');
////        if($id){
////            return Redirect::to('home')->send();
////        } else{
////            return Redirect::to('/');
////        }
////    }
////
////
////    public function home(){
////        $this->AuthLogin();
////        return view('index');
////    }
////
////    public function index(){
////        return view('login');
////    }
////
////

////
//////    public function showlogin(){
//////        return view('login');
//////    }
////
////    public function login(Request $request){
////        $this->AuthLogin();
////
//////        $validate = Validator::make($request->all(),[
//////            'username' => 'required',
//////            'password' => 'required'
//////
//////        ]);
//////
//////        if($validate->fails()){
//////            return redirect()->back()
//////                ->withErrors($validate)
//////                ->withInput();
//////        }
//////        $user = $request->username;
//////        $password = md5($request->userpassword);
////
//////        if(Auth::check()){
//////            if(Auth::attempt(['user'=>$user, 'pass'=>$password])){
//////                return view('index');
//////            }
//////        }
////
////
////
////
////        $user = $request->username;
////        $password = md5($request->password);
////
////        $result = DB::table('tbl_user')->where('user',$user)->where('pass',$password)->first();
//////        dd($result);
////        if($result){
////            Session::put('user',$result->user);
////            Session::put('id',$result->id);
////            return Redirect::to('/home');
////        }else{
////            Session::put('message','Mật khẩu hoặc tài khoản không đúng!');
////            return Redirect::to('/');
////        }
////    }
//
}
