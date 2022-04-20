<?php

namespace App\Http\Controllers;

use App\Models\log;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $data = Setting::first();
        return view('settings',compact('data'));
    }

    public function update(Request $request)
    {
        $data = Setting::first();
        $data->time_cron = $request->time_cron;
        $data->save();
        return response()->json([
            'success'=>'Cập nhật thành công',
            'data' => $data
            ]);
    }

    public function clear_logs(){
        $data = log::where('updated_at','<', Carbon::now()->subDays(14))->count();
        if($data> 0){
            log::where('updated_at','<', Carbon::now()->subDays(14))->delete();
            return response()->json(['success'=>'Xóa thành công.']);
        }else{
            return response()->json(['errors'=>'Không có dữ liệu.']);
        }
    }
}
