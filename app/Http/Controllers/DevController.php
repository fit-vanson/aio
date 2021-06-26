<?php

namespace App\Http\Controllers;

use App\Models\Dev;

use App\Models\Ga_dev;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DevController extends Controller
{
    public function index(Request $request)
    {
        $dev=  Dev::latest('id')->get();
        $ga_dev = Ga_dev::latest('id')->get();
        if ($request->ajax()) {
            $data = Dev::latest('id')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = ' <a href="javascript:void(0)" onclick="editDev('.$row->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger deleteProject"><i class="ti-trash"></i></a>';
                    return $btn;
                })
                ->editColumn('info_logo', function($data){
                    if($data->info_logo == null ){
                        return '<img width="60px" height="60px" src="assets\images\logo-member.jpg">';
                    }
                    return '<img width="60px" height="60px" src='.$data->info_logo.'>';
                })

                ->editColumn('info_phone', function($data){
                    if($data->info_andress == null ){
                        return '<span style="color: red;font-size: medium">'.$data->info_phone.'</span>';
                    }
                    return '<span style="color: green">'.$data->info_phone.'</span>';
                })

                ->editColumn('gmail_gadev_chinh', function($data){
                    $gmail = DB::table('ngocphandang_dev')
                        ->join('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev.gmail_gadev_chinh')
                        ->where('ngocphandang_gadev.id',$data->gmail_gadev_chinh)
                        ->first();
                    $gmail1 = DB::table('ngocphandang_dev')
                        ->join('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev.gmail_gadev_phu_1')
                        ->where('ngocphandang_gadev.id',$data->gmail_gadev_phu_1)
                        ->first();
                    $gmail2 = DB::table('ngocphandang_dev')
                        ->join('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev.gmail_gadev_phu_2')
                        ->where('ngocphandang_gadev.id',$data->gmail_gadev_phu_2)
                        ->first();

                    if($gmail != null){
                        $gmail = '<span>'.$gmail->gmail.' - <span style="font-style: italic"> '.$gmail->vpn_iplogin.'</span></span>';
                    }
                    if($gmail1 != null){
                        $gmail1 = '<p style="margin: auto" class="text-muted ">'.$gmail1->gmail.' - <span style="font-style: italic"> '.$gmail1->vpn_iplogin.'</span></p>';
                    }
                    if($gmail2 != null){
                        $gmail2 = '<p style="margin: auto"class="text-muted ">'.$gmail2->gmail.' - <span style="font-style: italic"> '.$gmail2->vpn_iplogin.'</span></p>';
                    }
                    return $gmail.$gmail1.$gmail2;
                })
                ->addColumn('link', function($row){
                    if($row['info_url'] !== Null){
                        $info_url = '<a  target= _blank href="'.$row["info_url"].'" <i style="color:green;" class="ti-check-box h5"></i></a>';
                    } else {
                        $info_url = "<i style='color:red;' class='ti-close h5'></i>";
                    }
                    if($row['info_web'] !== Null){
                        $info_web = '<a  target= _blank href="'.$row["info_web"].'" <i style="color:green;" class="ti-check-box h5"></i></a>';
                    } else {
                        $info_web = "<i style='color:red;' class='ti-close h5'></i>";
                    }
                    if($row['info_fanpage'] !== Null){
                        $info_fanpage = '<a  target= _blank href="'.$row["info_fanpage"].'" <i style="color:green;" class="ti-check-box h5"></i></a>';
                    } else {
                        $info_fanpage= "<i style='color:red;' class='ti-close h5'></i>";
                    }
                    if($row['info_policydev'] !== Null){
                        $info_policydev = '<a  target= _blank href="'.$row["info_policydev"].'" <i style="color:green;" class="ti-check-box h5"></i></a>';
                    } else {
                        $info_policydev = "<i style='color:red;' class='ti-close h5'></i>";
                    }
                    return $info_url .' '. $info_web.' '. $info_fanpage.' '. $info_policydev;
                })
                ->rawColumns(['action','gmail_gadev_chinh','info_logo','status','link','info_phone'])
                ->make(true);
        }
        return view('dev.index',compact(['dev','ga_dev']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        $rules = [
            'store_name' =>'unique:ngocphandang_dev,store_name',
        ];
        $message = [
            'store_name.unique'=>'Tên đã tồn tại',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new Dev();
        $data['dev_name'] = $request->dev_name;
        $data['store_name'] = $request->store_name;
        $data['ma_hoa_don'] = $request->ma_hoa_don;
        $data['gmail_gadev_chinh'] = $request->gmail_gadev_chinh;
        $data['gmail_gadev_phu_1'] = $request->gmail_gadev_phu_1;
        $data['gmail_gadev_phu_2'] = $request->gmail_gadev_phu_2;
        $data['info_phone'] = $request->info_phone;
        $data['info_andress'] = $request->info_andress;
        $data['note'] = $request->note;
        $data['info_url'] = $request->info_url;
        $data['info_logo'] = $request->info_logo;
        $data['info_banner'] = $request->info_banner;
        $data['info_policydev'] = $request->info_policydev;
        $data['info_fanpage'] = $request->info_fanpage;
        $data['info_web'] = $request->info_web;
        $data['status'] = 0;
        $data->save();
        return response()->json([
            'success'=>'Thêm mới thành công',
        ]);
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
        $dev = Dev::find($id);
        return Response::json($dev);
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
        $id = $request->dev_id;
        $rules = [
            'store_name' =>'unique:ngocphandang_dev,store_name,'.$id.',id',
        ];
        $message = [
            'store_name.unique'=>'Tên đã tồn tại',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = Dev::find($id);
        $data->dev_name = $request->dev_name;
        $data->store_name = $request->store_name;
        $data->ma_hoa_don = $request->ma_hoa_don;
        $data->gmail_gadev_chinh = $request->gmail_gadev_chinh;
        $data->gmail_gadev_phu_1 = $request->gmail_gadev_phu_1;
        $data->gmail_gadev_phu_2 = $request->gmail_gadev_phu_2;
        $data->info_phone = $request->info_phone;
        $data->info_andress= $request->info_andress;
        $data->note= $request->note;
        $data->info_url = $request->info_url;
        $data->info_logo = $request->info_logo;
        $data->info_banner = $request->info_banner;
        $data->info_policydev = $request->info_policydev;
        $data->info_fanpage = $request->info_fanpage;
        $data->info_web = $request->info_web;
        $data->status = $request->status;

        $data->save();
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
        Dev::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }
}
