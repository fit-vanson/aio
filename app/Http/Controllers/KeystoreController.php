<?php

namespace App\Http\Controllers;

use App\Models\Dev;
use App\Models\ProjectModel;
use App\Models\Keystore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class KeystoreController extends Controller
{
    public function index(){
        return view('keystore.index');
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
        $totalRecords = Keystore::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Keystore::select('count(*) as allcount')
            ->where('name_keystore', 'like', '%' . $searchValue . '%')
            ->orwhere('pass_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('aliases_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('SHA_256_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('note', 'like', '%' . $searchValue . '%')
            ->count();


        // Get records, also we have included search filter as well
        $records = Keystore::orderBy($columnName, $columnSortOrder)
            ->where('name_keystore', 'like', '%' . $searchValue . '%')
            ->orwhere('pass_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('aliases_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('SHA_256_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('note', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editKeytore('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteKeystore"><i class="ti-trash"></i></a>';


            $project = DB::table('ngocphandang_keystores')
                ->join('ngocphandang_project','ngocphandang_keystores.id','=','ngocphandang_project.buildinfo_keystore')
                ->where('ngocphandang_project.buildinfo_keystore',$record->id)
                ->count();

            $template = '<p style="margin: 0"><b>'.$record->template_name.'</b></p>
                            <a href="javascript:void(0)" onclick="showProject('.$record->id.')"> <span>'.$record->template.' - ('.$project.')</span></a>
                            <p class="text-muted" style="margin: 0">'.$record->ver_build.'</p>';


            if($record['script_copy'] !== Null){
                $script_copy = "<span style='color:green;'> Script_copy</span> - ";
            } else {
                $script_copy = "<span style='color:red;'> Script_copy</span> - ";
            }
            if($record['script_img'] !== Null){
                $script_img = "<span style='color:green;'> IMG</span> - ";
            } else {
                $script_img = "<span style='color:red;'> IMG</span> - ";
            }
            if($record['script_svg2xml'] !== Null){
                $script_svg2xml = "<span style='color:green;'> svg2xml</span> - ";
            } else {
                $script_svg2xml = "<span style='color:red;'> svg2xml</span> - ";
            }
            if($record['script_file'] !== Null){
                $script_file = "<span style='color:green;'> File</span>";
            } else {
                $script_file = "<span style='color:red;'> File</span>";
            }
            $script = $script_copy . $script_img. $script_svg2xml .$script_file;

            $ads = json_decode($record->ads,true);

            if(isset($ads['ads_id'])){
                $ads_id = "<span style='color:green;'> Id</span> - ";
            }else{
                $ads_id = "<span style='color:red;'> Id</span> - ";
            }

            if(isset($ads['ads_banner'])){
                $ads_banner = "<span style='color:green;'> Banner</span> - ";
            }else{
                $ads_banner = "<span style='color:red;'> Banner</span> - ";
            }

            if(isset($ads['ads_inter'])){
                $ads_inter = "<span style='color:green;'> Inter</span> - ";
            }else{
                $ads_inter = "<span style='color:red;'> Inter</span> - ";
            }

            if(isset($ads['ads_reward'])){
                $ads_reward = "<span style='color:green;'> Reward</span> - ";
            }else{
                $ads_reward = "<span style='color:red;'> Reward</span> - ";
            }

            if(isset($ads['ads_native'])){
                $ads_native = "<span style='color:green;'> Native</span> - ";
            }else{
                $ads_native = "<span style='color:red;'> Native</span> - ";
            }

            if(isset($ads['ads_open'])){
                $ads_open = "<span style='color:green;'> Open</span> - ";
            }else{
                $ads_open = "<span style='color:red;'> Open</span> - ";
            }

            if(isset($ads['ads_start'])){
                $ads_start = "<span style='color:green;'> Start</span>";
            }else{
                $ads_start = "<span style='color:red;'> Start</span>";
            }
            $ads ='<br>'.$ads_id.$ads_banner.$ads_inter.$ads_reward.$ads_native.$ads_open.$ads_start;


            if($record->convert_aab != 0){
                $convert_aab = '<br>'. "<span style='color:green;'> Aab</span>";
            }else{
                $convert_aab = '<br>'. "<span style='color:red;'> Aab</span>";
            }

            if($record->startus == 0){
                $startus = '<br>'. "<span style='color:green;'> Status</span>";
            }else{
                $startus = '<br>'. "<span style='color:red;'> Status</span>";
            }

            if($record->time_create == 0 ){
                $time_create =   null;
            }else{
                $time_create =  date( 'd/m/Y',$record->time_create);
            }

            if($record->time_update == 0 ){
                $time_update =   null;
            }else{
                $time_update =  date( 'd/m/Y',$record->time_update);
            }

            if($record->time_get == 0 ){
                $time_get =   null;
            }else{
                $time_get =  date( 'd/m/Y',$record->time_get);
            }
            if(isset($record->Chplay_category)){
                $Chplay_category = 'CH Play: '.$record->Chplay_category;
            }else{
                $Chplay_category ='';
            }

            if(isset($record->Amazon_category)){
                $Amazon_category = 'Amazon: '.$record->Amazon_category;
            }else{
                $Amazon_category ='';
            }

            if(isset($record->Samsung_category)){
                $Samsung_category = 'Samsung: '.$record->Samsung_category;
            }else{
                $Samsung_category ='';
            }

            if(isset($record->Xiaomi_category)){
                $Xiaomi_category = 'Xiaomi: '.$record->Xiaomi_category;
            }else{
                $Xiaomi_category ='';
            }

            if(isset($record->Oppo_category)){
                $Oppo_category = 'Oppo: '.$record->Oppo_category;
            }else{
                $Oppo_category ='';
            }

            if(isset($record->Vivo_category)){
                $Vivo_category = 'Vivo: '.$record->Vivo_category;
            }else{
                $Vivo_category ='';
            }

            if(isset($record->Huawei_category)){
                $Huawei_category = 'Huawei: '.$record->Huawei_category;
            }else{
                $Huawei_category ='';
            }


            if ($record->link_chplay !== null){
                $link= "<a  target= _blank href='$record->link_chplay'>Link</a>";
            }
            else{
                $link = null;
            }

            if(isset($record->logo)){
                if (isset($record->link_store_vietmmo)){
                    $logo = "<a href='".$record->link_store_vietmmo."' target='_blank'>  <img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/template/$record->template/thumbnail/$record->logo'></a>";
                }else{
                    $logo = "<img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/template/$record->template/thumbnail/$record->logo'>";
                }
            }else{
                $logo = '<img class="rounded mx-auto d-block" width="100px" height="100px" src="assets\images\logo-sm.png">';
            }

            $data_arr[] = array(
                "name_keystore" => $record->name_keystore,
                "pass_keystore" => $record->pass_keystore,
                "aliases_keystore" => $record->aliases_keystore,
                "SHA_256_keystore" => $record->SHA_256_keystore,
                "note"=> $record->note,
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
            'name_keystore' =>'unique:ngocphandang_keystores,name_keystore'
        ];
        $message = [
            'name_keystore.unique'=>'Tên Keystore đã tồn tại',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }

        $data = new Keystore();
        $data['name_keystore'] = $request->name_keystore;
        $data['pass_keystore'] = $request->pass_keystore;
        $data['aliases_keystore'] = $request->aliases_keystore;
        $data['SHA_256_keystore'] = $request->SHA_256_keystore;
        $data['note'] = $request->note;

        $data->save();
        $allKeys  = Keystore::latest('id')->get();
        return response()->json([
            'success'=>'Thêm mới thành công',
            'keys' => $allKeys

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
        $keystore = Keystore::find($id);
        return response()->json($keystore);
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
        $id = $request->keystore_id;
        $rules = [
            'name_keystore' =>'unique:ngocphandang_keystores,name_keystore,'.$id.',id',
        ];
        $message = [
            'name_keystore.unique'=>'Tên Keystore đã tồn tại',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }

        $data = Keystore::find($id);

        $data->name_keystore = $request->name_keystore;
        $data->pass_keystore = $request->pass_keystore;
        $data->aliases_keystore= $request->aliases_keystore;
        $data->SHA_256_keystore = $request->SHA_256_keystore;
        $data->note = $request->note;

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
        Keystore::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }

}
