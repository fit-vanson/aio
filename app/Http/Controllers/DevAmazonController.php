<?php

namespace App\Http\Controllers;

use App\Models\Dev;

use App\Models\Dev_Amazon;
use App\Models\Ga;
use App\Models\Ga_dev;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DevAmazonController extends Controller
{
    public function index()
    {
        $ga_name = Ga::latest('id')->get();
        $ga_dev = Ga_dev::latest('id')->get();
        return view('dev-amazon.index',compact(['ga_name','ga_dev']));
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
        $totalRecords = Dev_Amazon::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Dev_Amazon::select('count(*) as allcount')
            ->where('amazon_ga_name', 'like', '%' . $searchValue . '%')
            ->orWhere('amazon_dev_name', 'like', '%' . $searchValue . '%')
            ->orWhere('amazon_store_name', 'like', '%' . $searchValue . '%')
            ->orWhere('amazon_email', 'like', '%' . $searchValue . '%')
            ->orWhere('amazon_status', 'like', '%' . $searchValue . '%')
            ->orWhere('amazon_note', 'like', '%' . $searchValue . '%')
            ->count();

        // Get records, also we have included search filter as well
        $records = Dev_Amazon::orderBy($columnName, $columnSortOrder)
            ->where('amazon_ga_name', 'like', '%' . $searchValue . '%')
            ->orWhere('amazon_dev_name', 'like', '%' . $searchValue . '%')
            ->orWhere('amazon_store_name', 'like', '%' . $searchValue . '%')
            ->orWhere('amazon_email', 'like', '%' . $searchValue . '%')
            ->orWhere('amazon_status', 'like', '%' . $searchValue . '%')
            ->orWhere('amazon_note', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();



        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editDevAmazon('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteDevAmazon"><i class="ti-trash"></i></a>';

            $ga_name = DB::table('ngocphandang_dev_amazon')
                ->join('ngocphandang_ga','ngocphandang_ga.id','=','ngocphandang_dev_amazon.amazon_ga_name')
                ->where('ngocphandang_ga.id',$record->amazon_ga_name)
                ->first();
            $email = DB::table('ngocphandang_dev_amazon')
                ->join('ngocphandang_gadev','ngocphandang_gadev.id','=','ngocphandang_dev_amazon.amazon_email')
                ->where('ngocphandang_gadev.id',$record->amazon_email)
                ->first();


            if($record->amazon_status == 0){
                $status =  '<span class="badge badge-dark">Chưa xử dụng</span>';
            }
            if($record->amazon_status == 1){
                $status = '<span class="badge badge-primary">Đang phát triển</span>';
            }
            if($record->amazon_status == 2){
                $status = '<span class="badge badge-warning">Đóng</span>';
            }
            if($record->amazon_status == 3){
                $status = '<span class="badge badge-danger">Suspend</span>';
            }



            $data_arr[] = array(
                "amazon_ga_name" => $ga_name->ga_name,
                "amazon_dev_name" => $record->amazon_dev_name,
                "amazon_store_name" => $record->amazon_store_name,
                "amazon_email"=>$email->gmail,
                "amazon_status"=>$status,
                "amazon_note"=>$record->amazon_note,
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
            'amazon_store_name' =>'unique:ngocphandang_dev_amazon,amazon_store_name',
            'amazon_dev_name' =>'unique:ngocphandang_dev_amazon,amazon_dev_name',
            'amazon_ga_name' =>'required|not_in:0',
            'amazon_email' =>'required|not_in:0',
        ];
        $message = [
            'amazon_dev_name.unique'=>'Dev name đã tồn tại',
            'amazon_store_name.unique'=>'Store name tồn tại',
            'amazon_ga_name.not_in'=>'Vui lòng chọn Ga Name',
            'amazon_email.not_in'=>'Vui lòng chọn Email',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new Dev_Amazon();
        $data['amazon_ga_name'] = $request->amazon_ga_name;
        $data['amazon_email'] = $request->amazon_email;
        $data['amazon_dev_name'] = $request->amazon_dev_name;
        $data['amazon_store_name'] = $request->amazon_store_name;
        $data['amazon_pass'] = $request->amazon_pass;
        $data['amazon_status'] = $request->amazon_status;
        $data['amazon_note'] = $request->amazon_note;
        $data->save();
        return response()->json([
            'success'=>'Thêm mới thành công',
        ]);
    }
    public function edit($id)
    {
        $dev = Dev_Amazon::find($id);
        return Response::json($dev);
    }
    public function update(Request $request)
    {

        $id = $request->id;
        $rules = [
            'amazon_store_name' =>'unique:ngocphandang_dev_amazon,amazon_store_name,'.$id.',id',
            'amazon_dev_name' =>'unique:ngocphandang_dev_amazon,amazon_dev_name,'.$id.',id',
            'amazon_ga_name' =>'required|not_in:0',
            'amazon_email' =>'required|not_in:0',
        ];
        $message = [
            'amazon_dev_name.unique'=>'Dev name đã tồn tại',
            'amazon_store_name.unique'=>'Store name tồn tại',
            'amazon_ga_name.not_in'=>'Vui lòng chọn Ga Name',
            'amazon_email.not_in'=>'Vui lòng chọn Email',s
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = Dev_Amazon::find($id);
        $data->amazon_ga_name = $request->amazon_ga_name;
        $data->amazon_email = $request->amazon_email;
        $data->amazon_dev_name = $request->amazon_dev_name;
        $data->amazon_store_name = $request->amazon_store_name;
        $data->amazon_pass = $request->amazon_pass;
        $data->amazon_status = $request->amazon_status;
        $data->amazon_note = $request->amazon_note;
        $data->save();
        return response()->json(['success'=>'Cập nhật thành công']);
    }
    public function delete($id)
    {
        Dev_Amazon::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }
    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }
}