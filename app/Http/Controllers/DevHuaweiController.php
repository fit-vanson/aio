<?php

namespace App\Http\Controllers;

use App\Models\Dev;

use App\Models\Dev_Huawei;
use App\Models\Ga;
use App\Models\Ga_dev;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DevHuaweiController extends Controller
{
    public function index()
    {
        $ga_name = Ga::latest('id')->get();
        $ga_dev = Ga_dev::latest('id')->get();
        return view('dev-huawei.index',compact(['ga_name','ga_dev']));
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
        $totalRecords = Dev_Huawei::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Dev_Huawei::select('count(*) as allcount')
            ->leftjoin('ngocphandang_ga','ngocphandang_ga.id','=','ngocphandang_dev_huawei.huawei_ga_name')
            ->leftjoin('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev_huawei.huawei_email')
            ->orwhere('ngocphandang_ga.ga_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_huawei.huawei_store_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_huawei.huawei_dev_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_gadev.gmail', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_huawei.huawei_phone', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_huawei.huawei_note', 'like', '%' . $searchValue . '%')
            ->count();

        // Get records, also we have included search filter as well
        $records = Dev_Huawei::orderBy($columnName, $columnSortOrder)
            ->leftjoin('ngocphandang_ga','ngocphandang_ga.id','=','ngocphandang_dev_huawei.huawei_ga_name')
            ->leftjoin('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev_huawei.huawei_email')
            ->orwhere('ngocphandang_ga.ga_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_huawei.huawei_store_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_huawei.huawei_dev_name', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_gadev.gmail', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_huawei.huawei_phone', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_dev_huawei.huawei_note', 'like', '%' . $searchValue . '%')
            ->select('ngocphandang_dev_huawei.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();



        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editDevhuawei('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteDevhuawei"><i class="ti-trash"></i></a>';


            $email = DB::table('ngocphandang_dev_huawei')
                ->join('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev_huawei.huawei_email')
                ->where('ngocphandang_gadev.id',$record->huawei_email)
                ->first();


            if($record->huawei_status == 0){
                $status =  '<span class="badge badge-dark">Chưa xử dụng</span>';
            }
            if($record->huawei_status == 1){
                $status = '<span class="badge badge-primary">Đang phát triển</span>';
            }
            if($record->huawei_status == 2){
                $status = '<span class="badge badge-warning">Đóng</span>';
            }
            if($record->huawei_status == 3){
                $status = '<span class="badge badge-danger">Suspend</span>';
            }

            $project = DB::table('ngocphandang_dev_huawei')
                ->join('ngocphandang_project','ngocphandang_project.huawei_buildinfo_store_name_x','=','ngocphandang_dev_huawei.id')
                ->where('ngocphandang_project.huawei_buildinfo_store_name_x',$record->id)
                ->count();

            if($record->huawei_ga_name == 0 ){
                $ga_name =  '<span class="badge badge-dark">Chưa có</span>';
            }else{
                $ga_name = DB::table('ngocphandang_dev_huawei')
                    ->join('ngocphandang_ga','ngocphandang_ga.id','=','ngocphandang_dev_huawei.huawei_ga_name')
                    ->where('ngocphandang_ga.id',$record->huawei_ga_name)
                    ->first();
                $ga_name = $ga_name->ga_name;
            }


            $data_arr[] = array(
                "huawei_ga_name" => $ga_name,
                "huawei_dev_name" => '<a href="/project?q=dev_huawei&id='.$record->id.'"> <span>'.$record->huawei_dev_name.' - ('.$project.')</span></a>',
                "huawei_store_name" => $record->huawei_store_name,
                "huawei_email"=>$email->gmail,
                "huawei_pass"=>$record->huawei_pass,
                "huawei_status"=>$status,
                "huawei_note"=>$record->huawei_note,
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
        $rules = [
            'huawei_store_name' =>'unique:ngocphandang_dev_huawei,huawei_store_name',
            'huawei_dev_name' =>'unique:ngocphandang_dev_huawei,huawei_dev_name',
            'huawei_email' =>'required|not_in:0',
        ];
        $message = [
            'huawei_dev_name.unique'=>'Dev name tồn tại',
            'huawei_store_name.unique'=>'Store name đã tồn tại',
            'huawei_email.not_in'=>'Vui lòng chọn Email'
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new Dev_Huawei();
        $data['huawei_ga_name'] = $request->huawei_ga_name;
        $data['huawei_email'] = $request->huawei_email;
        $data['huawei_dev_name'] = $request->huawei_dev_name;
        $data['huawei_store_name'] = $request->huawei_store_name;
        $data['huawei_phone'] = $request->huawei_phone;
        $data['huawei_profile_info'] = $request->huawei_profile_info;
        $data['huawei_company'] = $request->huawei_company;
        $data['huawei_pass'] = $request->huawei_pass;
        $data['huawei_status'] = $request->huawei_status;
        $data['huawei_note'] = $request->huawei_note;
        $data->save();
        return response()->json([
            'success'=>'Thêm mới thành công',
        ]);
    }
    public function edit($id)
    {
        $dev = Dev_Huawei::find($id);
        return Response::json($dev);
    }
    public function update(Request $request)
    {

        $id = $request->id;
        $rules = [
            'huawei_store_name' =>'unique:ngocphandang_dev_huawei,huawei_store_name,'.$id.',id',
            'huawei_dev_name' =>'unique:ngocphandang_dev_huawei,huawei_dev_name,'.$id.',id',

            'huawei_email' =>'required|not_in:0',
        ];
        $message = [
            'huawei_dev_name.unique'=>'Dev name tồn tại',
            'huawei_store_name.unique'=>'Store name đã tồn tại',
            'huawei_email.not_in'=>'Vui lòng chọn Email'
        ];

        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = Dev_Huawei::find($id);
        $data->huawei_ga_name = $request->huawei_ga_name;
        $data->huawei_email = $request->huawei_email;
        $data->huawei_dev_name = $request->huawei_dev_name;
        $data->huawei_store_name = $request->huawei_store_name;
        $data->huawei_profile_info = $request->huawei_profile_info;
        $data->huawei_phone = $request->huawei_phone;
        $data->huawei_company = $request->huawei_company;
        $data->huawei_pass = $request->huawei_pass;
        $data->huawei_status = $request->huawei_status;
        $data->huawei_note = $request->huawei_note;
        $data->save();
        return response()->json(['success'=>'Cập nhật thành công']);
    }
    public function delete($id)
    {
        Dev_Huawei::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }
    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }
}
