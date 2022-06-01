<?php

namespace App\Http\Controllers;

use App\Models\Apk_Process;
use App\Models\Market_category;

use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

//use Elastica\Client as ElaticaClient;



class Apk_ProcessController extends Controller

{



//    public function __construct()
//    {
//        $this->elasticsearch = ClientBuilder::create()->build();
//        $elasticaConfig = [
//            'host' => 'localhost',
//            'port' => 9200,
//            'index' => 'apk_process',
//        ];
//        $this->elastica = new ElaticaClient($elasticaConfig);
//    }

    public function index(Request $request,$id,$cate_id){
//        dd($request->all());
        $categories = Market_category::where('type',$id)->get()->toArray();
        $apk_process = Apk_Process::where('category',array_rand($categories))->paginate(10);
        if(isset($request->cate_id)){
            $apk_process = Apk_Process::where('category',$request->cate_id)->paginate(10);
        }

        return view('apk_process.index',compact(['categories','apk_process']));
    }

    public function getIndex(Request $request){

        if (isset($request->id)){
            {
//                dd($request->all());
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
                $totalRecords = Apk_Process::select('count(*) as allcount')->where('category',$request->id )->count();
                $totalRecordswithFilter =Apk_Process::search($searchValue)
                    ->where('category',$request->id)
                    ->get()
                    ->count();

//                 Get records, also we have included search filter as well
//                $records = Apk_Process::orderBy($columnName, $columnSortOrder)
//                    ->where('category',$request->id )
//                    ->where('appid', 'like', '%' . $searchValue . '%')
//                    ->skip($start)
//                    ->take($rowperpage)
//                    ->get();



                $records = Apk_Process::search($searchValue)
                    ->orderBy($columnName, $columnSortOrder)
                    ->where('category',$request->id)
//                    ->take($rowperpage)
//                    ->get();
                    ->paginate(10);
//                dd($records);

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
                        $data .=  '<img class="rounded mr-2 mo-mb-2" alt="200x200" min-width="200px" height="100px" src="'.$screenshot.'" data-holder-rendered="true">';
                    }
                    $data .='</div>';


                    $data_arr[] = array(//
                        "id" => $record->id,
                        "category" => $record->category,
                        "appid" => $record->appid,
                        "icon" => '<img class="rounded mx-auto d-block" height="100px" src="'.$record->icon.'">',
                        "screenshot" =>'<p class="bold">'.$record->title.'</p>'.$data,
                        "description" => '<button type="button" class="btn waves-effect button" style="text-align: left">' .substr($record->description,0,50).'... </button>' ,
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
