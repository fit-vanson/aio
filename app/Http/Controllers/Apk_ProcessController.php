<?php

namespace App\Http\Controllers;

use App\Models\Apk_Process;
use App\Models\Market_category;
use Illuminate\Http\Request;

class Apk_ProcessController extends Controller
{
    public function index($id){
        $categories = Market_category::where('type',$id)->get();
        return view('apk_process.index',compact('categories'));
    }

    public function getIndex(Request $request){

        if (isset($request->id)){
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
                $totalRecords = Apk_Process::select('count(*) as allcount')->count();
                $totalRecordswithFilter = Apk_Process::orderBy($columnName, $columnSortOrder)
                    ->where('category',$request->id )
                    ->where('appid', 'like', '%' . $searchValue . '%')
                    ->count();


                // Get records, also we have included search filter as well
                $records = Apk_Process::orderBy($columnName, $columnSortOrder)
                    ->where('category',$request->id )
                    ->where('appid', 'like', '%' . $searchValue . '%')
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();
                $data_arr = array();
                foreach ($records as $record) {
//                    $btn = ' <a href="javascript:void(0)" onclick="editKeytore('.$record->id.')" class="btn btn-danger"><i class="ti-trash"></i></a>';
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteApk_process"><i class="ti-trash"></i></a>';

                    if ($record->pss_console == 0){
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" class="btn btn-secondary actionApk_process">Mặc định</a>';
                    }elseif ($record->pss_console == 1){
                        $btn .= ' <span class="btn btn-info">Xử lý</i></span>';
                    }elseif ($record->pss_console == 2){
                        $btn .= ' <span class="btn btn-warning">Đang xử lý</i></span>';
                    }elseif ($record->pss_console == 3){
                        $btn .= ' <span class="btn btn-success">Xong</i></span>';
                    }


                    $screenshots = explode(';',$record->screenshot);
                    $data ='<div class="">';
                    foreach ($screenshots as $screenshot){
                        $data .=  '<img class="rounded mr-2 mo-mb-2" alt="200x200" width="100" src="'.$screenshot.'" data-holder-rendered="true">';
                    }
                    $data .='</div>';


                    $data_arr[] = array(//
                        "id" => $record->id,
                        "category" => $record->category,
                        "appid" => $record->appid,
                        "icon" => '<img class="rounded mx-auto d-block" width="100px" height="100px" src="'.$record->icon.'">',
                        "screenshot" =>'<p class="bold">'.$record->title.'</p>'.$data,
                        "description" => '<button type="button" class="btn waves-effect button" style="text-align: left">' .$record->description.'</button>' ,
                        "action"=> $btn,
                    );
                }
                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                    "aaData" => $data_arr,
                );

                return json_encode($response);
            }
        }
    }

    public function delete($id){
        $apk = Apk_Process::find($id);
        $apk->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function update_pss($id){
        $apk = Apk_Process::find($id);
        $apk->pss_console = 1;
        $apk->save();
        return response()->json(['success'=>'Cập nhật thành công.']);
    }
}
