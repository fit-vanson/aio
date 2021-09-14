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
    public function index()
    {
        return view('home');
    }
    public function getHome(){
        $googleAuthenticator = new \PHPGangsta_GoogleAuthenticator();
        // Tạo secret code
        $secretCode = $googleAuthenticator->createSecret();
        // Tạo QR code từ secret code. Tham số đầu tiên là tên. Chúng ta sẽ hiển thị
        // email hiện tại của người dùng. Tham số tiếp theo là secret code và tham số cuối cùng
        // là tiêu đề của ứng dụng. Sử dụng để người dùng biết code này đang sử dụng cho dịch vụ nào
        // Bạn có thể tùy ý sử dụng tham số 1 và 3.
        $qrCodeUrl = $googleAuthenticator->getQRCodeGoogleUrl(
            auth()->user()->email, $secretCode, config("app.name")
        );
        // Lưu secret code vào session để phục vụ cho việc kiểm tra bên dưới
        // và update vào database trong trường hợp người dùng nhập đúng mã được sinh ra bởi
        // ứng dụng Google Authenticator
        session(["secret_code" => $secretCode]);
        return view("index", compact("qrCodeUrl"));

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
        $remember = $request->input('remember_me');
        if(Auth::attempt(['name'=>$name,'password'=>$password],$remember)){
            return \redirect()->intended('admin/');
        }else{
            return back()->withInput()->with('error','Mật khẩu hoặc tài khoản không đúng!');
        }

    }
    public function logout(){
        session()->flush();
        Auth::logout();
        return \redirect()->intended('login');
    }

}
