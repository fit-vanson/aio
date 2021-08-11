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
               $log_status ='0|7'.$appChplay->Chplay_status;
               if($appChplay->Chplay_bot != ''){
                   $log_status = json_decode($appChplay->Chplay_bot,true)['log_status'];
                   $status_old = explode('|',$log_status);
                   $status_old =  $status_old[count($status_old)-1];
                   if($status_old == $appChplay->Chplay_status){
                       $log_status = $log_status;
                   }else{
                       $log_status =  $log_status. '|'.$appChplay->Chplay_status;
                   }
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
                       'score' => $appInfo->getScore(),
                       'appVersion' => $appInfo->getAppVersion(),
                       'privacyPoliceUrl' => $appInfo->getPrivacyPoliceUrl(),
                       'released' => $appInfo->getReleased(),
                       'updated' => $appInfo->getUpdated(),
                       'bot_name_dev' => $appInfo->getDeveloper(),
                       'logo' => $appInfo->getIcon()->getUrl(),
                       'log_status'=>$log_status,
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
                       'log_status'=>$log_status,
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
        echo '<br>'.'Trở lại sau 3s';
        echo '<META http-equiv="refresh" content="3;URL=' . url("/project/appChplay") . '">';
    }
}
