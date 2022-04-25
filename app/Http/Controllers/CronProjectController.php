<?php

namespace App\Http\Controllers;

use App\Models\Dev_Huawei;
use App\Models\Dev_Vivo;
use App\Models\ProjectModel;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Nelexa\GPlay\GPlayApps;

class CronProjectController extends Controller

{
    private  $domain = 'https://connect-api.cloud.huawei.com';

    // Vivo
    private $SIGN_METHOD_HMAC = "hmac-sha256";
    private $domainVivo = 'https://developer-api.vivo.com/router/rest';
    private $access_key =  '0987226aea07435e9b8a0fabcd38e7cd';
    private $accessSecret = '1bcc877c4e6a41a18a4ecc1419d07cbc';

    public function index(){
        dd(1);
    }
    public function Chplay(){
        ini_set('max_execution_time', 600);
        Artisan::call('optimize:clear');
        $time =  Setting::first();
        $timeCron = Carbon::now()->subMinutes($time->time_cron)->setTimezone('Asia/Ho_Chi_Minh')->timestamp;
        $appsChplay = ProjectModel::where('Chplay_status','<>',3)
           ->where('bot_timecheck','<=',$timeCron)
           ->where('Chplay_package','<>','null')
           ->limit(10)
           ->get();
       if($appsChplay){
           foreach ($appsChplay as $appChplay){
               $package = $appChplay->Chplay_package;
               echo '<br/>'.'Dang chay:  '.  '-'. $appChplay->projectname .' - '. Carbon::now('Asia/Ho_Chi_Minh');
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
                   ]
               );
           }
       }
       if(count($appsChplay)==0){
            echo 'Chưa đến time cron'.PHP_EOL .'<br>';
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
        Artisan::call('optimize:clear');
        $time =  Setting::first();
        $timeCron = Carbon::now()->subMinutes($time->time_cron)->setTimezone('Asia/Ho_Chi_Minh');
        $dev_huawei = Dev_Huawei::where('huawei_dev_client_id','<>',null)
            ->where('huawei_dev_client_secret','<>',null)
            ->get();
        foreach ($dev_huawei as $dev){
            Dev_Huawei::updateorCreate(
                [
                    'id' =>$dev->id
                ],
                [
                    'token' => $this->getTokenHuawei($this->domain,$dev->huawei_dev_client_id, $dev->huawei_dev_client_secret)
                ]
            );
        }
        $appsHuawei = ProjectModel::with('dev_huawei')
            ->whereHas('dev_huawei', function ($q)  {
                $q->where('huawei_dev_client_id','<>',null);
            })
            ->where('Huawei_bot->time_bot','<=',$timeCron)
            ->where('Huawei_appId','<>','null')
            ->limit(10)
            ->get();

        echo '<br/><b>'.'Yêu cầu:';
        echo '<br/>&emsp;'.'- Project có AppID trong tab Huawei.';
        echo '<br/>&emsp;'.'- Dev Huawei có Client ID và Client Secret'.'</b><br/><br/>';

        if($appsHuawei){
            foreach ($appsHuawei as $appHuawei){
                echo '<br/>'.'Dang chay:  '.  '-'. $appHuawei->Huawei_appId .' - '. Carbon::now('Asia/Ho_Chi_Minh');
                $Huawei_appId = $appHuawei->Huawei_appId;
                $appInfo = $this->AppInfoHuawei($this->domain,$appHuawei->dev_huawei->token,$appHuawei->dev_huawei->huawei_dev_client_id,$Huawei_appId);
                $reportApp = $this->reportAppHuawei($this->domain,$appHuawei->dev_huawei->token,$appHuawei->dev_huawei->huawei_dev_client_id,$Huawei_appId);
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

    //                    if($appHuawei->Huawei_bot == null){
    //                        $data = array_merge([$dataArr]);
    //                    }else{
                    $dataBot = json_decode($appHuawei->Huawei_bot,true);
    //                        dd($dataBot);
                    $checkMonth =$this->searchForMonth($monthCron,$dataBot);
                    if($checkMonth !== false){
                        unset($dataBot[$checkMonth]);
                        $data =  array_merge($dataBot,[$dataArr]);
                    }else{
                        $data =  array_merge($dataBot,[$dataArr]);
                    }
                    array_multisort($data);


                $data['time_bot'] = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->toDateTimeString();
                $data['versionNumber'] = $appInfo['appInfo']['versionNumber'];
                ProjectModel::updateOrCreate(
                    [
                        'projectid'=> $appHuawei->projectid
                    ],
                    [
                        'Huawei_status' => $appInfo['appInfo']['releaseState'],
                        'Huawei_bot' => json_encode($data)
                    ]
                );
            }
        }if(count($appsHuawei)==0){
            echo 'Chưa đến time cron'.PHP_EOL .'<br>';
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

    public function setTokenHuawei(){

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
//        $startTime  =  '20220301';
        $endTime    =  Carbon::now()->format('Ymd');
//        $endTime    =  '20220331';
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
            if(isset($val['Month'])){
                if ($val['Month'] === $id) {
                    return $key;
                }
            }
        }
        return false;
    }



    public function Vivo(){
        ini_set('max_execution_time', 600);
        Artisan::call('optimize:clear');
        $time =  Setting::first();
//        $timeCron = Carbon::now()->subMinutes($time->time_cron)->setTimezone('Asia/Ho_Chi_Minh')->timestamp;
        $timeCron = Carbon::now()->subMinutes(1)->setTimezone('Asia/Ho_Chi_Minh')->timestamp;
        $dev_vivo = ProjectModel::with(['dev_vivo'])
//            ->where('Vivo_package', 'com.huaweiltnblink.blackpinklyricswallpaper')
            ->whereHas('dev_vivo',function ($q){
                $q->where('vivo_dev_access_key', '<>', null)
                    ->where('vivo_dev_client_secret', '<>', null);
            })
            ->where('Vivo_package','<>', null)
            ->where('Vivo_bot->time_bot','<=',$timeCron)
            ->limit(10)
            ->get();

        echo '<br/><b>'.'Yêu cầu:';
        echo '<br/>&emsp;'.'- Project có Package của Vivo.';
        echo '<br/>&emsp;'.'- Dev Vivo có Client ID và Client Secret'.'</b><br/><br/>';

        if($dev_vivo){
            foreach ($dev_vivo as $dev){
                echo '<br/>'.'Dang chay:  '.  '-'. $dev->projectname .' - '. Carbon::now('Asia/Ho_Chi_Minh');
                $data = $this->get_Vivo($dev->dev_vivo->vivo_dev_access_key,$dev->dev_vivo->vivo_dev_client_secret,$dev->Vivo_package);
                $dataArr =[
                    'time_bot' => time(),
                    'versionName' => $data ? $data->versionName : 0 ,
                ];
                ProjectModel::updateOrCreate(
                    [
                        'projectid'=> $dev->projectid
                    ],
                    [
                        'Vivo_status' => $data ? $data->onlineStatus : 100,
                        'Vivo_bot' => json_encode($dataArr)
                    ]
                );
            }
        }if(count($dev_vivo)==0){
            echo 'Chưa đến time cron'.PHP_EOL .'<br>';
        }
    }



    public function get_Vivo($access_key,$accessSecret,$packageName){
        $param = array(
            'target_app_key' => 'developer',
            'method' => 'app.detail',
            'access_key' => $access_key,
            'format' => 'json',
            'sign_method' => 'hmac-sha256',
            'packageName' =>$packageName,
            'timestamp' => Carbon::now()->timestamp,
            'v' => '1.0',
        );
        $param['sign'] = $this->sign_Vivo($param,$accessSecret,$this->SIGN_METHOD_HMAC);
        $data = $this->getUrlParamsFromMap_Vivo($param);
        $curl = curl_init($this->domainVivo);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8',
            'Accept: application/json'
        ));

        $result = curl_exec($curl);
        $result = (json_decode($result));

        if($result->code == 0){
            return $result->data;
        }
        return false;




