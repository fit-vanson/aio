<?php

namespace App\Http\Controllers;

use App\Models\Dev_Huawei;
use App\Models\ProjectModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Nelexa\GPlay\GPlayApps;

class CronProjectController extends Controller

{
    private  $domain = 'https://connect-api.cloud.huawei.com';
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
        if ($request->id){
            $pattern = "/^C+[0-9].*/i";
            $regex = preg_match($pattern,$request->id);
            if($regex != 1){
                $package = $request->id;
                $appInfo = new GPlayApps();
                $existApp =  $appInfo->existsApp($package);
                if($existApp){
                    $appInfo = $appInfo->getAppInfo($package);
                    echo $appInfo->getIcon();
                    echo ' | '. $appInfo->getName();
                    echo ' | '. $appVersion = ($appInfo->getAppVersion() != null)  ? $appInfo->getAppVersion() : 'null';
                    echo ' | '. $score = ($appInfo->getScore() != null)  ? number_format($appInfo->getScore(),1) : 'null';
                    echo ' | '. $install =  ($appInfo->getInstalls() != null)  ? number_format($appInfo->getInstalls()) : 'null';
                    return;
                }else{
                    return 'null';
                }
            }else{
                $ch = curl_init("https://web-dra.hispace.dbankcloud.cn/uowap/index?method=internal.getTabDetail&uri=app|".$request->id); // such as http://example.com/example.xml
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                $data = curl_exec($ch);
                $data = json_decode($data,true);
                if(count($data['layoutData'])>0)
                {
                    echo '<a href="https://appgallery.cloud.huawei.com/appdl/'.$request->id.'"> Download: '.$data['layoutData'][0]['dataList'][0]['name'].'</a>';
                    return;
                }else{
                    return 'null';
                }
                curl_close($ch);
                return;
            }
        }
        return URL::current().'?id=xyz';
    }

    function array_search_id($search_value, $array, $id_path) {

        if(is_array($array) && count($array) > 0) {

            foreach($array as $key => $value) {

                $temp_path = $id_path;

                // Adding current key to search path
                array_push($temp_path, $key);

                // Check if this value is an array
                // with atleast one element
                if(is_array($value) && count($value) > 0) {
                    $res_path = $this->array_search_id(
                        $search_value, $value, $temp_path);

                    if ($res_path != null) {
                        return $res_path;
                    }
                }
                else if($value == $search_value) {
                    return join(" --> ", $temp_path);
                }
            }
        }

        return null;
    }

    public function Huawei(){
        ini_set('max_execution_time', 600);
        $appsHuawei = Dev_Huawei::with('project')->get();
        foreach ($appsHuawei as $appHuawei){
            $token = $this->getTokenHuawei($this->domain,$appHuawei->huawei_dev_client_id, $appHuawei->huawei_dev_client_secret);
            $i = 1;
            foreach ($appHuawei->project as $project){
                if($project->Huawei_appId){
                    echo '<br/>'.$i .'Dang chay:  '.  '-'. $project->Huawei_appId .' - '. Carbon::now('Asia/Ho_Chi_Minh');
                    $Huawei_appId = $project->Huawei_appId;
                    $appInfo = $this->AppInfoHuawei($this->domain,$token,$appHuawei->huawei_dev_client_id,$Huawei_appId);
                    $reportApp = $this->reportAppHuawei($this->domain,$token,$appHuawei->huawei_dev_client_id,$Huawei_appId);
                    $file = $this->readCSV($reportApp['fileURL'],array('delimiter' => ','));
                    $monthCron = Carbon::now()->format('Ym');
                    $dataArr =[
                        'Month' => $monthCron,
                        'Impressions' => $file ? $file['Impressions'] : 0,
                        'Details_page_views' => $file ? $file['Details page views'] : 0,
                        'Total_downloads' => $file ? $file['Total downloads'] : 0 ,
                        'Uninstalls' => $file ? $file['Uninstalls (installed from AppGallery)'] : 0,
                        'updateTime' =>  $appInfo['appInfo']['updateTime'],
                    ];
                    if($project->Huawei_bot == null){
                        $data = array_merge([$dataArr]);
                    }else{
                        $dataBot = json_decode($project->Huawei_bot,true);
                        $checkMonth =$this->searchForMonth($monthCron,$dataBot);
                        if($checkMonth !== false){
                            unset($dataBot[$checkMonth]);
                            $data =  array_merge($dataBot,[$dataArr]);
                        }else{
                            $data =  array_merge($dataBot,[$dataArr]);
                        }
                        array_multisort($data);
                    }

                    ProjectModel::updateOrCreate(
                        [
                            'projectid'=> $project->projectid
                        ],
                        [
                            'Huawei_status' => $appInfo['appInfo']['releaseState'],
                            'Huawei_bot' => json_encode($data)
                        ]
                    );
                    $i++;
                }
            }
        }
    }


    public function getTokenHuawei($domain,$clientID,$clientSecret){
        $token = '';
        $endpoint = "/api/oauth2/v1/token";
        $dataArr = array(
            'grant_type' => 'client_credentials',
            'client_id' => $clientID,
            'client_secret' => $clientSecret,
        );
        try {
            $response = Http::withHeaders([
                'Content-Type: application/json',
            ])->post($domain.$endpoint, $dataArr);

            if ($response->successful()){
                $result = $response->json();
                $token = $result['access_token'];
            }
        }catch (\Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . '--- Token: ' . $exception->getLine());
        }
        return $token;
    }

    public function AppInfoHuawei($domain,$token,$clientID,$appID){
        $data = '';
        $dataArr = [
            'Authorization'=> 'Bearer ' . $token,
            'client_id'=>$clientID,
            'Content-Type'=>'application/json',
        ];
        $endpoint = "/api/publish/v2/app-info?appid=".$appID;
        try {
            $response = Http::withHeaders($dataArr)->get($domain . $endpoint);
            if ($response->successful()){
                $data = $response->json();
            }
        }catch (\Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . '--- AppInfo: ' . $exception->getLine());
        }
        return $data;
    }

    public function reportAppHuawei($domain,$token,$clientID,$appID){
        $data = '';
        $startTime  =  Carbon::now()->startOfMonth()->format('Ymd');
        $endTime    =  Carbon::now()->format('Ymd');
        $lang='en-US';
        $endpoint = '/api/report/distribution-operation-quality/v1/appDownloadExport/'.$appID.'?language='.$lang.'&startTime='.$startTime.'&endTime='.$endTime.'&groupBy=businessType';
        $dataArr = [
            'Authorization'=> 'Bearer ' . $token,
            'client_id'=>$clientID,
            'Content-Type'=>'application/json',
        ];
        try {
            $response = Http::withHeaders($dataArr)->get($domain . $endpoint);
            if ($response->successful()){
                $data = $response->json();
            }
        }catch (\Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . '--- reportApp: ' . $exception->getLine());
        }
        return $data;
    }


    public function getReviewsHuawei($domain,$token,$clientID,$appID){
        $data = '';
        $dataArr = [
            'Authorization'=> 'Bearer ' . $token,
            'client_id'=>$clientID,
            'Content-Type'=>'application/json',
        ];
        $countries = 'US';
        $lang='US';
        $beginTime = Carbon::now()->subDays(7)->valueOf();
        $endTime = Carbon::now()->valueOf();
        $endpoint = '/api/reviews/v1/manage/dev/reviews?appid='.$appID.'&countries='.$countries.'&language='.$lang.'&beginTime='.$beginTime.'&endTime='.$endTime;
        try {
            $response = Http::withHeaders($dataArr)->get($domain . $endpoint);
            if ($response->successful()){
                $data = $response->json();
            }
        }catch (\Exception $exception) {
            Log::error('Message:' . $exception->getMessage() . '--- getReviews: ' . $exception->getLine());
        }
        return $data;
    }


    public function readCSV($csvFile, $array){
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 0, $array['delimiter']);
        }
        fclose($file_handle);
        $header = array_shift($line_of_text);
        $rows = array_filter($line_of_text);
        $data = [];
        foreach ($rows as $row){
            $data = array_combine($header, $row) ;
        }
        return $data;
    }
    public function searchForMonth($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['Month'] === $id) {
                return $key;
            }
        }
        return false;
    }
}
