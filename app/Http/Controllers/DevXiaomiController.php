<?php

namespace App\Http\Controllers;

use App\Models\Dev;

use App\Models\Dev_Xiaomi;
use App\Models\Ga;
use App\Models\Ga_dev;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DevXiaomiController extends Controller
{
    public function index()
    {
        $ga_name = Ga::latest('id')->get();
        $ga_dev = Ga_dev::latest('id')->get();
        return view('dev-xiaomi.index',compact(['ga_name','ga_dev']));
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
        $totalRecords = Dev_Xiaomi::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Dev_Xiaomi::select('count(*) as allcount')
            ->where('xiaomi_ga_name', 'like', '%' . $searchValue . '%')
            ->orWhere('xiaomi_dev_name', 'like', '%' . $searchValue . '%')
            ->orWhere('xiaomi_store_name', 'like', '%' . $searchValue . '%')
            ->orWhere('xiaomi_email', 'like', '%' . $searchValue . '%')
            ->orWhere('xiaomi_status', 'like', '%' . $searchValue . '%')
            ->orWhere('xiaomi_note', 'like', '%' . $searchValue . '%')
            ->count();

        // Get records, also we have included search filter as well
        $records = Dev_Xiaomi::orderBy($columnName, $columnSortOrder)
            ->where('xiaomi_ga_name', 'like', '%' . $searchValue . '%')
            ->orWhere('xiaomi_dev_name', 'like', '%' . $searchValue . '%')
            ->orWhere('xiaomi_store_name', 'like', '%' . $searchValue . '%')
            ->orWhere('xiaomi_email', 'like', '%' . $searchValue . '%')
            ->orWhere('xiaomi_status', 'like', '%' . $searchValue . '%')
            ->orWhere('xiaomi_note', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();



        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editDevxiaomi('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteDevxiaomi"><i class="ti-trash"></i></a>';

            $ga_name = DB::table('ngocphandang_dev_xiaomi')
                ->join('ngocphandang_ga','ngocphandang_ga.id','=','ngocphandang_dev_xiaomi.xiaomi_ga_name')
                ->where('ngocphandang_ga.id',$record->xiaomi_ga_name)
                ->first();
            $email = DB::table('ngocphandang_dev_xiaomi')
                ->join('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev_xiaomi.xiaomi_email')
                ->where('ngocphandang_gadev.id',$record->xiaomi_email)
                ->first();


            if($record->xiaomi_status == 0){
                $status =  '<span class="badge badge-dark">Chưa xử dụng</span>';
            }
            if($record->xiaomi_status == 1){
                $status = '<span class="badge badge-primary">Đang phát triển</span>';
            }
            if($record->xiaomi_status == 2){
                $status = '<span class="badge badge-warning">Đóng</span>';
            }
            if($record->xiaomi_status == 3){
                $status = '<span class="badge badge-danger">Suspend</span>';
            }



            $data_arr[] = array(
                "xiaomi_ga_name" => $ga_name->ga_name,
                "xiaomi_dev_name" => $record->xiaomi_dev_name,
                "xiaomi_store_name" => $record->xiaomi_store_name,
                "xiaomi_email"=>$email->gmail,
                "xiaomi_status"=>$status,
                "xiaomi_note"=>$record->xiaomi_note,
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
            'xiaomi_store_name' =>'unique:ngocphandang_dev_xiaomi,xiaomi_store_name',
            'xiaomi_dev_name' =>'unique:ngocphandang_dev_xiaomi,xiaomi_dev_name',
            'xiaomi_ga_name' =>'required|not_in:0',
            'xiaomi_email' =>'required|not_in:0',
        ];
        $message = [
            'xiaomi_dev_name.unique'=>'Dev name tồn tại',
            'xiaomi_store_name.unique'=>'Store name đã tồn tại',
            'xiaomi_ga_name.not_in'=>'Vui lòng chọn Ga Name',
            'xiaomi_email.not_in'=>'Vui lòng chọn Email'
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new Dev_Xiaomi();
        $data['xiaomi_ga_name'] = $request->xiaomi_ga_name;
        $data['xiaomi_email'] = $request->xiaomi_email;
        $data['xiaomi_dev_name'] = $request->xiaomi_dev_name;
        $data['xiaomi_store_name'] = $request->xiaomi_store_name;
        $data['xiaomi_pass'] = $request->xiaomi_pass;
        $data['xiaomi_status'] = $request->xiaomi_status;
        $data['xiaomi_note'] = $request->xiaomi_note;
        $data->save();
        return response()->json([
            'success'=>'Thêm mới thành công',
        ]);
    }
    public function edit($id)
    {
        $dev = Dev_Xiaomi::find($id);
        return Response::json($dev);
    }
    public function update(Request $request)
    {

        $id = $request->id;
        $rules = [
            'xiaomi_store_name' =>'unique:ngocphandang_dev_xiaomi,xiaomi_store_name,'.$id.',id',
            'xiaomi_dev_name' =>'unique:ngocphandang_dev_xiaomi,xiaomi_dev_name,'.$id.',id',
            'xiaomi_ga_name' =>'required|not_in:0',
            'xiaomi_email' =>'required|not_in:0',
        ];
        $message = [
            'xiaomi_dev_name.unique'=>'Dev name tồn tại',
            'xiaomi_store_name.unique'=>'Store name đã tồn tại',
            'xiaomi_ga_name.not_in'=>'Vui lòng chọn Ga Name',
            'xiaomi_email.not_in'=>'Vui lòng chọn Email'
        ];

        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = Dev_Xiaomi::find($id);
        $data->xiaomi_ga_name = $request->xiaomi_ga_name;
        $data->xiaomi_email = $request->xiaomi_email;
        $data->xiaomi_dev_name = $request->xiaomi_dev_name;
        $data->xiaomi_store_name = $request->xiaomi_store_name;
        $data->xiaomi_pass = $request->xiaomi_pass;
        $data->xiaomi_status = $request->xiaomi_status;
        $data->xiaomi_note = $request->xiaomi_note;
        $data->save();
        return response()->json(['success'=>'Cập nhật thành công']);
    }
    public function delete($id)
    {
        Dev_Xiaomi::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }
    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }
}