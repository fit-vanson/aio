<?php

namespace App\Http\Controllers;

use App\Models\Dev;
use App\Models\ProjectModel;
use App\Models\Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class TemplateController extends Controller
{
    public function index(){
        return view('template.index');
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
        $totalRecords = Template::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Template::select('count(*) as allcount')
            ->where('template', 'like', '%' . $searchValue . '%')
            ->orWhere('ver_build', 'like', '%' . $searchValue . '%')
            ->orWhere('Chplay_category', 'like', '%' . $searchValue . '%')
            ->orWhere('Amazon_category', 'like', '%' . $searchValue . '%')
            ->orWhere('Samsung_category', 'like', '%' . $searchValue . '%')
            ->orWhere('Xiaomi_category', 'like', '%' . $searchValue . '%')
            ->orWhere('Oppo_category', 'like', '%' . $searchValue . '%')
            ->orWhere('Vivo_category', 'like', '%' . $searchValue . '%')
            ->count();


        // Get records, also we have included search filter as well
        $records = Template::orderBy($columnName, $columnSortOrder)
            ->where('template', 'like', '%' . $searchValue . '%')
            ->orWhere('ver_build', 'like', '%' . $searchValue . '%')
            ->orWhere('Chplay_category', 'like', '%' . $searchValue . '%')
            ->orWhere('Amazon_category', 'like', '%' . $searchValue . '%')
            ->orWhere('Samsung_category', 'like', '%' . $searchValue . '%')
            ->orWhere('Xiaomi_category', 'like', '%' . $searchValue . '%')
            ->orWhere('Oppo_category', 'like', '%' . $searchValue . '%')
            ->orWhere('Vivo_category', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editTemplate('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Check" class="btn btn-info checkDataTemplate"><i class="ti-file"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteTemplate"><i class="ti-trash"></i></a>';


            $project = DB::table('ngocphandang_template')
                ->join('ngocphandang_project','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_project.template',$record->id)
                ->count();

            $template = '<a href="javascript:void(0)" onclick="showProject('.$record->id.')"> <span>'.$record->template.' - ('.$project.')</span></a>
                            <p class="text-muted" style="margin: 0">'.$record->ver_build.'</p>
                            <p class="text-muted" style="margin: 0">'.$record->template_name.'</p>';


            if($record['script_copy'] !== Null){
                $script_copy = "<i style='color:green;' class='ti-check-box h5'></i>";
            } else {
                $script_copy = "<i style='color:red;' class='ti-close h5'></i>";
            }
            if($record['script_img'] !== Null){
                $script_img = "<i style='color:green;' class='ti-check-box h5'></i>";
            } else {
                $script_img = "<i style='color:red;' class='ti-close h5'></i>";
            }
            if($record['script_svg2xml'] !== Null){
                $script_svg2xml = "<i style='color:green;' class='ti-check-box h5'></i>";
            } else {
                $script_svg2xml = "<i style='color:red;' class='ti-close h5'></i>";
            }
            if($record['script_file'] !== Null){
                $script_file = "<i style='color:green;' class='ti-check-box h5'></i>";
            } else {
                $script_file = "<i style='color:red;' class='ti-close h5'></i>";
            }
            $script = 'Script_copy | IMG | svg2xml | File : '. $script_copy .' '. $script_img.' '. $script_svg2xml .' '.$script_file;

            $ads = json_decode($record->ads,true);

           if(!isset($ads['ads_id'])){
               $ads_id = "<i style='color:red;' class='ti-close h5'></i>";
           }else{
               $ads_id = "<i style='color:green;' class='ti-check-box h5'></i>";
           }

            if(!isset($ads['ads_banner'])){
                $ads_banner = "<i style='color:red;' class='ti-close h5'></i>";
            }else{
                $ads_banner = "<i style='color:green;' class='ti-check-box h5'></i>";
            }

            if(!isset($ads['ads_inter'])){
                $ads_inter = "<i style='color:red;' class='ti-close h5'></i>";
            }else{
                $ads_inter = "<i style='color:green;' class='ti-check-box h5'></i>";
            }

            if(!isset($ads['ads_reward'])){
                $ads_reward = "<i style='color:red;' class='ti-close h5'></i>";
            }else{
                $ads_reward = "<i style='color:green;' class='ti-check-box h5'></i>";
            }

            if(!isset($ads['ads_native'])){
                $ads_native = "<i style='color:red;' class='ti-close h5'></i>";
            }else{
                $ads_native = "<i style='color:green;' class='ti-check-box h5'></i>";
            }

            if(isset($ads['ads_open'])){
                $ads_open = "<i style='color:green;' class='ti-check-box h5'></i>";
            }else{
                $ads_open = "<i style='color:red;' class='ti-close h5'></i>";
            }
             $ads ='<br>'. 'Id | Banner | Inter | Reward | Native | Open : '. $ads_id.$ads_banner.$ads_inter.$ads_reward.$ads_native.$ads_open;


            if($record->convert_aab != 0){
                $convert_aab = '<br> Aab: '."<i style='color:green;' class='ti-check-box h5'></i>";
            }else{
                $convert_aab = '<br> Aab: '."<i style='color:red;' class='ti-close h5'></i>";
            }

            if($record->startus == 0){
                $startus = '<br> Status: '."<i style='color:green;' class='ti-check-box h5'></i>";
            }else{
                $startus = '<br> Status: '."<i style='color:red;' class='ti-close h5'></i>";
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
                "logo" => $logo,
                "template" => $template. '<br>'.$link,
                "category"=>$Chplay_category.'<br>'.$Amazon_category.'<br>'.$Samsung_category.'<br>'.$Xiaomi_category.'<br>'.$Oppo_category.'<br>'.$Vivo_category,
                "script" => $script.$ads.$convert_aab.$startus.'<br>Package: '.$record->package,
                "time_create"=> $time_create,
                "time_update"=> $time_update,
                "time_get"=> $time_get,
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
            'template' =>'unique:ngocphandang_template,template'
        ];
        $message = [
            'template.unique'=>'Tên Template đã tồn tại',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $ads = [
            'ads_id' => $request->Check_ads_id,
            'ads_banner' => $request->Check_ads_banner,
            'ads_inter' => $request->Check_ads_inter,
            'ads_reward' => $request->Check_ads_reward,
            'ads_native' => $request->Check_ads_native,
            'ads_open' => $request->Check_ads_open
        ];
        $ads =  json_encode($ads);
        $data = new Template();
        $data['template'] = $request->template;
        $data['template_name'] = $request->template_name;
        $data['ver_build'] = $request->ver_build;
        $data['script_copy'] = $request->script_copy;
        $data['script_img'] = $request->script_img;
        $data['script_svg2xml'] = $request->script_svg2xml;
        $data['script_file'] = $request->script_file;
        $data['permissions'] = $request->permissions;
        $data['policy1'] = $request->policy1;
        $data['policy2'] = $request->policy2;
        $data['time_create'] =  time();
        $data['time_update'] = time();
        $data['time_get'] = time();
        $data['note'] = $request->note;
        $data['ads'] = $ads;
        $data['package'] = $request->package;
        $data['link'] = $request->link;
        $data['convert_aab'] = $request->convert_aab;
        $data['startus'] = $request->startus;
        $data['link_store_vietmmo'] = $request->link_store_vietmmo;
        $data['Chplay_category'] =  $request->Chplay_category;
        $data['Amazon_category'] =  $request->Amazon_category;
        $data['Samsung_category'] =  $request->Samsung_category;
        $data['Xiaomi_category'] =  $request->Xiaomi_category;
        $data['Oppo_category'] =  $request->Oppo_category;
        $data['Vivo_category'] =  $request->Vivo_category;

        if(isset($request->logo)){
            $image = $request->file('logo');
            $data['logo'] = 'logo_'.time().'.'.$image->extension();
            $destinationPath = public_path('uploads/template/'.$request->template.'/thumbnail/');
            $img = Image::make($image->path());
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 777, true);
            }
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.$data['logo']);
            $destinationPath = public_path('uploads/template/'.$request->template);
            $image->move($destinationPath, $data['logo']);
        }

        $data->save();
        $allTemp  = Template::latest('id')->get();
        return response()->json([
            'success'=>'Thêm mới thành công',
            'temp' => $allTemp

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
        $temp = Template::find($id);
        return response()->json($temp);
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
        $id = $request->template_id;
        $rules = [
            'template' =>'unique:ngocphandang_template,template,'.$id.',id',
        ];
        $message = [
            'template.unique'=>'Tên template đã tồn tại',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $ads = [
            'ads_id' => $request->Check_ads_id,
            'ads_banner' => $request->Check_ads_banner,
            'ads_inter' => $request->Check_ads_inter,
            'ads_reward' => $request->Check_ads_reward,
            'ads_native' => $request->Check_ads_native,
            'ads_open' => $request->Check_ads_open
        ];

        $ads =  json_encode($ads);
        $data = Template::find($id);

        $data->ver_build = $request->ver_build;
        $data->script_copy = $request->script_copy;
        $data->script_img= $request->script_img;
        $data->script_svg2xml = $request->script_svg2xml;
        $data->script_file = $request->script_file;
        $data->permissions = $request->permissions;
        $data->policy1 = $request->policy1;
        $data->policy2 = $request->policy2;
        $data->time_update = time();
        $data->note = $request->note;
        $data->ads = $ads;
        $data->package = $request->package;
        $data->link = $request->link;
        $data->convert_aab = $request->convert_aab;
        $data->startus = $request->startus;
        $data->link_store_vietmmo = $request->link_store_vietmmo;
        $data->Chplay_category =  $request->Chplay_category;
        $data->Amazon_category =  $request->Amazon_category;
        $data->Samsung_category =  $request->Samsung_category;
        $data->Xiaomi_category =  $request->Xiaomi_category;
        $data->Oppo_category =  $request->Oppo_category;
        $data->Vivo_category =  $request->Vivo_category;

        if($data->logo){
            if($data->template <> $request->template){
                $dir = (public_path('uploads/template/'));
                rename($dir.$data->template, $dir.$request->template);
            }
        }
        if($request->logo){
            $image = $request->file('logo');
            $data['logo'] = 'logo_'.time().'.'.$image->extension();
            $destinationPath = public_path('uploads/template/'.$request->template.'/thumbnail/');
            $img = Image::make($image->path());
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 777, true);
            }
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.$data['logo']);
            $destinationPath = public_path('uploads/template/'.$request->template);
            $image->move($destinationPath, $data['logo']);
        }
        $data->template = $request->template;
        $data->template_name = $request->template_name;

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
        Template::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }

}