//
//        try {
//            $response = Http::withHeaders([
//                'Content-Type: application/x-www-form-urlencoded;charset=utf-8',
//                'Accept: application/json',
//            ])->post($domainVivo,$data);
//            dd($response->json());
//
//            if ($response->successful()){
//                $result = $response->json();
//                $token = $result['access_token'];
//            }
//        }catch (\Exception $exception) {
//            Log::error('Message:' . $exception->getMessage() . '--- Token: ' . $exception->getLine());
//        }
//        return $token;
    }
    public function sign_Vivo($paramsMap,$accessSecret,$signMethod){
        $params = $this->getUrlParamsFromMap_Vivo($paramsMap);
        if ($this->SIGN_METHOD_HMAC == $signMethod) {
            return $this->hmacSHA256_Vivo($params, $accessSecret);
        }
        return null;

    }
    public function getUrlParamsFromMap_Vivo($paramsMap){
        ksort($paramsMap);
        $paramsMap = implode('&', array_map(
            function ($v, $k) { return sprintf("%s=%s", $k, $v); },
            $paramsMap,
            array_keys($paramsMap)));
        return $paramsMap;
    }
    public function hmacSHA256_Vivo($data, $key){
        $hash = hash_hmac('SHA256', $data, $key);
        return $hash;
    }


}
