<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $project = ProjectModel::count();
        $projectLastMonth = ProjectModel::select('*')
            ->whereBetween('created_at',
                [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]
            )
            ->count();
        $projectInMonth = ProjectModel::select('*')
            ->whereBetween('created_at',
                [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]
            )
            ->count();

        session(["secret_code" => $secretCode]);
        return view("index", compact(
            "qrCodeUrl",
            "project",
            "projectLastMonth",
            "projectInMonth"
        ));

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

    public static  function statusMarket($markert,$status=null){
        if($markert == 'Chplay'){
            $data = $status ? ProjectModel::where('Chplay_status',$status)->where('Chplay_package','<>',NULL)->count() :  ProjectModel::where('Chplay_package','<>',NULL)->count();
        }elseif ($markert == 'Amazon'){
            $data = $status ? ProjectModel::where('Amazon_status',$status)->where('Amazon_package','<>',NULL)->count() :  ProjectModel::where('Amazon_package','<>',NULL)->count();
        }elseif ($markert == 'Samsung') {
            $data = $status ? ProjectModel::where('Samsung_status', $status)->where('Samsung_package', '<>', NULL)->count() : ProjectModel::where('Samsung_package', '<>', NULL)->count();
        }elseif ($markert == 'Xiaomi') {
            $data = $status ? ProjectModel::where('Xiaomi_status', $status)->where('Xiaomi_package', '<>', NULL)->count() : ProjectModel::where('Xiaomi_package', '<>', NULL)->count();
        }elseif ($markert == 'Oppo') {
            $data = $status ? ProjectModel::where('Oppo_status', $status)->where('Oppo_package', '<>', NULL)->count() : ProjectModel::where('Oppo_package', '<>', NULL)->count();
        }elseif ($markert == 'Vivo') {
            $data = $status ? ProjectModel::where('Vivo_status', $status)->where('Vivo_package', '<>', NULL)->count() : ProjectModel::where('Vivo_package', '<>', NULL)->count();
        }elseif ($markert == 'Huawei') {
            $data = $status ? ProjectModel::where('Huawei_status', $status)->where('Huawei_package', '<>', NULL)->count() : ProjectModel::where('Huawei_package', '<>', NULL)->count();
        }
        return $data;
    }

}
