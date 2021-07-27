<?php

namespace App\Http\Controllers;

use App\Models\Da;
use App\Models\Dev;

use App\Models\ProjectModel;
use App\Models\ProjectModel2;
use App\Models\Template;

use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use voku\helper\HtmlDomParser;
use voku\helper\SimpleHtmlDomNode;
use Yajra\DataTables\Facades\DataTables;
use function simplehtmldom_1_5\file_get_html;


class ProjectController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $da =  Da::latest('id')->get();
        $template =  Template::latest('id')->get();
        $store_name=  Dev::latest('id')->get();
//        return view('mailparent.index');
//        return view('project.index2');
        return view('project.index2',compact(['template','da','store_name']));
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
        $totalRecords = ProjectModel2::select('count(*) as allcount')->count();
        $totalRecordswithFilter = ProjectModel2::select('count(*) as allcount')
            ->where('ma_da', 'like', '%' . $searchValue . '%')
            ->orWhere('projectname', 'like', '%' . $searchValue . '%')
            ->orWhere('title_app', 'like', '%' . $searchValue . '%')
            ->orWhere('template', 'like', '%' . $searchValue . '%')
            ->orWhere('Chplay_package', 'like', '%' . $searchValue . '%')
            ->orWhere('Amazon_package', 'like', '%' . $searchValue . '%')
            ->orWhere('Samsung_package', 'like', '%' . $searchValue . '%')
            ->orWhere('Xiaomi_package', 'like', '%' . $searchValue . '%')
            ->orWhere('Oppo_package', 'like', '%' . $searchValue . '%')
            ->orWhere('Vivo_package', 'like', '%' . $searchValue . '%')
            ->count();

        // Get records, also we have included search filter as well
        $records = ProjectModel2::orderBy($columnName, $columnSortOrder)
            ->where('ma_da', 'like', '%' . $searchValue . '%')
            ->orWhere('projectname', 'like', '%' . $searchValue . '%')
            ->orWhere('title_app', 'like', '%' . $searchValue . '%')
            ->orWhere('template', 'like', '%' . $searchValue . '%')
            ->orWhere('Chplay_package', 'like', '%' . $searchValue . '%')
            ->orWhere('Amazon_package', 'like', '%' . $searchValue . '%')
            ->orWhere('Samsung_package', 'like', '%' . $searchValue . '%')
            ->orWhere('Xiaomi_package', 'like', '%' . $searchValue . '%')
            ->orWhere('Oppo_package', 'like', '%' . $searchValue . '%')
            ->orWhere('Vivo_package', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editProject('.$record->projectid.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn. ' <a href="javascript:void(0)" onclick="quickEditProject('.$record->projectid.')" class="btn btn-success"><i class="mdi mdi-android-head"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->projectid.'" data-original-title="Delete" class="btn btn-danger deleteProject"><i class="ti-trash"></i></a>';

            $ma_da = DB::table('ngocphandang_project')
                ->join('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->where('ngocphandang_da.id',$record->ma_da)
                ->first();
            $template = DB::table('ngocphandang_project')
                ->join('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_template.id',$record->template)
                ->first();
            if($ma_da != null) {
                $data_ma_da =
                    '<span style="line-height:3">' . $ma_da->ma_da . '</span>';
            }else{
                $data_ma_da = '';
            }
            if(isset($template)) {
                $data_template =  '<p class="text-muted" style="line-height:0.5">'.$template->template.'</p>';
            }else{
                $data_template='';
            }

            if($record->projectname != null) {
                $data_projectname =  '<p class="text-muted" style="line-height:0.5">'.$record->projectname.'</p>';
            }else{
                $data_projectname='';
            }

            if($record->title_app != null) {
                $data_title_app=  '<p class="text-muted" style="line-height:0.5">'.$record->title_app.'</p>';
            }else{
                $data_title_app='';
            }

            if(isset($record->Chplay_ads)){
                $package_chplay = '<p style="color:green;line-height:0.5">CH Play: '.$record->Chplay_package.'</p>';
            }else{
                $package_chplay = '<p style="color:red;line-height:0.5">CH Play: '.$record->Chplay_package.'</p>';
            }

            if(isset($record->Amazon_ads)){
                $package_amazon = '<p  style="color:green;line-height:0.5">Amazon: '.$record->Amazon_package.'</p>';
            }else{
                $package_amazon = '<p style="color:red;line-height:0.5">Amazon: '.$record->Amazon_package.'</p>';
            }

            if(isset($record->Samsung_ads)){
                $package_samsung = '<p style="color:green;line-height:0.5">SamSung: '.$record->Samsung_package.'</p>';
            }else{
                $package_samsung = '<p style="color:red;line-height:0.5">SamSung: '.$record->Samsung_package.'</p>';
            }

            if(isset($record->Xiaomi_ads)){
                $package_xiaomi = '<p style="color:green;line-height:0.5">Xiaomi: '.$record->Xiaomi_package.'</p>';
            }else{
                $package_xiaomi = '<p style="color:red;line-height:0.5">Xiaomi: '.$record->Xiaomi_package.'</p>';
            }



            if(isset($record->Oppo_ads)){
                $package_oppo = '<p style="color:green;line-height:0.5">Oppo: '.$record->Oppo_package.'</p>';
            }else{
                $package_oppo = '<p style="color:red;line-height:0.5">Oppo: '.$record->Oppo_package.'</p>';
            }

            if(isset($record->Vivo_ads)){
                $package_vivo = '<p style="color:green;line-height:0.5">Vivo: '.$record->Vivo_package.'</p>';
            }else{
                $package_vivo = '<p style="color:red;line-height:0.5">Vivo: '.$record->Vivo_package.'</p>';
            }


            if ($record['Chplay_status']==0  ) {
                $Chplay_status = 'Mặc định';
            }
            elseif($record['Chplay_status']== 1){
                $Chplay_status = '<span class="badge badge-dark">Publish</span>';

            }
            elseif($record['Chplay_status']==2){
                $Chplay_status =  '<span class="badge badge-warning">Suppend</span>';
            }
            elseif($record['Chplay_status']==3){
                $Chplay_status =  '<span class="badge badge-info">UnPublish</span>';
            }
            elseif($record['Chplay_status']==4){
                $Chplay_status =  '<span class="badge badge-primary">Remove</span>';
            }
            elseif($record['Chplay_status']==5){
                $Chplay_status =  '<span class="badge badge-success">Reject</span>';
            }
            elseif($record['Chplay_status']==6){
                $Chplay_status =  '<span class="badge badge-danger">Check</span>';
            }
            if ($record['Amazon_status']==0  ) {
                $Amazon_status = 'Mặc định';
            }
            elseif($record['Amazon_status']== 1){
                $Amazon_status = '<span class="badge badge-dark">Publish</span>';

            }
            elseif($record['Amazon_status']==2){
                $Amazon_status =  '<span class="badge badge-warning">Suppend</span>';
            }
            elseif($record['Amazon_status']==3){
                $Amazon_status =  '<span class="badge badge-info">UnPublish</span>';
            }
            elseif($record['Amazon_status']==4){
                $Amazon_status =  '<span class="badge badge-primary">Remove</span>';
            }
            elseif($record['Amazon_status']==5){
                $Amazon_status =  '<span class="badge badge-success">Reject</span>';
            }
            elseif($record['Amazon_status']==6){
                $Amazon_status =  '<span class="badge badge-danger">Check</span>';
            }

            if ($record['Samsung_status']==0  ) {
                $Samsung_status = 'Mặc định';
            }
            elseif($record['Samsung_status']== 1){
                $Samsung_status = '<span class="badge badge-dark">Publish</span>';

            }
            elseif($record['Samsung_status']==2){
                $Samsung_status =  '<span class="badge badge-warning">Suppend</span>';
            }
            elseif($record['Samsung_status']==3){
                $Samsung_status =  '<span class="badge badge-info">UnPublish</span>';
            }
            elseif($record['Samsung_status']==4){
                $Samsung_status =  '<span class="badge badge-primary">Remove</span>';
            }
            elseif($record['Samsung_status']==5){
                $Samsung_status =  '<span class="badge badge-success">Reject</span>';
            }
            elseif($record['Samsung_status']==6){
                $Samsung_status =  '<span class="badge badge-danger">Check</span>';
            }

            if ($record['Xiaomi_status']==0  ) {
                $Xiaomi_status = 'Mặc định';
            }
            elseif($record['Xiaomi_status']== 1){
                $Xiaomi_status = '<span class="badge badge-dark">Publish</span>';

            }
            elseif($record['Xiaomi_status']==2){
                $Xiaomi_status =  '<span class="badge badge-warning">Suppend</span>';
            }
            elseif($record['Xiaomi_status']==3){
                $Xiaomi_status =  '<span class="badge badge-info">UnPublish</span>';
            }
            elseif($record['Xiaomi_status']==4){
                $Xiaomi_status =  '<span class="badge badge-primary">Remove</span>';
            }
            elseif($record['Xiaomi_status']==5){
                $Xiaomi_status =  '<span class="badge badge-success">Reject</span>';
            }
            elseif($record['Xiaomi_status']==6){
                $Xiaomi_status =  '<span class="badge badge-danger">Check</span>';
            }


            if ($record['Oppo_status']==0  ) {
                $Oppo_status = 'Mặc định';
            }
            elseif($record['Oppo_status']== 1){
                $Oppo_status = '<span class="badge badge-dark">Publish</span>';

            }
            elseif($record['Oppo_status']==2){
                $Oppo_status =  '<span class="badge badge-warning">Suppend</span>';
            }
            elseif($record['Oppo_status']==3){
                $Oppo_status =  '<span class="badge badge-info">UnPublish</span>';
            }
            elseif($record['Oppo_status']==4){
                $Oppo_status =  '<span class="badge badge-primary">Remove</span>';
            }
            elseif($record['Oppo_status']==5){
                $Oppo_status =  '<span class="badge badge-success">Reject</span>';
            }
            elseif($record['Oppo_status']==6){
                $Oppo_status =  '<span class="badge badge-danger">Check</span>';
            }

            if ($record['Vivo_status']==0  ) {
                $Vivo_status = 'Mặc định';
            }
            elseif($record['Vivo_status']== 1){
                $Vivo_status = '<span class="badge badge-dark">Publish</span>';

            }
            elseif($record['Vivo_status']==2){
                $Vivo_status =  '<span class="badge badge-warning">Suppend</span>';
            }
            elseif($record['Vivo_status']==3){
                $Vivo_status =  '<span class="badge badge-info">UnPublish</span>';
            }
            elseif($record['Vivo_status']==4){
                $Vivo_status =  '<span class="badge badge-primary">Remove</span>';
            }
            elseif($record['Vivo_status']==5){
                $Vivo_status =  '<span class="badge badge-success">Reject</span>';
            }
            elseif($record['Vivo_status']==6){
                $Vivo_status =  '<span class="badge badge-danger">Check</span>';
            }

            $policy = DB::table('ngocphandang_project2')
                ->join('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project2.template')
                ->where('ngocphandang_template.id',$record->template)
                ->first();
            if(isset($policy->policy1) || isset($policy->policy2)){
                $policy = ' <a href="javascript:void(0)" onclick="showPolicy('.$record->projectid.')"><span class="badge badge-primary">Policy</span></a>';
            }else{
                $policy = '';
            }
            $status =  $policy.'<br> CH Play: '.$Chplay_status.'<br> Amazon: '.$Amazon_status.'<br> SamSung: '.$Samsung_status.'<br> Xiaomi: '.$Xiaomi_status.'<br> Oppo: '.$Oppo_status.'<br> Vivo: '.$Vivo_status;

            if(isset($record->logo)){
                $logo = ' ádj';
            }else{
                $logo = '<img width="60px" height="60px" src="assets\images\logo-sm.png">';
            }

            $data_arr[] = array(
                "logo" => $logo,
                "ma_da"=>$data_ma_da.$data_template.$data_projectname.$data_title_app,
                "package" => $package_chplay.$package_amazon.$package_samsung.$package_xiaomi.$package_oppo.$package_vivo,
                "status" => $status,
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        $rules = [
            'projectname' =>'required|unique:ngocphandang_project,projectname',
            'ma_da' => 'required',
            'template' => 'required',
            'title_app' =>'required',
            'buildinfo_vernum' =>'required',
            'buildinfo_verstr' =>'required',
        ];
        $message = [
            'projectname.unique'=>'Tên Project đã tồn tại',
            'projectname.required'=>'Tên Project không để trống',
            'ma_da.required'=>'Mã dự án không để trống',
            'template.required'=>'Mã template không để trống',
            'title_app.required'=>'Tiêu đề ứng không để trống',
            'buildinfo_vernum.required'=>'Version Number không để trống',
            'buildinfo_verstr.required'=>'Version String không để trống',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new ProjectModel2();
        $data['projectname'] = $request->projectname;
        $data['template'] = $request->template;
        $data['ma_da'] = $request->ma_da;
        $data['title_app'] = $request->title_app;
        $data['buildinfo_app_name_x'] =  $request->buildinfo_app_name_x;
        $data['buildinfo_link_policy_x'] = $request->buildinfo_link_policy_x;
        $data['buildinfo_link_fanpage'] = $request->buildinfo_link_fanpage;
        $data['buildinfo_link_website'] =  $request->buildinfo_link_website;
        $data['buildinfo_link_youtube_x'] = $request->buildinfo_link_youtube_x;
        $data['buildinfo_api_key_x'] = $request->buildinfo_api_key_x;
        $data['buildinfo_console'] = 0;
        $data['buildinfo_vernum' ]= $request->buildinfo_vernum;
        $data['buildinfo_verstr'] = $request->buildinfo_verstr;
        $data['buildinfo_keystore'] = $request->buildinfo_keystore;
        $data['buildinfo_sdk'] = $request->buildinfo_sdk;

        $data['Chplay_package'] = $request->Chplay_package;
        $data['Chplay_buildinfo_store_name_x'] = $request->Chplay_buildinfo_store_name_x;
        $data['Chplay_buildinfo_link_store'] = $request->Chplay_buildinfo_link_store;
        $data['Chplay_buildinfo_email_dev_x'] = $request->Chplay_buildinfo_email_dev_x;
        $data['Chplay_buildinfo_link_app'] = $request->Chplay_buildinfo_link_app;
        $data['Chplay_ads'] = $request->Chplay_ads;
        $data['Chplay_status'] = $request->Chplay_status;

        $data['Amazon_package'] = $request->Amazon_package;
        $data['Amazon_buildinfo_store_name_x'] = $request->Amazon_buildinfo_store_name_x;
        $data['Amazon_buildinfo_link_store'] = $request->Amazon_buildinfo_link_store;
        $data['Amazon_buildinfo_email_dev_x'] = $request->Amazon_buildinfo_email_dev_x;
        $data['Amazon_buildinfo_link_app'] = $request->Amazon_buildinfo_link_app;
        $data['Amazon_ads'] = $request->Amazon_ads;
        $data['Amazon_status'] = $request->Amazon_status;

        $data['Samsung_package'] = $request->Samsung_package;
        $data['Samsung_buildinfo_store_name_x'] = $request->Samsung_buildinfo_store_name_x;
        $data['Samsung_buildinfo_link_store'] = $request->Samsung_buildinfo_link_store;
        $data['Samsung_buildinfo_email_dev_x'] = $request->Samsung_buildinfo_email_dev_x;
        $data['Samsung_buildinfo_link_app'] = $request->Samsung_buildinfo_link_app;
        $data['Samsung_ads'] = $request->Samsung_ads;
        $data['Samsung_status'] = $request->Samsung_status;

        $data['Xiaomi_package'] = $request->Xiaomi_package;
        $data['Xiaomi_buildinfo_store_name_x'] = $request->Xiaomi_buildinfo_store_name_x;
        $data['Xiaomi_buildinfo_link_store'] = $request->Xiaomi_buildinfo_link_store;
        $data['Xiaomi_buildinfo_email_dev_x'] = $request->Xiaomi_buildinfo_email_dev_x;
        $data['Xiaomi_buildinfo_link_app'] = $request->Xiaomi_buildinfo_link_app;
        $data['Xiaomi_ads'] = $request->Xiaomi_ads;
        $data['Xiaomi_status'] = $request->Xiaomi_status;

        $data['Oppo_package'] = $request->Oppo_package;
        $data['Oppo_buildinfo_store_name_x'] = $request->Oppo_buildinfo_store_name_x;
        $data['Oppo_buildinfo_link_store'] = $request->Oppo_buildinfo_link_store;
        $data['Oppo_buildinfo_email_dev_x'] = $request->Oppo_buildinfo_email_dev_x;
        $data['Oppo_buildinfo_link_app'] = $request->Oppo_buildinfo_link_app;
        $data['Oppo_ads'] = $request->Oppo_ads;
        $data['Oppo_status'] = $request->Oppo_status;

        $data['Vivo_package'] = $request->Vivo_package;
        $data['Vivo_buildinfo_store_name_x'] = $request->Vivo_buildinfo_store_name_x;
        $data['Vivo_buildinfo_link_store'] = $request->Vivo_buildinfo_link_store;
        $data['Vivo_buildinfo_email_dev_x'] = $request->Vivo_buildinfo_email_dev_x;
        $data['Vivo_buildinfo_link_app'] = $request->Vivo_buildinfo_link_app;
        $data['Vivo_ads'] = $request->Vivo_ads;
        $data['Vivo_status'] = $request->Vivo_status;


//        $image = $request->('logo');






        $data->save();
        return response()->json(['success'=>'Thêm mới thành công']);
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

        $policy = '';
        $policy = '';

        $project = ProjectModel2::where('projectid',$id)->first();
        $policy = Template::select('policy1','policy2')->where('id',$project->template)->first();
        $store_name= Dev::select('store_name')->where('id',$project->buildinfo_store_name_x)->first();

        return response()->json([$project,$policy,$store_name]);
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

        $id = $request->project_id;
        $rules = [
            'projectname' =>'unique:ngocphandang_project,projectname,'.$id.',projectid',
            'ma_da' => 'required',
            'template' => 'required',
            'title_app' =>'required',
            'buildinfo_vernum' =>'required',
            'buildinfo_verstr' =>'required',
        ];
        $message = [
            'projectname.unique'=>'Tên Project đã tồn tại',
            'projectname.required'=>'Tên Project không để trống',
            'ma_da.required'=>'Mã dự án không để trống',
            'template.required'=>'Mã template không để trống',
            'title_app.required'=>'Tiêu đề ứng không để trống',
            'buildinfo_vernum.required'=>'Version Number không để trống',
            'buildinfo_verstr.required'=>'Version String không để trống',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }

//        dd($request->projectname);
        $data = ProjectModel2::find($id);

        $data->projectname = $request->projectname;

        $data->template = $request->template;
        $data->ma_da = $request->ma_da;
        $data->title_app = $request->title_app;
        $data->buildinfo_app_name_x =  $request->buildinfo_app_name_x;
        $data->buildinfo_link_policy_x = $request->buildinfo_link_policy_x;
        $data->buildinfo_link_fanpage = $request->buildinfo_link_fanpage;
        $data->buildinfo_link_website =  $request->buildinfo_link_website;
        $data->buildinfo_link_youtube_x = $request->buildinfo_link_youtube_x;
        $data->buildinfo_api_key_x = $request->buildinfo_api_key_x;
        $data->buildinfo_console = 0;
        $data->buildinfo_vernum= $request->buildinfo_vernum;
        $data->buildinfo_verstr = $request->buildinfo_verstr;
        $data->buildinfo_keystore = $request->buildinfo_keystore;
        $data->buildinfo_sdk = $request->buildinfo_sdk;

        $data->Chplay_package = $request->Chplay_package;
        $data->Chplay_buildinfo_store_name_x = $request->Chplay_buildinfo_store_name_x;
        $data->Chplay_buildinfo_link_store = $request->Chplay_buildinfo_link_store;
        $data->Chplay_buildinfo_link_app = $request->Chplay_buildinfo_link_app;
        $data->Chplay_buildinfo_email_dev_x = $request->Chplay_buildinfo_email_dev_x;
        $data->Chplay_ads = $request->Chplay_ads;
        $data->Chplay_status = $request->Chplay_status;

        $data->Amazon_package = $request->Amazon_package;
        $data->Amazon_buildinfo_store_name_x = $request->Amazon_buildinfo_store_name_x;
        $data->Amazon_buildinfo_link_store = $request->Amazon_buildinfo_link_store;
        $data->Amazon_buildinfo_link_app = $request->Amazon_buildinfo_link_app;
        $data->Amazon_buildinfo_email_dev_x = $request->Amazon_buildinfo_email_dev_x;
        $data->Amazon_ads = $request->Amazon_ads;
        $data->Amazon_status = $request->Amazon_status;

        $data->Samsung_package = $request->Samsung_package;
        $data->Samsung_buildinfo_store_name_x = $request->Samsung_buildinfo_store_name_x;
        $data->Samsung_buildinfo_link_store = $request->Samsung_buildinfo_link_store;
        $data->Samsung_buildinfo_link_app = $request->Samsung_buildinfo_link_app;
        $data->Samsung_buildinfo_email_dev_x = $request->Samsung_buildinfo_email_dev_x;
        $data->Samsung_ads = $request->Samsung_ads;
        $data->Samsung_status = $request->Samsung_status;

        $data->Xiaomi_package = $request->Xiaomi_package;
        $data->Xiaomi_buildinfo_store_name_x = $request->Xiaomi_buildinfo_store_name_x;
        $data->Xiaomi_buildinfo_link_store = $request->Xiaomi_buildinfo_link_store;
        $data->Xiaomi_buildinfo_link_app = $request->Xiaomi_buildinfo_link_app;
        $data->Xiaomi_buildinfo_email_dev_x = $request->Xiaomi_buildinfo_email_dev_x;
        $data->Xiaomi_ads = $request->Xiaomi_ads;
        $data->Xiaomi_status = $request->Xiaomi_status;

        $data->Oppo_package = $request->Oppo_package;
        $data->Oppo_buildinfo_store_name_x = $request->Oppo_buildinfo_store_name_x;
        $data->Oppo_buildinfo_link_store = $request->Oppo_buildinfo_link_store;
        $data->Oppo_buildinfo_link_app = $request->Oppo_buildinfo_link_app;
        $data->Oppo_buildinfo_email_dev_x = $request->Oppo_buildinfo_email_dev_x;
        $data->Oppo_ads = $request->Oppo_ads;
        $data->Oppo_status = $request->Oppo_status;

        $data->Vivo_package = $request->Vivo_package;
        $data->Vivo_buildinfo_store_name_x = $request->Vivo_buildinfo_store_name_x;
        $data->Vivo_buildinfo_link_store = $request->Vivo_buildinfo_link_store;
        $data->Vivo_buildinfo_link_app = $request->Vivo_buildinfo_link_app;
        $data->Vivo_buildinfo_email_dev_x = $request->Vivo_buildinfo_email_dev_x;
        $data->Vivo_ads = $request->Vivo_ads;
        $data->Vivo_status = $request->Vivo_status;
        $data->save();
        return response()->json(['success'=>'Cập nhật thành công']);
    }

    public function updateQuick(Request $request){
        $id = $request->project_id;

        ProjectModel2::updateOrCreate(
            [
                "projectid" => $id,

            ],
            [
                "buildinfo_vernum" => $request->buildinfo_vernum,
                'buildinfo_verstr' => $request->buildinfo_verstr,
                'buildinfo_console' => $request->buildinfo_console
            ]);
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
        ProjectModel::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function callAction($method, $parameters)
    {
//        $this->AuthLogin();
        return parent::callAction($method, array_values($parameters));
    }


    function find_contains(
        \voku\helper\HtmlDomParser $dom,
        string $selector,
        string $keyword = null
    ) {
        // init
        $elements = new SimpleHtmlDomNode();

        foreach ($dom->find($selector) as $e) {
            if (strpos($e->innerText(), $keyword) !== false) {
                $elements[] = $e;
            }
        }

        return $elements;
    }

// -----------------------------------------------------------------------------




//    public function getList(){
//        $url = 'https://play.google.com/store/apps/details?id=com.netringtones.astrohitspopular';
//        $html  = HtmlDomParser::file_get_html($url)->text();
//        $document = new \voku\helper\HtmlDomParser($html);
//        dd($document);
//        $dom = [];
//        foreach ($this->find_contains($document, '.KZnDLd .r2Osbf ') as $child_dom) {
//               $dom[] =  $child_dom->html() . "\n";
//        }
//        dd ($dom);
//    }













}