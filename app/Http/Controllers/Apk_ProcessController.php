<?php

namespace App\Http\Controllers;

use App\Models\Apk_Process;
use App\Models\Market_category;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use Elastica\Client as ElaticaClient;



class Apk_ProcessController extends Controller

{

    public function index(Request $request,$id,$cate_id){
        if (isset($id)){
            $categories = Market_category::where('type',$id)->get()->toArray();
            $apk_process = Apk_Process::where('category',array_rand($categories))->paginate(10);
            if(isset($request->cate_id)){
                $apk_process = Apk_Process::where('category',$request->cate_id)->paginate(10);
            }

            return view('apk_process.index',compact(['categories','apk_process']));
        }else{
            return view('apk_process.index');
        }
    }

    public function success(){
        return view('apk_process.success');
    }

    public function getIndex(Request $request)
    {
        ini_set('max_execution_time', -1);

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // total number of rows per page
//
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
        $totalRecordswithFilter =Apk_Process::select('count(*) as allcount')->where('pss_console','<>',0 )->count();

//        $records = Apk_Process::orderBy($columnName, $columnSortOrder)
////                ->where('pss_console','<>',0 )
//            ->skip($start)
//            ->take($rowperpage)
//            ->get();
////                ->paginate(25);
//
//
//
//        foreach ($records as $record)
//        {
//            $data_arr = array();
//            $pss_console = $record->pss_console;
//            if ($pss_console != 0) {
//                $ads = json_decode($record->pss_ads,true);
//
//                $data_arr[] = array(
//                    "id" => $record->id,
//                    "appid" => $record->appid,
//                    "pss_ads->Admob" => $record->pss_ads ? $ads['Admob'] : '',
//                    "pss_ads->Facebook" =>  $record->pss_ads ? $ads['Facebook'] : '',
//                    "pss_ads->StartApp" => $record->pss_ads ? $ads['StartApp'] :'',
//                    "pss_ads->Huawei" => $record->pss_ads ?$ads['Huawei']  : '',
//                    "pss_ads->Iron" => $record->pss_ads ? $ads['Iron'] : '',
//                    "pss_ads->Applovin" =>  $record->pss_ads ? $ads['Applovin'] :'',
//                    "pss_ads->Appbrain" => $record->pss_ads ?$ads['Appbrain']:'',
//                    "pss_ads->Unity3d" => $record->pss_ads ?  $ads['Unity3d'] :''
//                );
//            }
//        }
//        echo "<pre>";
//        print_r($data_arr);
//        echo "</pre>";
//
//        dd($data_arr);
//
//        $regions = array();
        $data_arr = array();

        Apk_Process::chunk(1000, function($records) use (&$data_arr ) {
            foreach ($records as $record)
            {
                $pss_console = $record->pss_console;
                if ($pss_console != 0){
                    $ads = json_decode($record->pss_ads,true);
                    $data_arr[] = array(
                        "id" => $record->id,
                        'pss_console' => $record->pss_console,
                        "appid" => $record->appid,
                        "pss_ads->Admob" => $record->pss_ads ? $ads['Admob'] ?  '<span class="badge badge-success"><i class="mdi mdi-check"></i></span>':  '<span class="badge badge-danger"><i class="mdi mdi-close"></i></span>' : '',
                        "pss_ads->Facebook" =>  $record->pss_ads ? $ads['Facebook']  ?  '<span class="badge badge-success"><i class="mdi mdi-check"></i></span>':  '<span class="badge badge-danger"><i class="mdi mdi-close"></i></span>' : '',
                        "pss_ads->StartApp" => $record->pss_ads ? $ads['StartApp']  ?  '<span class="badge badge-success"><i class="mdi mdi-check"></i></span>':  '<span class="badge badge-danger"><i class="mdi mdi-close"></i></span>' : '',
                        "pss_ads->Huawei" => $record->pss_ads ?$ads['Huawei']   ?  '<span class="badge badge-success"><i class="mdi mdi-check"></i></span>':  '<span class="badge badge-danger"><i class="mdi mdi-close"></i></span>' : '',
                        "pss_ads->Iron" => $record->pss_ads ? $ads['Iron'] ?  '<span class="badge badge-success"><i class="mdi mdi-check"></i></span>':  '<span class="badge badge-danger"><i class="mdi mdi-close"></i></span>' : '',
                        "pss_ads->Applovin" =>  $record->pss_ads ? $ads['Applovin'] ?  '<span class="badge badge-success"><i class="mdi mdi-check"></i></span>':  '<span class="badge badge-danger"><i class="mdi mdi-close"></i></span>' : '',
                        "pss_ads->Appbrain" => $record->pss_ads ?$ads['Appbrain'] ?  '<span class="badge badge-success"><i class="mdi mdi-check"></i></span>':  '<span class="badge badge-danger"><i class="mdi mdi-close"></i></span>' : '',
                        "pss_ads->Unity3d" => $record->pss_ads ?  $ads['Unity3d']  ?  '<span class="badge badge-success"><i class="mdi mdi-check"></i></span>':  '<span class="badge badge-danger"><i class="mdi mdi-close"></i></span>' : '',
                    );
                }
            }
            return $data_arr;
        });
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );
        return json_encode($response);
    }


    public function delete($type, $cate, $id){
        $apk = Apk_Process::find($id);
        $apk->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function update_pss($type, $cate,$id){
        $apk = Apk_Process::find($id);
        $apk->pss_console = 1;
        $apk->save();
        return response()->json(['success'=>'Cập nhật thành công.']);
    }
}
