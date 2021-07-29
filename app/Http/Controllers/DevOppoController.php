<?php

namespace App\Http\Controllers;

use App\Models\Dev;

use App\Models\Dev_Oppo;
use App\Models\Ga;
use App\Models\Ga_dev;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class DevOppoController extends Controller
{
    public function index()
    {
        $ga_name = Ga::latest('id')->get();
        $ga_dev = Ga_dev::latest('id')->get();
        return view('dev-oppo.index',compact(['ga_name','ga_dev']));
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
        $totalRecords = Dev_Oppo::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Dev_Oppo::select('count(*) as allcount')
            ->where('oppo_ga_name', 'like', '%' . $searchValue . '%')
            ->orWhere('oppo_dev_name', 'like', '%' . $searchValue . '%')
            ->orWhere('oppo_store_name', 'like', '%' . $searchValue . '%')
            ->orWhere('oppo_email', 'like', '%' . $searchValue . '%')
            ->orWhere('oppo_status', 'like', '%' . $searchValue . '%')
            ->orWhere('oppo_note', 'like', '%' . $searchValue . '%')
            ->count();

        // Get records, also we have included search filter as well
        $records = Dev_Oppo::orderBy($columnName, $columnSortOrder)
            ->where('oppo_ga_name', 'like', '%' . $searchValue . '%')
            ->orWhere('oppo_dev_name', 'like', '%' . $searchValue . '%')
            ->orWhere('oppo_store_name', 'like', '%' . $searchValue . '%')
            ->orWhere('oppo_email', 'like', '%' . $searchValue . '%')
            ->orWhere('oppo_status', 'like', '%' . $searchValue . '%')
            ->orWhere('oppo_note', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();



        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editDevoppo('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteDevoppo"><i class="ti-trash"></i></a>';

            $ga_name = DB::table('ngocphandang_dev_oppo')
                ->join('ngocphandang_ga','ngocphandang_ga.id','=','ngocphandang_dev_oppo.oppo_ga_name')
                ->where('ngocphandang_ga.id',$record->oppo_ga_name)
                ->first();
            $email = DB::table('ngocphandang_dev_oppo')
                ->join('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev_oppo.oppo_email')
                ->where('ngocphandang_gadev.id',$record->oppo_email)
                ->first();


            if($record->oppo_status == 0){
                $status =  '<span class="badge badge-dark">Chưa xử dụng</span>';
            }
            if($record->oppo_status == 1){
                $status = '<span class="badge badge-primary">Đang phát triển</span>';
            }
            if($record->oppo_status == 2){
                $status = '<span class="badge badge-warning">Đóng</span>';
            }
            if($record->oppo_status == 3){
                $status = '<span class="badge badge-danger">Suspend</span>';
            }



            $data_arr[] = array(
                "oppo_ga_name" => $ga_name->ga_name,
                "oppo_dev_name" => $record->oppo_dev_name,
                "oppo_store_name" => $record->oppo_store_name,
                "oppo_email"=>$email->gmail,
                "oppo_status"=>$status,
                "oppo_note"=>$record->oppo_note,
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
            'oppo_store_name' =>'unique:ngocphandang_dev_oppo,oppo_store_name',
            'oppo_dev_name' =>'unique:ngocphandang_dev_oppo,oppo_dev_name',
            'oppo_ga_name' =>'required|not_in:0',
            'oppo_email' =>'required|not_in:0',
        ];
        $message = [
            'oppo_dev_name.unique'=>'Dev name đã tồn tại',
            'oppo_store_name.unique'=>'Store name tồn tại',
            'oppo_ga_name.not_in'=>'Vui lòng chọn Ga Name',
            'oppo_email.not_in'=>'Vui lòng chọn Email',

        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new Dev_Oppo();
        $data['oppo_ga_name'] = $request->oppo_ga_name;
        $data['oppo_email'] = $request->oppo_email;
        $data['oppo_dev_name'] = $request->oppo_dev_name;
        $data['oppo_store_name'] = $request->oppo_store_name;
        $data['oppo_phone'] = $request->oppo_phone;
        $data['oppo_profile_info'] = $request->oppo_profile_info;
        $data['oppo_company'] = $request->oppo_company;
        $data['oppo_pass'] = $request->oppo_pass;
        $data['oppo_status'] = $request->oppo_status;
        $data['oppo_note'] = $request->oppo_note;
        $data->save();
        return response()->json([
            'success'=>'Thêm mới thành công',
        ]);
    }
    public function edit($id)
    {
        $dev = Dev_Oppo::find($id);
        return Response::json($dev);
    }
    public function update(Request $request)
    {

        $id = $request->id;
        $rules = [
            'oppo_store_name' =>'unique:ngocphandang_dev_oppo,oppo_store_name,'.$id.',id',
            'oppo_dev_name' =>'unique:ngocphandang_dev_oppo,oppo_dev_name,'.$id.',id',
            'oppo_ga_name' =>'required|not_in:0',
            'oppo_email' =>'required|not_in:0',
        ];
        $message = [
            'oppo_dev_name.unique'=>'Dev name đã tồn tại',
            'oppo_store_name.unique'=>'Store name tồn tại',
            'oppo_ga_name.not_in'=>'Vui lòng chọn Ga Name',
            'oppo_email.not_in'=>'Vui lòng chọn Email',

        ];

        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = Dev_Oppo::find($id);
        $data->oppo_ga_name = $request->oppo_ga_name;
        $data->oppo_email = $request->oppo_email;
        $data->oppo_dev_name = $request->oppo_dev_name;
        $data->oppo_store_name = $request->oppo_store_name;
        $data->oppo_phone = $request->oppo_phone;
        $data->oppo_profile_info = $request->oppo_profile_info;
        $data->oppo_company = $request->oppo_company;
        $data->oppo_pass = $request->oppo_pass;
        $data->oppo_status = $request->oppo_status;
        $data->oppo_note = $request->oppo_note;
        $data->save();
        return response()->json(['success'=>'Cập nhật thành công']);
    }
    public function delete($id)
    {
        Dev_Oppo::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }
    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }
}
