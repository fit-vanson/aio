<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailRegController extends Controller
{
    public function index(Request $request)
    {

        $cocsim = cocsim::latest('id')->get();
        $khosim= khosim::latest('id')->get();
        $sms = sms::latest('hubid')->get();
        $hubs = Hub::all();
        if ($request->ajax()) {
            $data = sms::latest('hubid')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = ' <a href="javascript:void(0)" onclick="editSms('.$row->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger deleteSms"><i class="ti-trash"></i></a>';
                    return $btn;
                })
                ->editColumn('timecode', function($data) {
                    if($data->timecode == 0 ){
                        return  null;
                    }
                    return date( 'd/m/Y - H:i:s ',$data->timecode);
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('sms.index',compact(['sms','khosim','cocsim','hubs']));
    }
}
