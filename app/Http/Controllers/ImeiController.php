<?php

namespace App\Http\Controllers;

use App\Models\Imei;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class ImeiController extends Controller
{
    public function index()
    {
        $brand = Imei::select('brand')->distinct('brand')->get();
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Index"]
        ];
        return view('imei.index', [
            'breadcrumbs' => $breadcrumbs,
            'brand' =>$brand,
            ]);
    }

    public function getBrand(Request $request){
        $brand = $request->brand;
        if($brand){
            $model = Imei::where('brand',$brand)->get();
            return response([
                'data'=>$model
            ]);
        }
    }

    public function create(Request $request){
        $data = new Imei();
        $data->imei_code = substr($request->imei,0,10);
        $data->brand = $request->brand;
        $data->model= $request->model;
        $data->save();

    }
    public function import(){
        dd(1);
        ini_set('max_execution_time',30000);
        $file = file('C:\Users\Administrator\Desktop\data\imeidb.csv');


//        $data = array_splice($file,1);
        $parts = (array_chunk($file,1000));
        foreach ($parts as $part){
            $items = array_map('str_getcsv',$part);
            foreach ($items as $item){
                Imei::updateOrCreate(
                    [
                        'tac_code' => $item[0]
                    ],
                    [
                        'brand' => $item[1],
                        'model' => $item[2],
                    ]
                ) ;
            }
        }
    }

    public function gen_imei($tac,$show=1){
        if(isset($_GET['show'])){
            $show = $_GET['show'];
        }
        if(isset($_GET['tac_code'])) {
            $tac = $_GET['tac_code'];
        }
        $TAC = [];
        for ($i=0; $i<$show;$i++){
            while (strlen($tac) < 14){
                $tac .= (string)rand(0,9);
            }
            $tac .= $this->calc_check_digit($tac);
            $TAC[] = $tac;
        }
        return response()->json(['data'=>$TAC]);

    }
    public function calc_check_digit($number,$alphabet='0123456789'){
        $check_digit = $this->checksum($number.$alphabet[0]);
    return $alphabet[-$check_digit];
    }
    public function checksum($number,$alphabet='0123456789'){
        $n = strlen($alphabet);
        $number = array_reverse(array_map('intval', str_split($number)));
        $b = 0;
        $sum = 0;
        foreach ($number as $key=>$num){
            if($key%2 !=1){
                $sum+= $num;
            }else{
                $a = $num;
                $div = (int)floor($a*2/$n);
                $mov = $a*2%$n;
                $b += $div+$mov;
            }
        }
        $total = $sum+$b;
        return $total%$n;
    }

    public function show_imei(Request $request){
       if($request->brand){
           $model = Imei::inRandomOrder()->where('brand',$request->brand)->limit(5)->get();
           foreach ($model as $item){
               if(isset($request->model)){
                   $tac = Imei::inRandomOrder()->where('brand',$request->brand)->where('model',$request->model)->first();
                   $gen_imei =  $this->gen_imei($tac->tac_code,1);
                   return $request->brand . ' | ' .$request->model. ' | '.$gen_imei->getData()->data[0];
               }else{
                   echo '<a href="?brand='.$item->brand.'&model='.$item->model.'">'.$item->model.'</a><br />';
               }
           }
       }elseif ($request->tac_code){
           $tac_code = $request->tac_code;
           $a = $this->gen_imei($tac_code,1);
           echo $a->getData()->data[0];
       }
       else{
           $brand = Imei::inRandomOrder()->limit(20)->get();
           foreach ($brand as $item){
               echo '<a href="?brand='.$item->brand.'">'.$item->brand.'</a><br />';
           }
       }
    }
}
