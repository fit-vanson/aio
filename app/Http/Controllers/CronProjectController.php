<?php

namespace App\Http\Controllers;

use App\Models\ProjectModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Nelexa\GPlay\GPlayApps;

class CronProjectController extends Controller
{
    public function index(){
        dd(1);
    }
    public function Chplay(){
       $appsChplay = ProjectModel::where('Chplay_status','<>',3)->where('Chplay_status','<>',0)->get();

       foreach ($appsChplay as $appChplay){
           $package = $appChplay->Chplay_package;
           if(isset($package)){
               $log_status ='0|7';
               if($appChplay->Chplay_bot != ''){
                   $log_status = json_decode($appChplay->Chplay_bot,true)['log_status'];
               }
               $appInfo = new GPlayApps();
               $existApp =  $appInfo->existsApp($package);
               if($existApp){
                   $appInfo = $appInfo->getAppInfo($package);
                   $status = 1;
                   $data = [
                       'installs' => $appInfo->getInstalls(),
                       'numberVoters' => $appInfo->getNumberVoters(),
                       'numberReviews' => $appInfo->getNumberReviews(),
                       'score' => $appInfo->getNumberReviews(),
                       'appVersion' => $appInfo->getNumberReviews(),
                       'privacyPoliceUrl' => $appInfo->getNumberReviews(),
                       'released' => $appInfo->getNumberReviews(),
                       'updated' => $appInfo->getNumberReviews(),
                       'bot_name_dev' => $appInfo->getDeveloper(),
                       'logo' => $appInfo->getIcon()->getUrl(),
                       'log_status'=>$log_status. '|'.$appChplay->Chplay_status,
                   ];
               }else{
                   $status = 6;
                   $data = [
                       'installs' => 0,
                       'numberVoters' => 0,
                       'numberReviews' => 0,
                       'score' => 0,
                       'appVersion' => 0,
                       'privacyPoliceUrl' => 0,
                       'released' => 0,
                       'updated' => 0,
                       'bot_name_dev' => 0,
                       'logo' => '../uploads/project/'.$appChplay->projectname.'/thumbnail/'.$appChplay->logo,
                       'log_status'=>$log_status. '|'.$appChplay->Chplay_status,
                   ];
               }
               $data = json_encode($data);
               ProjectModel::updateOrCreate(
                   [
                       "projectid" => $appChplay->projectid,
                   ],
                   [
                       "Chplay_status" => $status,
                       "Chplay_bot" => $data,
                       'bot_timecheck' => time(),
                   ]);
               echo '<br/>'.'Dang chay:  ' . $appChplay->Chplay_package .' - '. Carbon::now('Asia/Ho_Chi_Minh');
           }
       }
    }
}
