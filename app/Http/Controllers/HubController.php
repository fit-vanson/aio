<?php

namespace App\Http\Controllers;

use App\Models\cocsim;
use App\Models\Hub;
use App\Models\khosim;
use App\Models\sms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class HubController extends Controller
{
    public function index(Request $request)
    {
        $cocsim = cocsim::all();
        $hub = Hub::all();
        if ($request->ajax()) {
            $data = Hub::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = ' <a href="javascript:void(0)" onclick="editHub('.$row->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger deleteHub"><i class="ti-trash"></i></a>';
                    return $btn;
                })
                ->editColumn('cocsim', function($data){
                    $cocsim = DB::table('ngocphandang_hubinfo')
                        ->join('ngocphandang_cocsim','ngocphandang_cocsim.id','=','ngocphandang_hubinfo.cocsim')
                        ->where('ngocphandang_cocsim.id',$data->cocsim)
                        ->first();
                    if($cocsim != null){
                        return $cocsim->cocsim;
                    }
                })
                ->editColumn('timeupdate', function($data) {
                    if($data->timeupdate == 0 ){
                        return  null;
                    }
                    return date( 'd/m/Y - H:i:s ',$data->timeupdate);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('hub.index',compact(['hub','cocsim']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        $rules = [
            'hubname' =>'unique:ngocphandang_hubinfo,hubname',
            'cocsim' =>'unique:ngocphandang_hubinfo,cocsim',

        ];
        $message = [
            'hubname.unique'=>'Hub Name đã tồn tại',
            'cocsim.unique'=>'Cọc sim đã được sử dụng',

        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new Hub();
        $data['hubname'] = $request->hubname;
        $data['cocsim'] = $request->cocsim;
        $data->save();
        return response()->json(['success'=>'Thêm mới thành công']);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dev = Hub::find($id);
        return response()->json($dev);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $rules = [
            'cocsim' =>'unique:ngocphandang_hubinfo,cocsim,'.$id.',id',
        ];
        $message = [
            'cocsim.unique'=>'Cọc sim đã được sử dụng',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = Hub::find($id);
        $data->cocsim = $request->cocsim;
        $data->save();
        $sms = DB::table('ngocphandang_sms')
            ->Join('ngocphandang_hubinfo','ngocphandang_hubinfo.hubname','=','ngocphandang_sms.hubname')
            ->where('ngocphandang_hubinfo.hubname',$data->hubname)
            ->get();
        $phoneOfcocsim =  DB::table('ngocphandang_khosim')
        ->Join('ngocphandang_cocsim','ngocphandang_cocsim.id','=','ngocphandang_khosim.cocsim')
        ->where('ngocphandang_khosim.cocsim',$data->cocsim)
        ->get();
        $cocsim  = DB::table('ngocphandang_cocsim')->where('cocsim',$data->cocsim);
        dd($cocsim);
        foreach ($sms  as $s){
            dd($s);
            foreach ($phoneOfcocsim as $phone){
                $s->cocsim = $request->cocsim;
                $s->phone = $phone->phone;
                $s->hubid = $s->hubname.'_Slot'.$phone->stt;
                $s = sms::find($s->hubid);
                $s->save();
            }
        }




        return response()->json(['success'=>'Cập nhật thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Hub::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }
}
