<?php

namespace App\Http\Controllers;

use App\Models\Dev;

use App\Models\Dev_Vivo;
use App\Models\Ga;
use App\Models\Ga_dev;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DevVivoController extends Controller
{
    public function index()
    {
        $ga_name = Ga::latest('id')->get();
        $ga_dev = Ga_dev::latest('id')->get();
        $profiles = Profile::orderBy('profile_name','asc')->get();
        return view('dev-vivo.index',compact(['ga_name','ga_dev','profiles']));
    }
    public function getIndex(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Dev_Vivo::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Dev_Vivo::select('count(*) as allcount')
            ->leftjoin('ngocphandang_ga','ngocphandang_ga.id','=','ngocphandang_dev_vivo.vivo_ga_name')
            ->leftjoin('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev_vivo.vivo_email')
            ->orwhere('ngocphandang_ga.ga_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_vivo.vivo_store_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_vivo.vivo_dev_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_gadev.gmail', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_vivo.vivo_phone', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_vivo.vivo_note', 'like', '%' . $searchValue . '%')
            ->count();

        // Get records, also we have included search filter as well
        $records = Dev_Vivo::orderBy($columnName, $columnSortOrder)
            ->leftjoin('ngocphandang_ga','ngocphandang_ga.id','=','ngocphandang_dev_vivo.vivo_ga_name')
            ->leftjoin('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev_vivo.vivo_email')
            ->orwhere('ngocphandang_ga.ga_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_vivo.vivo_store_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_vivo.vivo_dev_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_gadev.gmail', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_vivo.vivo_phone', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_vivo.vivo_note', 'like', '%' . $searchValue . '%')
            ->select('ngocphandang_dev_vivo.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();



        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editDevvivo('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteDevvivo"><i class="ti-trash"></i></a>';

            $ga_name = DB::table('ngocphandang_dev_vivo')
                ->join('ngocphandang_ga','ngocphandang_ga.id','=','ngocphandang_dev_vivo.vivo_ga_name')
                ->where('ngocphandang_ga.id',$record->vivo_ga_name)
                ->first();
            $email = DB::table('ngocphandang_dev_vivo')
                ->join('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev_vivo.vivo_email')
                ->where('ngocphandang_gadev.id',$record->vivo_email)
                ->first();


            if($record->vivo_status == 0){
                $status =  '<span class="badge badge-dark">Chưa xử dụng</span>';
            }
            if($record->vivo_status == 1){
                $status = '<span class="badge badge-primary">Đang phát triển</span>';
            }
            if($record->vivo_status == 2){
                $status = '<span class="badge badge-warning">Đóng</span>';
            }
            if($record->vivo_status == 3){
                $status = '<span class="badge badge-danger">Suspend</span>';
            }
            if($record->vivo_ga_name == 0 ){
                $ga_name =  '<span class="badge badge-dark">Chưa có</span>';
            }else{
                $ga_name = DB::table('ngocphandang_dev_vivo')
                    ->join('ngocphandang_ga','ngocphandang_ga.id','=','ngocphandang_dev_vivo.vivo_ga_name')
                    ->where('ngocphandang_ga.id',$record->vivo_ga_name)
                    ->first();
                $ga_name = $ga_name->ga_name;
            }

            $project = DB::table('ngocphandang_dev_vivo')
                ->join('ngocphandang_project','ngocphandang_project.Vivo_buildinfo_store_name_x','=','ngocphandang_dev_vivo.id')
                ->where('ngocphandang_project.Vivo_buildinfo_store_name_x',$record->id)
                ->count();

            $data_arr[] = array(
                "vivo_ga_name" => $ga_name,
                "vivo_dev_name" => '<a href="/project?q=dev_vivo&id='.$record->id.'"> <span>'.$record->vivo_dev_name.' - ('.$project.')</span></a>',
                "vivo_store_name" => $record->vivo_store_name,
                "vivo_email"=>$record->vivo_company.'<p class="text-muted">'.$email->gmail.'</p>',
                "vivo_pass"=>$record->vivo_pass,
                "vivo_status"=>$status,
                "vivo_note"=>$record->vivo_note,
                "action"=> $btn,
            );
        }


        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );

        echo json_encode($response);
    }
    public function create(Request  $request)
    {

//        dd($request->all());

        $rules = [
            'vivo_store_name' =>'unique:ngocphandang_dev_vivo,vivo_store_name',
            'vivo_dev_name' =>'unique:ngocphandang_dev_vivo,vivo_dev_name',

            'vivo_email' =>'required|not_in:0',
        ];
        $message = [
            'vivo_dev_name.unique'=>'Dev name đã tồn tại',
            'vivo_store_name.unique'=>'Store name tồn tại',
            'vivo_email.not_in'=>'Vui lòng chọn Email',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new Dev_Vivo();
        $data['vivo_ga_name'] = $request->vivo_ga_name;
        $data['vivo_email'] = $request->vivo_email;
        $data['vivo_dev_name'] = $request->vivo_dev_name;
        $data['vivo_store_name'] = $request->vivo_store_name;
        $data['vivo_company'] = $request->vivo_company;
        $data['vivo_profile_info'] = $request->vivo_profile_info;
        $data['vivo_phone'] = $request->vivo_phone;
        $data['vivo_pass'] = $request->vivo_pass;
        $data['vivo_status'] = $request->vivo_status;
        $data['vivo_note'] = $request->vivo_note;
        $data->save();
        return response()->json([
            'success'=>'Thêm mới thành công',
        ]);
    }
    public function edit($id)
    {
        $dev = Dev_Vivo::find($id);
        return Response::json($dev);
    }
    public function update(Request $request)
    {

        $id = $request->id;
        $rules = [
            'vivo_store_name' =>'unique:ngocphandang_dev_vivo,vivo_store_name,'.$id.',id',
            'vivo_dev_name' =>'unique:ngocphandang_dev_vivo,vivo_dev_name,'.$id.',id',

            'vivo_email' =>'required|not_in:0',
        ];
        $message = [
            'vivo_dev_name.unique'=>'Dev name đã tồn tại',
            'vivo_store_name.unique'=>'Store name tồn tại',

            'vivo_email.not_in'=>'Vui lòng chọn Email',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = Dev_Vivo::find($id);
        $data->vivo_ga_name = $request->vivo_ga_name;
        $data->vivo_email = $request->vivo_email;
        $data->vivo_dev_name = $request->vivo_dev_name;
        $data->vivo_store_name = $request->vivo_store_name;
        $data->vivo_phone = $request->vivo_phone;
        $data->vivo_profile_info = $request->vivo_profile_info;
        $data->vivo_company = $request->vivo_company;
        $data->vivo_pass = $request->vivo_pass;
        $data->vivo_status = $request->vivo_status;
        $data->vivo_note = $request->vivo_note;
        $data->save();
        return response()->json(['success'=>'Cập nhật thành công']);
    }
    public function delete($id)
    {
        Dev_Vivo::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }
    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }
}
