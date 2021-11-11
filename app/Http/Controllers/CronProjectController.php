<?php

namespace App\Http\Controllers;

use App\Models\ProjectModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Nelexa\GPlay\GPlayApps;

class CronProjectController extends Controller
{
    public function index(){
        dd(1);
    }
    public function Chplay(){
       $appsChplay = ProjectModel::where('Chplay_status','<>',3)->get();

       foreach ($appsChplay as $appChplay){
           $package = $appChplay->Chplay_package;
           if(isset($package)){
               $log_status =$appChplay->Chplay_status;
               if($appChplay->Chplay_bot != ''){
                   $log_status = json_decode($appChplay->Chplay_bot,true)['log_status'];
                   if($log_status == $appChplay->Chplay_status){
                       $log_status = $log_status;
                   }else{
                       $log_status =  $appChplay->Chplay_status;
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
    }

    public function getPackage(Request $request)
    {
        if ($request->id) {
            $package = $request->id;
            $appInfo = new GPlayApps();
            $existApp =  $appInfo->existsApp($package);
            if($existApp){
                $appInfo = $appInfo->getAppInfo($package);
//                dd($appInfo);



                echo 'logo: <a target= "_blank" href="'.$appInfo->getUrl().'"> <img src="'.$appInfo->getIcon()->getUrl() .'" width="30" height="30"></a><br>';
                echo 'Install: '.number_format($appInfo->getInstalls()) .'<br>';
                echo 'numberVoters: '.number_format($appInfo->getNumberVoters()) .'<br>';
                echo 'numberReviews: '.number_format($appInfo->getNumberReviews()) .'<br>';
                echo 'score: '. number_format($appInfo->getScore(),2) .'<br>';
                echo 'appVersion: '.$appInfo->getAppVersion() .'<br>';

                return;


//                if($request->json == 1){
//                    return json_encode($data,true);
//                }
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                die();
            }else{
                return 'Package không tồn tại';
            }

        }
        return URL::current().'?id=xyz';
    }
}
