<?php

namespace App\Http\Controllers;

use App\Models\Setting;
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
}
