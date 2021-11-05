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

    public function gen_imei(Request $request){
        if($request->brand){
            $brand = $request->brand;
            $data = Imei::where('brand',$brand)->where('imei_code','<>','null')->get();
            if(count($data)>0){
                foreach ($data as $item){
                    echo '<a href="?b='.$brand.'&m='.$item->model.'">'.$item->model.'</a><br />';

                }
                return;
            }else{
                return 'Chưa có dữ liệu';
            }
        }
        if (isset($request->m) && isset($request->b)) {
            $imei = Imei::where('brand',$request->b)->where('model',$request->m)->first();
            if(isset($imei)){
                $imei = $imei->imei_code;
                $imei = substr($imei,0,10);
                $imei_length = strlen($imei);
                $chars_left = (14 - (int) $imei_length);
                $range_start = substr(pow(31, ($chars_left - 1)), 0, $chars_left);
                $range_diff = 842;
                $new_imei = $imei . $range_start;
                for ($i = 0; $i < 5; $i++) {
                    $imei_total = 0;
                    $imei_chunked = str_split($new_imei);

                    for ($x = 0; $x < count($imei_chunked); $x++) {
                        // echo $imei_chunked[$x] . ' - ' . $x . ' - ' . $x%2 . "<br >"; //debugging each only
                        $imei_each = $imei_chunked[$x];
                        if ($x % 2) {
                            $imei_each = 2 * $imei_each;
                            if (strlen($imei_each) == 2) {
                                $imei_each = array_sum(str_split($imei_each));
                            }
                        }
                        $imei_total += $imei_each;
                    }

                    // to get the imei check number..
                    $love = str_split($imei_total);
                    $check_number = (10 - (int) $love[1]);
                    if ($check_number == 10) {
                        $check_number = 0;
                    }

                    $imei_gen = $new_imei . $check_number;
//                echo  "<input value=\"" . $new_imei . $check_number . "\" class=\"form-control\" /><br>";

                    $new_imei += $range_diff;
                    echo $request->b . ' | '. $request->m .' | '.$imei_gen.'<br>';
                }
                return;
            }
            else {
                return 'Chưa có dữ liệu';
            }
        }
        if (isset($request->model) && is_numeric($request->model)) {
            $imei_input = $request->model;
            $imei = substr($imei_input,0,10);
            $imei_length = strlen($imei);
            $chars_left = (14 - (int) $imei_length);
            $range_start = substr(pow(31, ($chars_left - 1)), 0, $chars_left);
            $range_diff = 842;
            $new_imei = $imei . $range_start;
            for ($i = 0; $i < 5; $i++) {
                $imei_total = 0;
                $imei_chunked = str_split($new_imei);

                for ($x = 0; $x < count($imei_chunked); $x++) {
                    // echo $imei_chunked[$x] . ' - ' . $x . ' - ' . $x%2 . "<br >"; //debugging each only
                    $imei_each = $imei_chunked[$x];
                    if ($x % 2) {
                        $imei_each = 2 * $imei_each;
                        if (strlen($imei_each) == 2) {
                            $imei_each = array_sum(str_split($imei_each));
                        }
                    }
                    $imei_total += $imei_each;
                }

                // to get the imei check number..
                $love = str_split($imei_total);
                $check_number = (10 - (int) $love[1]);
                if ($check_number == 10) {
                    $check_number = 0;
                }

                $imei_gen[] = $new_imei . $check_number;
//                echo  "<input value=\"" . $new_imei . $check_number . "\" class=\"form-control\" /><br>";

                $new_imei += $range_diff;
            }
            return response([
                'data'=>$imei_gen
            ]);
        } else {
            return response([
                'error'=>'Chưa có dữ liệu'
            ]);
        }
    }

    public function import(){
        dd(1);
        $file = file('C:\Users\Administrator\Desktop\data\phone_full.csv');
        $data = array_splice($file,1);
        $parts = (array_chunk($data,5000));
        foreach ($parts as $part){
            $items = array_map('str_getcsv',$part);
            foreach ($items as $item){
                Imei::updateOrCreate([
                    'brand' => $item[0],
                    'model' => $item[1],
                ]) ;
            }
        }
    }

}
