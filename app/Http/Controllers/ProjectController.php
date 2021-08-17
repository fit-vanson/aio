<?php

namespace App\Http\Controllers;

use App\Models\Da;
use App\Models\Dev;

use App\Models\Dev_Amazon;
use App\Models\Dev_Oppo;
use App\Models\Dev_Samsung;
use App\Models\Dev_Vivo;
use App\Models\Dev_Xiaomi;
use App\Models\log;
use App\Models\ProjectModel;
use App\Models\Template;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Intervention\Image\Facades\Image;
use function Psy\debug;


class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $da =  Da::latest('id')->get();
        $template =  Template::latest('id')->get();
        $store_name =  Dev::latest('id')->get();
        $store_name_amazon  =  Dev_Amazon::latest('id')->get();
        $store_name_samsung =  Dev_Samsung::latest('id')->get();
        $store_name_xiaomi  =  Dev_Xiaomi::latest('id')->get();
        $store_name_oppo    =  Dev_Oppo::latest('id')->get();
        $store_name_vivo    =  Dev_Vivo::latest('id')->get();
        return view('project.index',compact([
            'template','da','store_name',
            'store_name_amazon','store_name_samsung',
            'store_name_xiaomi','store_name_oppo','store_name_vivo'
        ]));
    }

    public function indexBuild()
    {
        return view('project.indexBuild');
    }

    public function appAmazon()
    {
        return view('project.appAmazon');
    }

    public function appSamsung()
    {
        return view('project.appSamsung');
    }

    public function appXiaomi()
    {
        return view('project.appXiaomi');
    }

    public function appOppo()
    {
        return view('project.appOppo');
    }

    public function appVivo()
    {
        return view('project.appVivo');
    }

    public function appChplay()
    {
        return view('project.appChplay');
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

        if(isset($request->ma_da)){
            $totalRecords = ProjectModel::select('count(*) as allcount')->where('ma_da',$request->ma_da)->count();
            $totalRecordswithFilter = ProjectModel::select('count(*) as allcount')
                ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_project.ma_da',$request->ma_da)
                ->count();

            // Get records, also we have included search filter as well
            $records = ProjectModel::orderBy($columnName, $columnSortOrder)
                ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template') ->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                ->where('ngocphandang_project.ma_da',$request->ma_da)
                ->select('ngocphandang_project.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

        }else{
            $totalRecords = ProjectModel::select('count(*) as allcount')->count();
            $totalRecordswithFilter = ProjectModel::select('count(*) as allcount')
                ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Chplay_package', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Amazon_package', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Samsung_package', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Xiaomi_package', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Oppo_package', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Vivo_package', 'like', '%' . $searchValue . '%')
                ->count();
            // Get records, also we have included search filter as well
            $records = ProjectModel::orderBy($columnName, $columnSortOrder)
                ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template') ->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Chplay_package', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Amazon_package', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Samsung_package', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Xiaomi_package', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Oppo_package', 'like', '%' . $searchValue . '%')
                ->orWhere('ngocphandang_project.Vivo_package', 'like', '%' . $searchValue . '%')
                ->select('ngocphandang_project.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }

        // Total records


        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editProject('.$record->projectid.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            if($record->buildinfo_console == 0){
                $btn = $btn. ' <a href="javascript:void(0)" onclick="quickEditProject('.$record->projectid.')" class="btn btn-success"><i class="mdi mdi-android-head"></i></a>';
            }
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->projectid.'" data-original-title="Delete" class="btn btn-danger deleteProject"><i class="ti-trash"></i></a>';

            $ma_da = DB::table('ngocphandang_project')
                ->join('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->where('ngocphandang_da.id',$record->ma_da)
                ->first();
            $template = DB::table('ngocphandang_project')
                ->join('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_template.id',$record->template)
                ->first();

            if(isset($ma_da)) {
                if (isset($ma_da->link_store_vietmmo)){
                    $data_ma_da = '<a href="'.$ma_da->link_store_vietmmo.'" target="_blank" > <p class="text-muted" style="line-height:0.5">Mã Dự án: '.$ma_da->ma_da.'</p></a>';
                }else{
                    $data_ma_da = '<p class="text-muted" style="line-height:0.5">Mã Dự án: '.$ma_da->ma_da.'</p>';
                }
            }else{
                $data_ma_da = '';
            }
            if(isset($template)) {
                if (isset($template->link_store_vietmmo)){
                    $data_template =  '<a href="'.$template->link_store_vietmmo.'" target="_blank" ><p class="text-muted" style="line-height:0.5">Template: '.$template->template.'</p></a>';
                }else{
                    $data_template =  '<p class="text-muted" style="line-height:0.5">Template: '.$template->template.'</p>';
                }
            }else{
                $data_template='';
            }

            if(isset($record->projectname)) {

                $data_projectname =   '<span style="line-height:3">Mã Project: ' . $record->projectname . '</span>';

            }else{
                $data_projectname='';
            }

            if(isset($record->title_app)) {
                $data_title_app=  '<p class="text-muted" style="line-height:0.5">'.$record->title_app.'</p>';
            }else{
                $data_title_app='';
            }

            if(isset(json_decode($record->Chplay_ads,true)['ads_id'])
                || isset(json_decode($record->Chplay_ads,true)['ads_banner'])
                || isset(json_decode($record->Chplay_ads,true)['ads_inter'])
                || isset(json_decode($record->Chplay_ads,true)['ads_native'])
                || isset(json_decode($record->Chplay_ads,true)['ads_open'])
                || isset(json_decode($record->Chplay_ads,true)['ads_reward'])
            ){
                $package_chplay = '<a href="http://play.google.com/store/apps/details?id='.$record->Chplay_package.'" target="_blank" <p style="color:green;line-height:0.5">CH Play: '.$record->Chplay_package.'</p></a>';
            }else{
                $package_chplay = '<a href="http://play.google.com/store/apps/details?id='.$record->Chplay_package.'" target="_blank" <p style="color:red;line-height:0.5">CH Play: '.$record->Chplay_package.'</p></a>';
            }

            if(isset(json_decode($record->Amazon_ads,true)['ads_id'])
                || isset(json_decode($record->Amazon_ads,true)['ads_banner'])
                || isset(json_decode($record->Amazon_ads,true)['ads_inter'])
                || isset(json_decode($record->Amazon_ads,true)['ads_native'])
                || isset(json_decode($record->Amazon_ads,true)['ads_open'])
                || isset(json_decode($record->Amazon_ads,true)['ads_reward'])
            ){
                $package_amazon = '<p  style="color:green;line-height:0.5">Amazon: '.$record->Amazon_package.'</p>';
            }else{
                $package_amazon = '<p style="color:red;line-height:0.5">Amazon: '.$record->Amazon_package.'</p>';
            }

            if(isset(json_decode($record->Samsung_ads,true)['ads_id'])
                || isset(json_decode($record->Samsung_ads,true)['ads_banner'])
                || isset(json_decode($record->Samsung_ads,true)['ads_inter'])
                || isset(json_decode($record->Samsung_ads,true)['ads_native'])
                || isset(json_decode($record->Samsung_ads,true)['ads_open'])
                || isset(json_decode($record->Samsung_ads,true)['ads_reward'])
            ){
                $package_samsung = '<p style="color:green;line-height:0.5">SamSung: '.$record->Samsung_package.'</p>';
            }else{
                $package_samsung = '<p style="color:red;line-height:0.5">SamSung: '.$record->Samsung_package.'</p>';
            }

            if(isset(json_decode($record->Xiaomi_ads,true)['ads_id'])
                || isset(json_decode($record->Xiaomi_ads,true)['ads_banner'])
                || isset(json_decode($record->Xiaomi_ads,true)['ads_inter'])
                || isset(json_decode($record->Xiaomi_ads,true)['ads_native'])
                || isset(json_decode($record->Xiaomi_ads,true)['ads_open'])
                || isset(json_decode($record->Xiaomi_ads,true)['ads_reward'])
            ){
                $package_xiaomi = '<p style="color:green;line-height:0.5">Xiaomi: '.$record->Xiaomi_package.'</p>';
            }else{
                $package_xiaomi = '<p style="color:red;line-height:0.5">Xiaomi: '.$record->Xiaomi_package.'</p>';
            }



            if(isset(json_decode($record->Oppo_ads,true)['ads_id'])
                || isset(json_decode($record->Oppo_ads,true)['ads_banner'])
                || isset(json_decode($record->Oppo_ads,true)['ads_inter'])
                || isset(json_decode($record->Oppo_ads,true)['ads_native'])
                || isset(json_decode($record->Oppo_ads,true)['ads_open'])
                || isset(json_decode($record->Oppo_ads,true)['ads_reward'])
            ){
                $package_oppo = '<p style="color:green;line-height:0.5">Oppo: '.$record->Oppo_package.'</p>';
            }else{
                $package_oppo = '<p style="color:red;line-height:0.5">Oppo: '.$record->Oppo_package.'</p>';
            }

            if(isset(json_decode($record->Vivo_ads,true)['ads_id'])
                || isset(json_decode($record->Vivo_ads,true)['ads_banner'])
                || isset(json_decode($record->Vivo_ads,true)['ads_inter'])
                || isset(json_decode($record->Vivo_ads,true)['ads_native'])
                || isset(json_decode($record->Vivo_ads,true)['ads_open'])
                || isset(json_decode($record->Vivo_ads,true)['ads_reward'])
            ){
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
            elseif($record['Chplay_status']==7){
                $Chplay_status =  '<span class="badge badge-warning">Pending</span>';
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

            $policy = DB::table('ngocphandang_project')
                ->join('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_template.id',$record->template)
                ->first();
            if(isset($policy->policy1) || isset($policy->policy2)){
                $policy = ' <a href="javascript:void(0)" onclick="showPolicy('.$record->projectid.')"><span class="badge badge-primary">Policy</span></a>';
            }else{
                $policy = '';
            }
            $status =  $policy.'<br> CH Play: '.$Chplay_status.'<br> Amazon: '.$Amazon_status.'<br> SamSung: '.$Samsung_status.'<br> Xiaomi: '.$Xiaomi_status.'<br> Oppo: '.$Oppo_status.'<br> Vivo: '.$Vivo_status;

            if(isset($record->logo)){
                if (isset($record->link_store_vietmmo)){
                    $logo = "<a href='".$record->link_store_vietmmo."' target='_blank'>  <img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/project/$record->projectname/thumbnail/$record->logo'></a>";
                }else{
                    $logo = "<img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/project/$record->projectname/thumbnail/$record->logo'>";
                }
            }else{
                $logo = '<img class="rounded mx-auto d-block" width="100px" height="100px" src="assets\images\logo-sm.png">';
            }
            $abc = '<p class="text-muted" style="line-height:0.5">'.$record->buildinfo_keystore. '   |   '.$record->buildinfo_vernum.'   |   '.$record->buildinfo_verstr.'</p>';
            $data_arr[] = array(
                "created_at" => $record->created_at,
                "logo" => $logo,
                "projectname"=>$data_projectname.$data_template.$data_ma_da.$data_title_app.$abc,
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

    public function getIndexBuild(Request $request)
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

        if(isset($request->console_status)){
            $status_console = $request->console_status;
            $status_console = explode('%',$status_console);
            // Total records
            $totalRecords = ProjectModel::select('count(*) as allcount')
                ->where(function ($q){
                    $q->where('buildinfo_console','<>',0);
                })
                ->where(function ($q) use ($status_console) {
                    $q->whereIn('buildinfo_console',$status_console);
                })
                ->count();
            $totalRecordswithFilter = ProjectModel::select('count(*) as allcount')
                ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where(function ($a) use ($searchValue) {
                    $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Chplay_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Amazon_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Samsung_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Xiaomi_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Oppo_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Vivo_package', 'like', '%' . $searchValue . '%');
                })
                ->where(function ($q){
                    $q->where('buildinfo_console','<>',0);
                })

                ->where(function ($q) use ($status_console) {
                    $q->whereIn('buildinfo_console',$status_console);
                })
                ->count();

            // Get records, also we have included search filter as well
            $records = ProjectModel::orderBy($columnName, $columnSortOrder)
                ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')

                ->where(function ($a) use ($searchValue) {
                    $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Chplay_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Amazon_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Samsung_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Xiaomi_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Oppo_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Vivo_package', 'like', '%' . $searchValue . '%');
                })
                ->where(function ($q){
                    $q->where('buildinfo_console','<>',0);
                })
                ->where(function ($q) use ($status_console) {
                    $q->whereIn('buildinfo_console',$status_console);
                })
                ->select('ngocphandang_project.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

        }else{
            // Total records
            $totalRecords = ProjectModel::select('count(*) as allcount')
                ->where(function ($q){
                    $q->where('buildinfo_console','<>',0);
                })
                ->count();

            $totalRecordswithFilter = ProjectModel::select('count(*) as allcount')
                ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where(function ($a) use ($searchValue) {
                    $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Chplay_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Amazon_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Samsung_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Xiaomi_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Oppo_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Vivo_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.buildinfo_console', $searchValue );
                })
                ->where(function ($q){
                    $q->where('ngocphandang_project.buildinfo_console','<>',0);
                })
                ->count();


            // Get records, also we have included search filter as well
            $records = ProjectModel::orderBy($columnName, $columnSortOrder)
                ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')

                ->where(function ($a) use ($searchValue) {
                    $a
                        ->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Chplay_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Amazon_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Samsung_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Xiaomi_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Oppo_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Vivo_package', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.buildinfo_console', 'like', '%' . $searchValue . '%');

                })
                ->where(function ($q){
                    $q->where('ngocphandang_project.buildinfo_console','<>',0);
                })
                ->select('ngocphandang_project.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }
        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->projectid.'" data-original-title="Delete" class="btn btn-warning removeProject"><i class="mdi mdi-file-move"></i></a>';

            $ma_da = DB::table('ngocphandang_project')
                ->join('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->where('ngocphandang_da.id',$record->ma_da)
                ->first();
            $template = DB::table('ngocphandang_project')
                ->join('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_template.id',$record->template)
                ->first();

            if(isset($ma_da)) {
                if (isset($ma_da->link_store_vietmmo)){
                    $data_ma_da = '<a href="'.$ma_da->link_store_vietmmo.'" target="_blank" > <p class="text-muted" style="line-height:0.5">Mã Dự án: '.$ma_da->ma_da.'</p></a>';
                }else{
                    $data_ma_da = '<p class="text-muted" style="line-height:0.5">Mã Dự án: '.$ma_da->ma_da.'</p>';
                }
            }else{
                $data_ma_da = '';
            }
            if(isset($template)) {
                if (isset($template->link_store_vietmmo)){
                    $data_template =  '<a href="'.$template->link_store_vietmmo.'" target="_blank" ><p class="text-muted" style="line-height:0.5">Template: '.$template->template.'</p></a>';
                }else{
                    $data_template =  '<p class="text-muted" style="line-height:0.5">Template: '.$template->template.'</p>';
                }
            }else{
                $data_template='';
            }

            if(isset($record->projectname)) {
                $data_projectname =   '<span style="line-height:3"> Mã Project: ' . $record->projectname . '</span>';

            }else{
                $data_projectname='';
            }

            if(isset($record->title_app)) {
                $data_title_app=  '<p class="text-muted" style="line-height:0.5">'.$record->title_app.'</p>';
            }else{
                $data_title_app='';
            }

            $abc = '<p class="text-muted" style="line-height:0.5">'.$record->buildinfo_keystore. '   |   '.$record->buildinfo_vernum.'   |   '.$record->buildinfo_verstr.'</p>';

            if(isset(json_decode($record->Chplay_ads,true)['ads_id'])
                || isset(json_decode($record->Chplay_ads,true)['ads_banner'])
                || isset(json_decode($record->Chplay_ads,true)['ads_inter'])
                || isset(json_decode($record->Chplay_ads,true)['ads_native'])
                || isset(json_decode($record->Chplay_ads,true)['ads_open'])
                || isset(json_decode($record->Chplay_ads,true)['ads_reward'])
            ){
                $package_chplay = '<p style="color:green;line-height:0.5">CH Play: '.$record->Chplay_package.'</p>';
            }else{
                $package_chplay = '<p style="color:red;line-height:0.5">CH Play: '.$record->Chplay_package.'</p>';
            }

            if(isset(json_decode($record->Amazon_ads,true)['ads_id'])
                || isset(json_decode($record->Amazon_ads,true)['ads_banner'])
                || isset(json_decode($record->Amazon_ads,true)['ads_inter'])
                || isset(json_decode($record->Amazon_ads,true)['ads_native'])
                || isset(json_decode($record->Amazon_ads,true)['ads_open'])
                || isset(json_decode($record->Amazon_ads,true)['ads_reward'])
            ){
                $package_amazon = '<p  style="color:green;line-height:0.5">Amazon: '.$record->Amazon_package.'</p>';
            }else{
                $package_amazon = '<p style="color:red;line-height:0.5">Amazon: '.$record->Amazon_package.'</p>';
            }

            if(isset(json_decode($record->Samsung_ads,true)['ads_id'])
                || isset(json_decode($record->Samsung_ads,true)['ads_banner'])
                || isset(json_decode($record->Samsung_ads,true)['ads_inter'])
                || isset(json_decode($record->Samsung_ads,true)['ads_native'])
                || isset(json_decode($record->Samsung_ads,true)['ads_open'])
                || isset(json_decode($record->Samsung_ads,true)['ads_reward'])
            ){
                $package_samsung = '<p style="color:green;line-height:0.5">SamSung: '.$record->Samsung_package.'</p>';
            }else{
                $package_samsung = '<p style="color:red;line-height:0.5">SamSung: '.$record->Samsung_package.'</p>';
            }

            if(isset(json_decode($record->Xiaomi_ads,true)['ads_id'])
                || isset(json_decode($record->Xiaomi_ads,true)['ads_banner'])
                || isset(json_decode($record->Xiaomi_ads,true)['ads_inter'])
                || isset(json_decode($record->Xiaomi_ads,true)['ads_native'])
                || isset(json_decode($record->Xiaomi_ads,true)['ads_open'])
                || isset(json_decode($record->Xiaomi_ads,true)['ads_reward'])
            ){
                $package_xiaomi = '<p style="color:green;line-height:0.5">Xiaomi: '.$record->Xiaomi_package.'</p>';
            }else{
                $package_xiaomi = '<p style="color:red;line-height:0.5">Xiaomi: '.$record->Xiaomi_package.'</p>';
            }



            if(isset(json_decode($record->Oppo_ads,true)['ads_id'])
                || isset(json_decode($record->Oppo_ads,true)['ads_banner'])
                || isset(json_decode($record->Oppo_ads,true)['ads_inter'])
                || isset(json_decode($record->Oppo_ads,true)['ads_native'])
                || isset(json_decode($record->Oppo_ads,true)['ads_open'])
                || isset(json_decode($record->Oppo_ads,true)['ads_reward'])
            ){
                $package_oppo = '<p style="color:green;line-height:0.5">Oppo: '.$record->Oppo_package.'</p>';
            }else{
                $package_oppo = '<p style="color:red;line-height:0.5">Oppo: '.$record->Oppo_package.'</p>';
            }

            if(isset(json_decode($record->Vivo_ads,true)['ads_id'])
                || isset(json_decode($record->Vivo_ads,true)['ads_banner'])
                || isset(json_decode($record->Vivo_ads,true)['ads_inter'])
                || isset(json_decode($record->Vivo_ads,true)['ads_native'])
                || isset(json_decode($record->Vivo_ads,true)['ads_open'])
                || isset(json_decode($record->Vivo_ads,true)['ads_reward'])
            ){
                $package_vivo = '<p style="color:green;line-height:0.5">Vivo: '.$record->Vivo_package.'</p>';
            }else{
                $package_vivo = '<p style="color:red;line-height:0.5">Vivo: '.$record->Vivo_package.'</p>';
            }
//
            if(isset($record->logo)){
                if (isset($record->link_store_vietmmo)){
                    $logo = "<a href='".$record->link_store_vietmmo."' target='_blank'>  <img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/project/$record->projectname/thumbnail/$record->logo'></a>";
                }else{
                    $logo = "<img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/project/$record->projectname/thumbnail/$record->logo'>";
                }
            }else{
                $logo = '<img class="rounded mx-auto d-block" width="100px" height="100px" src="assets\images\logo-sm.png">';
            }
            $mess_info = '';
            $full_mess ='null';
            if ($record->buildinfo_mess){
                $buildinfo_mess = $record->buildinfo_mess;
                $full_mess =  (str_replace('|','<br>',$buildinfo_mess));
                $buildinfo_mess =  (explode('|',$buildinfo_mess));
                $buildinfo_mess = array_reverse($buildinfo_mess);
                for($i = 0 ; $i < 6 ; $i++){
                    if(isset($buildinfo_mess[$i])){
                        $mess_info .=  $buildinfo_mess[$i].'<br>';
                    }
                }
            }
            $data_arr[] = array(
                "created_at" => $record->created_at,
                "logo" => $logo,
                "name_projectname"=>$record->projectname,
                "projectname"=>$data_projectname.$data_template.$data_ma_da.$data_title_app.$abc,
                "package" => $package_chplay.$package_amazon.$package_samsung.$package_xiaomi.$package_oppo.$package_vivo,
                "buildinfo_mess" => $mess_info,
                "full_mess" => $full_mess,
                "buildinfo_console" =>$record->buildinfo_console,
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
    public function getChplay(Request $request)
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

        if (isset($request->status_app)){
            // Total records
            $totalRecords = ProjectModel::select('count(*) as allcount')
                ->where('ngocphandang_project.Chplay_package','<>','null')
                ->where('ngocphandang_project.Chplay_status','=',$request->status_app)
                ->count();
            $totalRecordswithFilter = ProjectModel::select('count(*) as allcount')
                ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where(function ($a) use ($searchValue) {
                    $a->Where('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Chplay_package', 'like', '%' . $searchValue . '%');
                })
                ->where('ngocphandang_project.Chplay_package','<>',null)
                ->where('ngocphandang_project.Chplay_status','=',$request->status_app)
                ->count();
            // Get records, also we have included search filter as well
            $records = ProjectModel::orderBy($columnName, $columnSortOrder)
                ->where(function ($a) use ($searchValue) {
                    $a->Where('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                        ->orWhere('ngocphandang_project.Chplay_package', 'like', '%' . $searchValue . '%');
                })
                ->where('ngocphandang_project.Chplay_package','<>',null)
                ->where('ngocphandang_project.Chplay_status','=',$request->status_app)
                ->select('ngocphandang_project.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();
        }    else {
        // Total records
        $totalRecords = ProjectModel::select('count(*) as allcount')
            ->where('ngocphandang_project.Chplay_package','<>','null')
            ->count();
        $totalRecordswithFilter = ProjectModel::select('count(*) as allcount')
            ->where(function ($a) use ($searchValue) {
                $a->Where('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.Chplay_package', 'like', '%' . $searchValue . '%');
            })
            ->where('ngocphandang_project.Chplay_package','<>',null)
            ->count();
        // Get records, also we have included search filter as well
        $records = ProjectModel::orderBy($columnName, $columnSortOrder)
            ->where(function ($a) use ($searchValue) {
                $a->Where('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orwhereJsonContains('Chplay_bot->installs', $searchValue);
//                    ->orWhere('ngocphandang_project.Chplay_package', 'like', '%' . $searchValue . '%');
            })
            ->where('ngocphandang_project.Chplay_package','<>',null)
            ->select('ngocphandang_project.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();
    }
        $data_arr = array();

        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="detailChplay('.$record->projectid.')" class="btn btn-warning"><i class="mdi mdi-clipboard-text"></i></a>';
            if($record->Chplay_status == 0 || $record->Chplay_status == 3 ){
                $check = ' <a href="javascript:void(0)" onclick="checkbox('.$record->projectid.')" class="btn btn-success"><i class="mdi mdi-check-box-outline"></i></a>';
            }else{
                $check = '';
            }
            if(isset($record->projectname)) {
                $data_projectname =  '<p style="line-height:0.5">Project: '.$record->projectname.'</p>';
            }else{
                $data_projectname='';
            }
            $package_chplay = '<a href="http://play.google.com/store/apps/details?id='.$record->Chplay_package.'" target="_blank"<p style="line-height:0.5">'.$record->Chplay_package.'</p></a>';
            if ($record['buildinfo_console']==0  ) {
                $buildinfo_console = 'Trạng thái tĩnh';
            }
            elseif($record['buildinfo_console']== 1){
                $buildinfo_console = '<span class="badge badge-dark">Build App</span>';
            }
            elseif($record['buildinfo_console']==2){
                $buildinfo_console =  '<span class="badge badge-warning">Đang xử lý Build App</span>';
            }
            elseif($record['buildinfo_console']==3){
                $buildinfo_console =  '<span class="badge badge-info">Kết thúc Build App</span>';
            }
            elseif($record['buildinfo_console']==4){
                $buildinfo_console =  '<span class="badge badge-primary">Check Data Project</span>';
            }
            elseif($record['buildinfo_console']==5){
                $buildinfo_console =  '<span class="badge badge-success">Đang xử lý check dữ liệu của Project</span>';
            }
            elseif($record['buildinfo_console']==6){
                $buildinfo_console =  '<span class="badge badge-danger">Kết thúc Check</span>';
            }

            if ($record['Chplay_status'] ==0  ) {
                $Chplay_status = 'Chưa Publish';
            }
            elseif($record['Chplay_status']== 1){
                $Chplay_status = '<span class="badge badge-dark">Public</span>';
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
            elseif($record['Chplay_status']==7){
                $Chplay_status =  '<span class="badge badge-warning">Pending</span>';
            }

            $mess_info = '';
            $full_mess ='';
            if ($record->buildinfo_mess){
                $buildinfo_mess = $record->buildinfo_mess;
                $full_mess =  (str_replace('|','<br>',$buildinfo_mess));
                $buildinfo_mess =  (explode('|',$buildinfo_mess));
                $buildinfo_mess = array_reverse($buildinfo_mess);
                for($i = 0 ; $i < 6 ; $i++){
                    if(isset($buildinfo_mess[$i])){
                        $mess_info .=  $buildinfo_mess[$i].'<br>';
                    }
                }
            }

            if(isset($record->logo)){
                $logo = "<img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/project/$record->projectname/thumbnail/$record->logo'>";
            }else{
                $logo = '<img class="rounded mx-auto d-block" width="100px" height="100px" src="assets\images\logo-sm.png">';
            }
            if(isset($record->Chplay_bot)){
                $bot = json_decode($record->Chplay_bot,true);
                if(isset($bot['logo'])){
                    $logo = $bot['logo'];
                    $logo = '<img class="rounded mx-auto d-block" width="100px" height="100px" src="'.$logo.'">';
                }
                $data_arr[] = array(
                    "updated_at" => strtotime($record->updated_at),
                    "logo" => $logo,
                    "name_projectname"=>$record->projectname,
                    "ma_da"=>$data_projectname.$package_chplay,
                    "Chplay_bot->installs" => $bot['installs'],
                    "Chplay_bot->numberVoters" => $bot['numberVoters'],
                    "Chplay_bot->numberReviews" => $bot['numberReviews'],
                    "Chplay_bot->score" => number_format($bot['score'],2),
                    "buildinfo_mess" => $mess_info,
                    "full_mess" => $full_mess,
                    "status" =>'Console: '.$buildinfo_console.'<br> Ứng dụng: '.$Chplay_status,
                    "action"=> $btn .'  '. $check,
                );
            }else{

                $data_arr[] = array(
                    "updated_at" => strtotime($record->updated_at),
                    "logo" => $logo,
                    "name_projectname"=>$record->projectname,
                    "ma_da"=>$data_projectname.$package_chplay,
                    "Chplay_bot->installs" => 0,
                    "Chplay_bot->numberVoters" => 0,
                    "Chplay_bot->numberReviews" => 0,
                    "Chplay_bot->score" => 0,
                    "buildinfo_mess" => $mess_info,
                    "full_mess" => $full_mess,
                    "status" =>'Console: '.$buildinfo_console.'<br> Ứng dụng: '.$Chplay_status,
                    "action"=> $btn .'  '. $check,
                );
            }
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
        );


        echo json_encode($response);
    }
    public function getAmazon(Request $request)
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
        $totalRecords = ProjectModel::select('count(*) as allcount')
            ->where('ngocphandang_project.Amazon_package','<>','null')
            ->count();
        $totalRecordswithFilter = ProjectModel::select('count(*) as allcount')
            ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
            ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
            ->where(function ($a) use ($searchValue) {
                $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.Amazon_package', 'like', '%' . $searchValue . '%');

            })
            ->where('ngocphandang_project.Amazon_package','<>','null')
            ->count();


        // Get records, also we have included search filter as well
        $records = ProjectModel::orderBy($columnName, $columnSortOrder)
            ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
            ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')

            ->where(function ($a) use ($searchValue) {
                $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.Amazon_package', 'like', '%' . $searchValue . '%');


            })
            ->where('ngocphandang_project.Amazon_package','<>',null)
            ->select('ngocphandang_project.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="detailAmazon('.$record->projectid.')" class="btn btn-outline-warning"><i class="mdi mdi-clipboard-text"></i></a>';
            $ma_da = DB::table('ngocphandang_project')
                ->join('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->where('ngocphandang_da.id',$record->ma_da)
                ->first();
            $template = DB::table('ngocphandang_project')
                ->join('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_template.id',$record->template)
                ->first();

            if(isset($ma_da)) {
                $data_ma_da =
                    '<span style="line-height:3"> Mã Dự án: ' . $ma_da->ma_da . '</span>';
            }else{
                $data_ma_da = '';
            }
            if(isset($template)) {
                $data_template =  '<p class="text-muted" style="line-height:0.5">Template: '.$template->template.'</p>';
            }else{
                $data_template='';
            }

            if(isset($record->projectname)) {
                $data_projectname =  '<p class="text-muted" style="line-height:0.5">Project: '.$record->projectname.'</p>';
            }else{
                $data_projectname='';
            }

            if(isset($record->title_app)) {
                $data_title_app=  '<p class="text-muted" style="line-height:0.5">'.$record->title_app.'</p>';
            }else{
                $data_title_app='';
            }
            $ads = json_decode($record->Amazon_ads,true);
            $package_Amazon = '<p style="line-height:0.5">'.$record->Amazon_package.'</p>';
            $ads_banner = '<p class="text-muted" style="line-height:0.5">ads_banner: '.$ads['ads_banner'].'</p>';
            $ads_inter = '<p class="text-muted" style="line-height:0.5">ads_inter: '.$ads['ads_inter'].'</p>';
            $ads_native = '<p class="text-muted" style="line-height:0.5">ads_native: '.$ads['ads_native'].'</p>';
            $ads_open = '<p class="text-muted" style="line-height:0.5">ads_open: '.$ads['ads_open'].'</p>';
            $ads_reward = '<p class="text-muted" style="line-height:0.5">ads_reward: '.$ads['ads_reward'].'</p>';
//


            if ($record['buildinfo_console']==0  ) {
                $buildinfo_console = 'Trạng thái tĩnh';
            }
            elseif($record['buildinfo_console']== 1){
                $buildinfo_console = '<span class="badge badge-dark">Build App</span>';

            }
            elseif($record['buildinfo_console']==2){
                $buildinfo_console =  '<span class="badge badge-warning">Đang xử lý Build App</span>';
            }
            elseif($record['buildinfo_console']==3){
                $buildinfo_console =  '<span class="badge badge-info">Kết thúc Build App</span>';
            }
            elseif($record['buildinfo_console']==4){
                $buildinfo_console =  '<span class="badge badge-primary">Check Data Project</span>';
            }
            elseif($record['buildinfo_console']==5){
                $buildinfo_console =  '<span class="badge badge-success">Đang xử lý check dữ liệu của Project</span>';
            }
            elseif($record['buildinfo_console']==6){
                $buildinfo_console =  '<span class="badge badge-danger">Kết thúc Check</span>';
            }
//
            if(isset($record->logo)){
                $logo = "<img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/project/$record->projectname/thumbnail/$record->logo'>";
            }else{
                $logo = '<img class="rounded mx-auto d-block" width="100px" height="100px" src="assets\images\logo-sm.png">';
            }
            if ($record->buildinfo_mess){
                $mess_info = '';
                $buildinfo_mess = $record->buildinfo_mess;
                $buildinfo_mess =  (explode('|',$buildinfo_mess));
                $buildinfo_mess = array_reverse($buildinfo_mess);
                for($i = 0 ; $i < 6 ; $i++){
                    if(isset($buildinfo_mess[$i])){
                        $mess_info .=  $buildinfo_mess[$i].'<br>';
                    }
                }

            }
            $data_arr[] = array(
                "updated_at" => $record->updated_at,
                "logo" => $logo,
                "ma_da"=>$data_ma_da.$data_template.$data_projectname.$data_title_app,
                "package" => $package_Amazon.$ads_banner.$ads_inter.$ads_native.$ads_open.$ads_reward,
//                "buildinfo_mess" => $mess_info,
                "buildinfo_console" =>$buildinfo_console,
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
    public function getSamsung(Request $request)
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
        $totalRecords = ProjectModel::select('count(*) as allcount')
            ->where('ngocphandang_project.Samsung_package','<>','null')
            ->count();
        $totalRecordswithFilter = ProjectModel::select('count(*) as allcount')
            ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
            ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
            ->where(function ($a) use ($searchValue) {
                $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.Samsung_package', 'like', '%' . $searchValue . '%');
            })
            ->where('ngocphandang_project.Samsung_package','<>','null')
            ->count();


        // Get records, also we have included search filter as well
        $records = ProjectModel::orderBy($columnName, $columnSortOrder)
            ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
            ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')

            ->where(function ($a) use ($searchValue) {
                $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.Samsung_package', 'like', '%' . $searchValue . '%');
            })
            ->where('ngocphandang_project.Samsung_package','<>',null)
            ->select('ngocphandang_project.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="detailSamsung('.$record->projectid.')" class="btn btn-outline-warning"><i class="mdi mdi-clipboard-text"></i></a>';
            $ma_da = DB::table('ngocphandang_project')
                ->join('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->where('ngocphandang_da.id',$record->ma_da)
                ->first();
            $template = DB::table('ngocphandang_project')
                ->join('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_template.id',$record->template)
                ->first();

            if(isset($ma_da)) {
                $data_ma_da =
                    '<span style="line-height:3"> Mã Dự án: ' . $ma_da->ma_da . '</span>';
            }else{
                $data_ma_da = '';
            }
            if(isset($template)) {
                $data_template =  '<p class="text-muted" style="line-height:0.5">Template: '.$template->template.'</p>';
            }else{
                $data_template='';
            }

            if(isset($record->projectname)) {
                $data_projectname =  '<p class="text-muted" style="line-height:0.5">Project: '.$record->projectname.'</p>';
            }else{
                $data_projectname='';
            }

            if(isset($record->title_app)) {
                $data_title_app=  '<p class="text-muted" style="line-height:0.5">'.$record->title_app.'</p>';
            }else{
                $data_title_app='';
            }
            $ads = json_decode($record->Samsung_ads,true);
            $package_Samsung = '<p style="line-height:0.5">'.$record->Samsung_package.'</p>';
            $ads_banner = '<p class="text-muted" style="line-height:0.5">ads_banner: '.$ads['ads_banner'].'</p>';
            $ads_inter = '<p class="text-muted" style="line-height:0.5">ads_inter: '.$ads['ads_inter'].'</p>';
            $ads_native = '<p class="text-muted" style="line-height:0.5">ads_native: '.$ads['ads_native'].'</p>';
            $ads_open = '<p class="text-muted" style="line-height:0.5">ads_open: '.$ads['ads_open'].'</p>';
            $ads_reward = '<p class="text-muted" style="line-height:0.5">ads_reward: '.$ads['ads_reward'].'</p>';
//


            if ($record['buildinfo_console']==0  ) {
                $buildinfo_console = 'Trạng thái tĩnh';
            }
            elseif($record['buildinfo_console']== 1){
                $buildinfo_console = '<span class="badge badge-dark">Build App</span>';

            }
            elseif($record['buildinfo_console']==2){
                $buildinfo_console =  '<span class="badge badge-warning">Đang xử lý Build App</span>';
            }
            elseif($record['buildinfo_console']==3){
                $buildinfo_console =  '<span class="badge badge-info">Kết thúc Build App</span>';
            }
            elseif($record['buildinfo_console']==4){
                $buildinfo_console =  '<span class="badge badge-primary">Check Data Project</span>';
            }
            elseif($record['buildinfo_console']==5){
                $buildinfo_console =  '<span class="badge badge-success">Đang xử lý check dữ liệu của Project</span>';
            }
            elseif($record['buildinfo_console']==6){
                $buildinfo_console =  '<span class="badge badge-danger">Kết thúc Check</span>';
            }
//
            if(isset($record->logo)){
                $logo = "<img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/project/$record->projectname/thumbnail/$record->logo'>";
            }else{
                $logo = '<img class="rounded mx-auto d-block" width="100px" height="100px" src="assets\images\logo-sm.png">';
            }
            if ($record->buildinfo_mess){
                $mess_info = '';
                $buildinfo_mess = $record->buildinfo_mess;
                $buildinfo_mess =  (explode('|',$buildinfo_mess));
                $buildinfo_mess = array_reverse($buildinfo_mess);
                for($i = 0 ; $i < 6 ; $i++){
                    if(isset($buildinfo_mess[$i])){
                        $mess_info .=  $buildinfo_mess[$i].'<br>';
                    }
                }

            }
            $data_arr[] = array(
                "updated_at" => $record->updated_at,
                "logo" => $logo,
                "ma_da"=>$data_ma_da.$data_template.$data_projectname.$data_title_app,
                "package" => $package_Samsung.$ads_banner.$ads_inter.$ads_native.$ads_open.$ads_reward,
//                "buildinfo_mess" => $mess_info,
                "buildinfo_console" =>$buildinfo_console,
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

    public function getXiaomi(Request $request)
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
        $totalRecords = ProjectModel::select('count(*) as allcount')
            ->where('ngocphandang_project.Xiaomi_package','<>','null')
            ->count();
        $totalRecordswithFilter = ProjectModel::select('count(*) as allcount')
            ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
            ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
            ->where(function ($a) use ($searchValue) {
                $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.Xiaomi_package', 'like', '%' . $searchValue . '%');
            })
            ->where('ngocphandang_project.Xiaomi_package','<>','null')
            ->count();


        // Get records, also we have included search filter as well
        $records = ProjectModel::orderBy($columnName, $columnSortOrder)
            ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
            ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')

            ->where(function ($a) use ($searchValue) {
                $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.Xiaomi_package', 'like', '%' . $searchValue . '%');

            })
            ->where('ngocphandang_project.Xiaomi_package','<>',null)
            ->select('ngocphandang_project.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="detailXiaomi('.$record->projectid.')" class="btn btn-outline-warning"><i class="mdi mdi-clipboard-text"></i></a>';
            $ma_da = DB::table('ngocphandang_project')
                ->join('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->where('ngocphandang_da.id',$record->ma_da)
                ->first();
            $template = DB::table('ngocphandang_project')
                ->join('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_template.id',$record->template)
                ->first();

            if(isset($ma_da)) {
                $data_ma_da =
                    '<span style="line-height:3"> Mã Dự án: ' . $ma_da->ma_da . '</span>';
            }else{
                $data_ma_da = '';
            }
            if(isset($template)) {
                $data_template =  '<p class="text-muted" style="line-height:0.5">Template: '.$template->template.'</p>';
            }else{
                $data_template='';
            }

            if(isset($record->projectname)) {
                $data_projectname =  '<p class="text-muted" style="line-height:0.5">Project: '.$record->projectname.'</p>';
            }else{
                $data_projectname='';
            }

            if(isset($record->title_app)) {
                $data_title_app=  '<p class="text-muted" style="line-height:0.5">'.$record->title_app.'</p>';
            }else{
                $data_title_app='';
            }
            $ads = json_decode($record->Xiaomi_ads,true);
            $package_Xiaomi = '<p style="line-height:0.5">'.$record->Xiaomi_package.'</p>';
            $ads_banner = '<p class="text-muted" style="line-height:0.5">ads_banner: '.$ads['ads_banner'].'</p>';
            $ads_inter = '<p class="text-muted" style="line-height:0.5">ads_inter: '.$ads['ads_inter'].'</p>';
            $ads_native = '<p class="text-muted" style="line-height:0.5">ads_native: '.$ads['ads_native'].'</p>';
            $ads_open = '<p class="text-muted" style="line-height:0.5">ads_open: '.$ads['ads_open'].'</p>';
            $ads_reward = '<p class="text-muted" style="line-height:0.5">ads_reward: '.$ads['ads_reward'].'</p>';
//


            if ($record['buildinfo_console']==0  ) {
                $buildinfo_console = 'Trạng thái tĩnh';
            }
            elseif($record['buildinfo_console']== 1){
                $buildinfo_console = '<span class="badge badge-dark">Build App</span>';

            }
            elseif($record['buildinfo_console']==2){
                $buildinfo_console =  '<span class="badge badge-warning">Đang xử lý Build App</span>';
            }
            elseif($record['buildinfo_console']==3){
                $buildinfo_console =  '<span class="badge badge-info">Kết thúc Build App</span>';
            }
            elseif($record['buildinfo_console']==4){
                $buildinfo_console =  '<span class="badge badge-primary">Check Data Project</span>';
            }
            elseif($record['buildinfo_console']==5){
                $buildinfo_console =  '<span class="badge badge-success">Đang xử lý check dữ liệu của Project</span>';
            }
            elseif($record['buildinfo_console']==6){
                $buildinfo_console =  '<span class="badge badge-danger">Kết thúc Check</span>';
            }
//
            if(isset($record->logo)){
                $logo = "<img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/project/$record->projectname/thumbnail/$record->logo'>";
            }else{
                $logo = '<img class="rounded mx-auto d-block" width="100px" height="100px" src="assets\images\logo-sm.png">';
            }
            if ($record->buildinfo_mess){
                $mess_info = '';
                $buildinfo_mess = $record->buildinfo_mess;
                $buildinfo_mess =  (explode('|',$buildinfo_mess));
                $buildinfo_mess = array_reverse($buildinfo_mess);
                for($i = 0 ; $i < 6 ; $i++){
                    if(isset($buildinfo_mess[$i])){
                        $mess_info .=  $buildinfo_mess[$i].'<br>';
                    }
                }

            }
            $data_arr[] = array(
                "updated_at" => $record->updated_at,
                "logo" => $logo,
                "ma_da"=>$data_ma_da.$data_template.$data_projectname.$data_title_app,
                "package" => $package_Xiaomi.$ads_banner.$ads_inter.$ads_native.$ads_open.$ads_reward,
//                "buildinfo_mess" => $mess_info,
                "buildinfo_console" =>$buildinfo_console,
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

    public function getOppo(Request $request)
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
        $totalRecords = ProjectModel::select('count(*) as allcount')
            ->where('ngocphandang_project.Oppo_package','<>','null')
            ->count();
        $totalRecordswithFilter = ProjectModel::select('count(*) as allcount')
            ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
            ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
            ->where(function ($a) use ($searchValue) {
                $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.Oppo_package', 'like', '%' . $searchValue . '%');
            })
            ->where('ngocphandang_project.Oppo_package','<>','null')
            ->count();


        // Get records, also we have included search filter as well
        $records = ProjectModel::orderBy($columnName, $columnSortOrder)
            ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
            ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')

            ->where(function ($a) use ($searchValue) {
                $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.Oppo_package', 'like', '%' . $searchValue . '%');

            })
            ->where('ngocphandang_project.Oppo_package','<>',null)
            ->select('ngocphandang_project.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="detailOppo('.$record->projectid.')" class="btn btn-outline-warning"><i class="mdi mdi-clipboard-text"></i></a>';
            $ma_da = DB::table('ngocphandang_project')
                ->join('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->where('ngocphandang_da.id',$record->ma_da)
                ->first();
            $template = DB::table('ngocphandang_project')
                ->join('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_template.id',$record->template)
                ->first();

            if(isset($ma_da)) {
                $data_ma_da =
                    '<span style="line-height:3"> Mã Dự án: ' . $ma_da->ma_da . '</span>';
            }else{
                $data_ma_da = '';
            }
            if(isset($template)) {
                $data_template =  '<p class="text-muted" style="line-height:0.5">Template: '.$template->template.'</p>';
            }else{
                $data_template='';
            }

            if(isset($record->projectname)) {
                $data_projectname =  '<p class="text-muted" style="line-height:0.5">Project: '.$record->projectname.'</p>';
            }else{
                $data_projectname='';
            }

            if(isset($record->title_app)) {
                $data_title_app=  '<p class="text-muted" style="line-height:0.5">'.$record->title_app.'</p>';
            }else{
                $data_title_app='';
            }
            $ads = json_decode($record->Oppo_ads,true);
            $package_Oppo = '<p style="line-height:0.5">'.$record->Oppo_package.'</p>';
            $ads_banner = '<p class="text-muted" style="line-height:0.5">ads_banner: '.$ads['ads_banner'].'</p>';
            $ads_inter = '<p class="text-muted" style="line-height:0.5">ads_inter: '.$ads['ads_inter'].'</p>';
            $ads_native = '<p class="text-muted" style="line-height:0.5">ads_native: '.$ads['ads_native'].'</p>';
            $ads_open = '<p class="text-muted" style="line-height:0.5">ads_open: '.$ads['ads_open'].'</p>';
            $ads_reward = '<p class="text-muted" style="line-height:0.5">ads_reward: '.$ads['ads_reward'].'</p>';
//


            if ($record['buildinfo_console']==0  ) {
                $buildinfo_console = 'Trạng thái tĩnh';
            }
            elseif($record['buildinfo_console']== 1){
                $buildinfo_console = '<span class="badge badge-dark">Build App</span>';

            }
            elseif($record['buildinfo_console']==2){
                $buildinfo_console =  '<span class="badge badge-warning">Đang xử lý Build App</span>';
            }
            elseif($record['buildinfo_console']==3){
                $buildinfo_console =  '<span class="badge badge-info">Kết thúc Build App</span>';
            }
            elseif($record['buildinfo_console']==4){
                $buildinfo_console =  '<span class="badge badge-primary">Check Data Project</span>';
            }
            elseif($record['buildinfo_console']==5){
                $buildinfo_console =  '<span class="badge badge-success">Đang xử lý check dữ liệu của Project</span>';
            }
            elseif($record['buildinfo_console']==6){
                $buildinfo_console =  '<span class="badge badge-danger">Kết thúc Check</span>';
            }
//
            if(isset($record->logo)){
                $logo = "<img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/project/$record->projectname/thumbnail/$record->logo'>";
            }else{
                $logo = '<img class="rounded mx-auto d-block" width="100px" height="100px" src="assets\images\logo-sm.png">';
            }
            if ($record->buildinfo_mess){
                $mess_info = '';
                $buildinfo_mess = $record->buildinfo_mess;
                $buildinfo_mess =  (explode('|',$buildinfo_mess));
                $buildinfo_mess = array_reverse($buildinfo_mess);
                for($i = 0 ; $i < 6 ; $i++){
                    if(isset($buildinfo_mess[$i])){
                        $mess_info .=  $buildinfo_mess[$i].'<br>';
                    }
                }

            }
            $data_arr[] = array(
                "updated_at" => $record->updated_at,
                "logo" => $logo,
                "ma_da"=>$data_ma_da.$data_template.$data_projectname.$data_title_app,
                "package" => $package_Oppo.$ads_banner.$ads_inter.$ads_native.$ads_open.$ads_reward,
//                "buildinfo_mess" => $mess_info,
                "buildinfo_console" =>$buildinfo_console,
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

    public function getVivo(Request $request)
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
        $totalRecords = ProjectModel::select('count(*) as allcount')
            ->where('ngocphandang_project.Vivo_package','<>','null')
            ->count();
        $totalRecordswithFilter = ProjectModel::select('count(*) as allcount')
            ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
            ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
            ->where(function ($a) use ($searchValue) {
                $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.Vivo_package', 'like', '%' . $searchValue . '%');
            })
            ->where('ngocphandang_project.Vivo_package','<>','null')
            ->count();


        // Get records, also we have included search filter as well
        $records = ProjectModel::orderBy($columnName, $columnSortOrder)
            ->leftjoin('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
            ->leftjoin('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')

            ->where(function ($a) use ($searchValue) {
                $a->where('ngocphandang_da.ma_da', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.projectname', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.title_app', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_template.template', 'like', '%' . $searchValue . '%')
                    ->orWhere('ngocphandang_project.Vivo_package', 'like', '%' . $searchValue . '%');

            })
            ->where('ngocphandang_project.Vivo_package','<>',null)
            ->select('ngocphandang_project.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="detailVivo('.$record->projectid.')" class="btn btn-outline-warning"><i class="mdi mdi-clipboard-text"></i></a>';
            $ma_da = DB::table('ngocphandang_project')
                ->join('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                ->where('ngocphandang_da.id',$record->ma_da)
                ->first();
            $template = DB::table('ngocphandang_project')
                ->join('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                ->where('ngocphandang_template.id',$record->template)
                ->first();

            if(isset($ma_da)) {
                $data_ma_da =
                    '<span style="line-height:3"> Mã Dự án: ' . $ma_da->ma_da . '</span>';
            }else{
                $data_ma_da = '';
            }
            if(isset($template)) {
                $data_template =  '<p class="text-muted" style="line-height:0.5">Template: '.$template->template.'</p>';
            }else{
                $data_template='';
            }

            if(isset($record->projectname)) {
                $data_projectname =  '<p class="text-muted" style="line-height:0.5">Project: '.$record->projectname.'</p>';
            }else{
                $data_projectname='';
            }

            if(isset($record->title_app)) {
                $data_title_app=  '<p class="text-muted" style="line-height:0.5">'.$record->title_app.'</p>';
            }else{
                $data_title_app='';
            }
            $ads = json_decode($record->Vivo_ads,true);
            $package_Vivo = '<p style="line-height:0.5">'.$record->Vivo_package.'</p>';
            $ads_banner = '<p class="text-muted" style="line-height:0.5">ads_banner: '.$ads['ads_banner'].'</p>';
            $ads_inter = '<p class="text-muted" style="line-height:0.5">ads_inter: '.$ads['ads_inter'].'</p>';
            $ads_native = '<p class="text-muted" style="line-height:0.5">ads_native: '.$ads['ads_native'].'</p>';
            $ads_open = '<p class="text-muted" style="line-height:0.5">ads_open: '.$ads['ads_open'].'</p>';
            $ads_reward = '<p class="text-muted" style="line-height:0.5">ads_reward: '.$ads['ads_reward'].'</p>';
//


            if ($record['buildinfo_console']==0  ) {
                $buildinfo_console = 'Trạng thái tĩnh';
            }
            elseif($record['buildinfo_console']== 1){
                $buildinfo_console = '<span class="badge badge-dark">Build App</span>';

            }
            elseif($record['buildinfo_console']==2){
                $buildinfo_console =  '<span class="badge badge-warning">Đang xử lý Build App</span>';
            }
            elseif($record['buildinfo_console']==3){
                $buildinfo_console =  '<span class="badge badge-info">Kết thúc Build App</span>';
            }
            elseif($record['buildinfo_console']==4){
                $buildinfo_console =  '<span class="badge badge-primary">Check Data Project</span>';
            }
            elseif($record['buildinfo_console']==5){
                $buildinfo_console =  '<span class="badge badge-success">Đang xử lý check dữ liệu của Project</span>';
            }
            elseif($record['buildinfo_console']==6){
                $buildinfo_console =  '<span class="badge badge-danger">Kết thúc Check</span>';
            }
//
            if(isset($record->logo)){
                $logo = "<img class='rounded mx-auto d-block'  width='100px'  height='100px'  src='../uploads/project/$record->projectname/thumbnail/$record->logo'>";
            }else{
                $logo = '<img class="rounded mx-auto d-block" width="100px" height="100px" src="assets\images\logo-sm.png">';
            }
            if ($record->buildinfo_mess){
                $mess_info = '';
                $buildinfo_mess = $record->buildinfo_mess;
                $buildinfo_mess =  (explode('|',$buildinfo_mess));
                $buildinfo_mess = array_reverse($buildinfo_mess);
                for($i = 0 ; $i < 6 ; $i++){
                    if(isset($buildinfo_mess[$i])){
                        $mess_info .=  $buildinfo_mess[$i].'<br>';
                    }
                }

            }
            $data_arr[] = array(
                "updated_at" => $record->updated_at,
                "logo" => $logo,
                "ma_da"=>$data_ma_da.$data_template.$data_projectname.$data_title_app,
                "package" => $package_Vivo.$ads_banner.$ads_inter.$ads_native.$ads_open.$ads_reward,
//                "buildinfo_mess" => $mess_info,
                "buildinfo_console" =>$buildinfo_console,
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
            'projectname' =>'required|unique:ngocphandang_project,projectname',
            'ma_da' => 'required|not_in:0',
            'template' => 'required|not_in:0',
            'title_app' =>'required',
            'buildinfo_vernum' =>'required',
            'buildinfo_verstr' =>'required',
            'logo' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $message = [
            'projectname.unique'=>'Tên Project đã tồn tại',
            'projectname.required'=>'Tên Project không để trống',
            'ma_da.required'=>'Mã dự án không để trống',
            'template.required'=>'Mã template không để trống',
            'ma_da.not_in'=>'Mã dự án không để trống',
            'template.not_in'=>'Mã template không để trống',
            'title_app.required'=>'Tiêu đề ứng không để trống',
            'buildinfo_vernum.required'=>'Version Number không để trống',
            'buildinfo_verstr.required'=>'Version String không để trống',
            'logo.mimes'=>'Logo không đúng định dạng: jpeg, png, jpg, gif, svg.',
            'logo.max'=>'Logo max: 2M.',
        ];
        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }

        $Chplay_ads = [
            'ads_id' => $request->Chplay_ads_id,
            'ads_banner' => $request->Chplay_ads_banner,
            'ads_inter' => $request->Chplay_ads_inter,
            'ads_reward' => $request->Chplay_ads_reward,
            'ads_native' => $request->Chplay_ads_native,
            'ads_open' => $request->Chplay_ads_open
        ];
        $Chplay_ads =  json_encode($Chplay_ads);

        $Amazon_ads = [
            'ads_id' => $request->Amazon_ads_id,
            'ads_banner' => $request->Amazon_ads_banner,
            'ads_inter' => $request->Amazon_ads_inter,
            'ads_reward' => $request->Amazon_ads_reward,
            'ads_native' => $request->Amazon_ads_native,
            'ads_open' => $request->Amazon_ads_open
        ];
        $Amazon_ads =  json_encode($Amazon_ads);

        $Samsung_ads = [
            'ads_id' => $request->Samsung_ads_id,
            'ads_banner' => $request->Samsung_ads_banner,
            'ads_inter' => $request->Samsung_ads_inter,
            'ads_reward' => $request->Samsung_ads_reward,
            'ads_native' => $request->Samsung_ads_native,
            'ads_open' => $request->Samsung_ads_open
        ];
        $Samsung_ads =  json_encode($Samsung_ads);

        $Xiaomi_ads = [
            'ads_id' => $request->Xiaomi_ads_id,
            'ads_banner' => $request->Xiaomi_ads_banner,
            'ads_inter' => $request->Xiaomi_ads_inter,
            'ads_reward' => $request->Xiaomi_ads_reward,
            'ads_native' => $request->Xiaomi_ads_native,
            'ads_open' => $request->Xiaomi_ads_open
        ];
        $Xiaomi_ads =  json_encode($Xiaomi_ads);

        $Oppo_ads = [
            'ads_id' => $request->Oppo_ads_id,
            'ads_banner' => $request->Oppo_ads_banner,
            'ads_inter' => $request->Oppo_ads_inter,
            'ads_reward' => $request->Oppo_ads_reward,
            'ads_native' => $request->Oppo_ads_native,
            'ads_open' => $request->Oppo_ads_open
        ];
        $Oppo_ads =  json_encode($Oppo_ads);

        $Vivo_ads = [
            'ads_id' => $request->Vivo_ads_id,
            'ads_banner' => $request->Vivo_ads_banner,
            'ads_inter' => $request->Vivo_ads_inter,
            'ads_reward' => $request->Vivo_ads_reward,
            'ads_native' => $request->Vivo_ads_native,
            'ads_open' => $request->Vivo_ads_open
        ];
        $Vivo_ads =  json_encode($Vivo_ads);

        $data = new ProjectModel();
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
        $data['link_store_vietmmo'] = $request->link_store_vietmmo;
        $data['buildinfo_mess'] = 'Trạng thái tĩnh';

        $data['Chplay_package'] = $request->Chplay_package;
        $data['Chplay_buildinfo_store_name_x'] = $request->Chplay_buildinfo_store_name_x;
        $data['Chplay_buildinfo_link_store'] = $request->Chplay_buildinfo_link_store;
        $data['Chplay_buildinfo_email_dev_x'] = $request->Chplay_buildinfo_email_dev_x;
        $data['Chplay_buildinfo_link_app'] = $request->Chplay_buildinfo_link_app;
        $data['Chplay_ads'] = $Chplay_ads;
        $data['Chplay_status'] = 0;

        $data['Amazon_package'] = $request->Amazon_package;
        $data['Amazon_buildinfo_store_name_x'] = $request->Amazon_buildinfo_store_name_x;
        $data['Amazon_buildinfo_link_store'] = $request->Amazon_buildinfo_link_store;
        $data['Amazon_buildinfo_email_dev_x'] = $request->Amazon_buildinfo_email_dev_x;
        $data['Amazon_buildinfo_link_app'] = $request->Amazon_buildinfo_link_app;
        $data['Amazon_ads'] = $Amazon_ads;
        $data['Amazon_status'] = 0;

        $data['Samsung_package'] = $request->Samsung_package;
        $data['Samsung_buildinfo_store_name_x'] = $request->Samsung_buildinfo_store_name_x;
        $data['Samsung_buildinfo_link_store'] = $request->Samsung_buildinfo_link_store;
        $data['Samsung_buildinfo_email_dev_x'] = $request->Samsung_buildinfo_email_dev_x;
        $data['Samsung_buildinfo_link_app'] = $request->Samsung_buildinfo_link_app;
        $data['Samsung_ads'] = $Samsung_ads;
        $data['Samsung_status'] = 0;

        $data['Xiaomi_package'] = $request->Xiaomi_package;
        $data['Xiaomi_buildinfo_store_name_x'] = $request->Xiaomi_buildinfo_store_name_x;
        $data['Xiaomi_buildinfo_link_store'] = $request->Xiaomi_buildinfo_link_store;
        $data['Xiaomi_buildinfo_email_dev_x'] = $request->Xiaomi_buildinfo_email_dev_x;
        $data['Xiaomi_buildinfo_link_app'] = $request->Xiaomi_buildinfo_link_app;
        $data['Xiaomi_ads'] = $Xiaomi_ads;
        $data['Xiaomi_status'] = 0;

        $data['Oppo_package'] = $request->Oppo_package;
        $data['Oppo_buildinfo_store_name_x'] = $request->Oppo_buildinfo_store_name_x;
        $data['Oppo_buildinfo_link_store'] = $request->Oppo_buildinfo_link_store;
        $data['Oppo_buildinfo_email_dev_x'] = $request->Oppo_buildinfo_email_dev_x;
        $data['Oppo_buildinfo_link_app'] = $request->Oppo_buildinfo_link_app;
        $data['Oppo_ads'] = $Oppo_ads;
        $data['Oppo_status'] = 0;

        $data['Vivo_package'] = $request->Vivo_package;
        $data['Vivo_buildinfo_store_name_x'] = $request->Vivo_buildinfo_store_name_x;
        $data['Vivo_buildinfo_link_store'] = $request->Vivo_buildinfo_link_store;
        $data['Vivo_buildinfo_email_dev_x'] = $request->Vivo_buildinfo_email_dev_x;
        $data['Vivo_buildinfo_link_app'] = $request->Vivo_buildinfo_link_app;
        $data['Vivo_ads'] = $Vivo_ads;
        $data['Vivo_status'] = 0;

        if(isset($request->logo)){
            $image = $request->file('logo');
            $data['logo'] = 'logo_'.time().'.'.$image->extension();
            $destinationPath = public_path('uploads/project/'.$request->projectname.'/thumbnail/');
            $img = Image::make($image->path());
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 777, true);
            }
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.$data['logo']);
            $destinationPath = public_path('uploads/project/'.$request->projectname);
            $image->move($destinationPath, $data['logo']);
        }
        $data->save();
        return response()->json(['success'=>'Thêm mới thành công']);
    }
    public function edit($id)
    {

        $policy = '';
        $policy = '';

        $project = ProjectModel::where('projectid',$id)->first();
        $policy = Template::select('policy1','policy2')->where('id',$project->template)->first();
        $store_name= Dev::select('store_name')->where('id',$project->Chplay_buildinfo_store_name_x)->first();
        $da= Da::select('ma_da')->where('id',$project->ma_da)->first();
        $template= Template::select('template')->where('id',$project->template)->first();

        return response()->json([$project,$policy,$store_name,$da,$template]);
    }

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
            'logo' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $message = [
            'projectname.unique'=>'Tên Project đã tồn tại',
            'projectname.required'=>'Tên Project không để trống',
            'ma_da.required'=>'Mã dự án không để trống',
            'template.required'=>'Mã template không để trống',
            'title_app.required'=>'Tiêu đề ứng không để trống',
            'buildinfo_vernum.required'=>'Version Number không để trống',
            'buildinfo_verstr.required'=>'Version String không để trống',
            'logo.mimes'=>'Logo không đúng định dạng: jpeg, png, jpg, gif, svg.',
            'logo.max'=>'Logo max: 2M.',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }


        $Chplay_ads = [
            'ads_id' => $request->Chplay_ads_id,
            'ads_banner' => $request->Chplay_ads_banner,
            'ads_inter' => $request->Chplay_ads_inter,
            'ads_reward' => $request->Chplay_ads_reward,
            'ads_native' => $request->Chplay_ads_native,
            'ads_open' => $request->Chplay_ads_open
        ];
        $Chplay_ads =  json_encode($Chplay_ads);

        $Amazon_ads = [
            'ads_id' => $request->Amazon_ads_id,
            'ads_banner' => $request->Amazon_ads_banner,
            'ads_inter' => $request->Amazon_ads_inter,
            'ads_reward' => $request->Amazon_ads_reward,
            'ads_native' => $request->Amazon_ads_native,
            'ads_open' => $request->Amazon_ads_open
        ];
        $Amazon_ads =  json_encode($Amazon_ads);

        $Samsung_ads = [
            'ads_id' => $request->Samsung_ads_id,
            'ads_banner' => $request->Samsung_ads_banner,
            'ads_inter' => $request->Samsung_ads_inter,
            'ads_reward' => $request->Samsung_ads_reward,
            'ads_native' => $request->Samsung_ads_native,
            'ads_open' => $request->Samsung_ads_open
        ];
        $Samsung_ads =  json_encode($Samsung_ads);

        $Xiaomi_ads = [
            'ads_id' => $request->Xiaomi_ads_id,
            'ads_banner' => $request->Xiaomi_ads_banner,
            'ads_inter' => $request->Xiaomi_ads_inter,
            'ads_reward' => $request->Xiaomi_ads_reward,
            'ads_native' => $request->Xiaomi_ads_native,
            'ads_open' => $request->Xiaomi_ads_open
        ];
        $Xiaomi_ads =  json_encode($Xiaomi_ads);

        $Oppo_ads = [
            'ads_id' => $request->Oppo_ads_id,
            'ads_banner' => $request->Oppo_ads_banner,
            'ads_inter' => $request->Oppo_ads_inter,
            'ads_reward' => $request->Oppo_ads_reward,
            'ads_native' => $request->Oppo_ads_native,
            'ads_open' => $request->Oppo_ads_open
        ];
        $Oppo_ads =  json_encode($Oppo_ads);

        $Vivo_ads = [
            'ads_id' => $request->Vivo_ads_id,
            'ads_banner' => $request->Vivo_ads_banner,
            'ads_inter' => $request->Vivo_ads_inter,
            'ads_reward' => $request->Vivo_ads_reward,
            'ads_native' => $request->Vivo_ads_native,
            'ads_open' => $request->Vivo_ads_open
        ];
        $Vivo_ads =  json_encode($Vivo_ads);

        $data = ProjectModel::find($id);


        $data->template = $request->template;
        $data->ma_da = $request->ma_da;
        $data->title_app = $request->title_app;
        $data->buildinfo_app_name_x =  $request->buildinfo_app_name_x;
        $data->buildinfo_link_policy_x = $request->buildinfo_link_policy_x;
        $data->buildinfo_link_fanpage = $request->buildinfo_link_fanpage;
        $data->buildinfo_link_website =  $request->buildinfo_link_website;
        $data->buildinfo_link_youtube_x = $request->buildinfo_link_youtube_x;
        $data->buildinfo_api_key_x = $request->buildinfo_api_key_x;
        $data->buildinfo_vernum= $request->buildinfo_vernum;
        $data->buildinfo_verstr = $request->buildinfo_verstr;
        $data->buildinfo_keystore = $request->buildinfo_keystore;
        $data->buildinfo_sdk = $request->buildinfo_sdk;
        $data->link_store_vietmmo = $request->link_store_vietmmo;

        $data->Chplay_package = $request->Chplay_package;
        $data->Chplay_buildinfo_store_name_x = $request->Chplay_buildinfo_store_name_x;
        $data->Chplay_buildinfo_link_store = $request->Chplay_buildinfo_link_store;
        $data->Chplay_buildinfo_link_app = $request->Chplay_buildinfo_link_app;
        $data->Chplay_buildinfo_email_dev_x = $request->Chplay_buildinfo_email_dev_x;
        $data->Chplay_ads = $Chplay_ads;
        $data->update(['Chplay_bot->log_status' => $data->Chplay_status]);
//        $data->Chplay_bot->log_status = $data->Chplay_bot->log_status.'|'.$data->Chplay_status;
        $data->Chplay_status = $request->Chplay_status;

        $data->Amazon_package = $request->Amazon_package;
        $data->Amazon_buildinfo_store_name_x = $request->Amazon_buildinfo_store_name_x;
        $data->Amazon_buildinfo_link_store = $request->Amazon_buildinfo_link_store;
        $data->Amazon_buildinfo_link_app = $request->Amazon_buildinfo_link_app;
        $data->Amazon_buildinfo_email_dev_x = $request->Amazon_buildinfo_email_dev_x;
        $data->Amazon_ads = $Amazon_ads;
        $data->Amazon_status = $request->Amazon_status;

        $data->Samsung_package = $request->Samsung_package;
        $data->Samsung_buildinfo_store_name_x = $request->Samsung_buildinfo_store_name_x;
        $data->Samsung_buildinfo_link_store = $request->Samsung_buildinfo_link_store;
        $data->Samsung_buildinfo_link_app = $request->Samsung_buildinfo_link_app;
        $data->Samsung_buildinfo_email_dev_x = $request->Samsung_buildinfo_email_dev_x;
        $data->Samsung_ads = $Samsung_ads;
        $data->Samsung_status = $request->Samsung_status;

        $data->Xiaomi_package = $request->Xiaomi_package;
        $data->Xiaomi_buildinfo_store_name_x = $request->Xiaomi_buildinfo_store_name_x;
        $data->Xiaomi_buildinfo_link_store = $request->Xiaomi_buildinfo_link_store;
        $data->Xiaomi_buildinfo_link_app = $request->Xiaomi_buildinfo_link_app;
        $data->Xiaomi_buildinfo_email_dev_x = $request->Xiaomi_buildinfo_email_dev_x;
        $data->Xiaomi_ads = $Xiaomi_ads;
        $data->Xiaomi_status = $request->Xiaomi_status;

        $data->Oppo_package = $request->Oppo_package;
        $data->Oppo_buildinfo_store_name_x = $request->Oppo_buildinfo_store_name_x;
        $data->Oppo_buildinfo_link_store = $request->Oppo_buildinfo_link_store;
        $data->Oppo_buildinfo_link_app = $request->Oppo_buildinfo_link_app;
        $data->Oppo_buildinfo_email_dev_x = $request->Oppo_buildinfo_email_dev_x;
        $data->Oppo_ads = $Oppo_ads;
        $data->Oppo_status = $request->Oppo_status;

        $data->Vivo_package = $request->Vivo_package;
        $data->Vivo_buildinfo_store_name_x = $request->Vivo_buildinfo_store_name_x;
        $data->Vivo_buildinfo_link_store = $request->Vivo_buildinfo_link_store;
        $data->Vivo_buildinfo_link_app = $request->Vivo_buildinfo_link_app;
        $data->Vivo_buildinfo_email_dev_x = $request->Vivo_buildinfo_email_dev_x;
        $data->Vivo_ads = $Vivo_ads;
        $data->Vivo_status = $request->Vivo_status;
        if($data->logo){
            if($data->projectname <> $request->projectname){
                $dir = (public_path('uploads/project/'));
                rename($dir.$data->projectname, $dir.$request->projectname);
            }
        }
        if($request->logo){
            $image = $request->file('logo');
            $data['logo'] = 'logo_'.time().'.'.$image->extension();
            $destinationPath = public_path('uploads/project/'.$request->projectname.'/thumbnail/');
            $img = Image::make($image->path());
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 777, true);
            }
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.$data['logo']);
            $destinationPath = public_path('uploads/project/'.$request->projectname);
            $image->move($destinationPath, $data['logo']);
        }
        $data->projectname = $request->projectname;
        $data->save();
        return response()->json(['success'=>'Cập nhật thành công']);
    }

    public function updateQuick(Request $request){
        $id = $request->project_id;

        ProjectModel::updateOrCreate(
            [
                "projectid" => $id,

            ],
            [
                "buildinfo_vernum" => $request->buildinfo_vernum,
                'buildinfo_verstr' => $request->buildinfo_verstr,
                'buildinfo_console' => $request->buildinfo_console,
                'buildinfo_mess' => 'Chờ xử lý',
                'time_mess' => time(),
                'buildinfo_time' =>time(),

            ]);
        return response()->json(['success'=>'Cập nhật thành công']);


    }
    public function updateStatus(Request $request){
        $data = ProjectModel::where('projectid',$request->project_id)->first();
        ProjectModel::updateOrCreate(
            [
                "projectid" => $request->project_id,

            ],
            [
                "Chplay_status" => $request->Chplay_status,
                'Chplay_bot->log_status' => $data->Chplay_status,
            ]);
        return response()->json(['success'=>'Cập nhật thành công']);


    }


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

    public function removeProject($id){

        $project = ProjectModel::where('projectid',$id)->first();

        ProjectModel::updateOrCreate(
            [
                "projectid" => $id,
            ],
            [
                'buildinfo_console' => 0,
                'buildinfo_mess' => '',
                'time_mess' =>time(),
                'buildinfo_time' => time(),

            ]);
        $log_mess = log::where('projectname',$project->projectname)->first();
        if($log_mess){
            $mess = $log_mess->buildinfo_mess .'|'.$project->buildinfo_mess;
        }else{
            $mess = $project->buildinfo_mess;
        }
        log::updateOrCreate(
            [
                "projectname" => $project->projectname,
            ],
            [
                'buildinfo_mess' => $mess
            ]
        );
        return response()->json(['success'=>'Cập nhật thành công']);
    }

    public function checkbox($id){
        $data = ProjectModel::find($id);
        ProjectModel::updateOrCreate(
            [
                "projectid" => $data->projectid,
            ],
            [
                'Chplay_status' => 7,
                'Chplay_bot->log_status' => $data->Chplay_status,
                'Chplay_bot->installs' => 0,
               'Chplay_bot->numberVoters' => 0,
               'Chplay_bot->numberReviews' => 0,
               'Chplay_bot->score' => 0,
               'Chplay_bot->appVersion' => $data->buildinfo_verstr,
               'Chplay_bot->privacyPoliceUrl' => 0,
               'Chplay_bot->released' => time(),
               'Chplay_bot->updated' => time(),
               'Chplay_bot->logo' =>  '../uploads/project/'.$data->projectname.'/thumbnail/'.$data->logo,
               'Chplay_bot->bot_name_dev' => 0,
            ]
        );
        return response()->json(['success'=> $data->projectname.' đang chờ duyệt']);


    }
}
