<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\TemplatePreview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use RarArchive;
use ZipArchive;

class TemplatePreviewController extends Controller
{
    public function index(){
        return view('template-preview.index');
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
        $totalRecords = TemplatePreview::select('count(*) as allcount')->count();
        $totalRecordswithFilter = TemplatePreview::select('count(*) as allcount')
            ->where('tp_name', 'like', '%' . $searchValue . '%')
            ->count();


        // Get records, also we have included search filter as well
        $records = TemplatePreview::orderBy($columnName, $columnSortOrder)
            ->where('tp_name', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editTemplate('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Check" class="btn btn-info checkDataTemplate"><i class="ti-file"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteTemplate"><i class="ti-trash"></i></a>';

            $data_arr[] = array(
//                "logo" => $logo,
                "tp_name" => $record->tp_name,
                "tp_number" => $record->tp_number,
                "tp_sc" => $record->tp_sc,
                "tp_size" => $record->tp_size,
                "tp_start" => $record->tp_start,

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
//        dd($request->all());
//        $rules = [
//            'tp_name' =>'unique:template_previews,tp_name',
//            'tp_sc' => 'mimes:zip,rar',
//
//        ];
//        $message = [
//            'tp_name.unique'=>'Tên đã tồn tại',
//            'tp_sc.mimes'=>'Định dạng file: *.zip',
//        ];
//
//
//
//        $error = Validator::make($request->all(),$rules, $message );
//        if($error->fails()){
//            return response()->json(['errors'=> $error->errors()->all()]);
//        }


        $data = new TemplatePreview();
        $data['tp_name'] = $request->tp_name;
        $data['tp_number'] = $request->tp_number;
        $data['tp_size'] = $request->tp_size;
        $data['tp_start'] = $request->tp_start;
        if($request->tp_sc){
            $destinationPath = public_path('file-manager/TemplatePrivew/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file = $request->tp_sc;
            $filename = $file->getClientOriginalName();
            $filenameWithEx = pathinfo($filename, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $tp_sc = $request->tp_name.'.'.$extension;
            $data['tp_sc'] = $tp_sc;
            $this->extract_file($file,$destinationPath);
            rename($destinationPath.$filenameWithEx, $destinationPath.$request->tp_name);
            $files = glob($destinationPath.$request->tp_name.'/*.png');
            $filecount = count( $files );
            for($i= 1 ; $i<=$filecount ; $i++){
                $myfile = fopen($destinationPath.$request->tp_name."/pr".$i.".txt", "w") or die("Unable to open file!");
                $txt = 'pr'.$i.'.png|resize|1080:1920|temp1.png'."\n".
                    'sc_'.$i.'.jpg|resize|'.$request->tp_size.'|temp2.jpg'."\n".
                    'temp1.png/temp2.jpg|overlay|'.$request->tp_start.'|temp3.jpg'."\n".
                    'temp3.jpg/temp1.png|overlay|0:0|pr_'.$i.'.jpg';
                fwrite($myfile, $txt);
            }
        }
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
            'template_data' => 'mimes:zip',
            'template_apk' => 'mimes:zip,apk'
        ];
        $message = [
            'template.unique'=>'Tên template đã tồn tại',
            'template_data.mimes'=>'Template Data: *.zip',
            'template_apk.mimes'=>' Template APK: *.apk',
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
            'ads_open' => $request->Check_ads_open,
            'ads_start' => $request->Check_ads_start,
            'ads_banner_huawei' => $request->Check_ads_banner_huawei,
            'ads_inter_huawei' => $request->Check_ads_inter_huawei,
            'ads_reward_huawei' => $request->Check_ads_reward_huawei,
            'ads_native_huawei' => $request->Check_ads_native_huawei,
            'ads_splash_huawei' => $request->Check_ads_splash_huawei,
            'ads_roll_huawei' => $request->Check_ads_roll_huawei,
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
        $data->Huawei_category =  $request->Huawei_category;

        if($data->template_logo){
            if($data->template <> $request->template){
                $dir = (public_path('uploads/template/'));
                rename($dir.$data->template, $dir.$request->template);
            }
        }
        if($request->logo){
            $image = $request->file('logo');
            $data['template_logo'] = 'logo_'.time().'.'.$image->extension();
            $destinationPath = public_path('uploads/template/'.$request->template.'/thumbnail/');
            $img = Image::make($image->path());
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 777, true);
            }
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.$data['template_logo']);
            $destinationPath = public_path('uploads/template/'.$request->template);
            $image->move($destinationPath, $data['template_logo']);
        }

//        if($data->template_apk){
////            dd($data->template_apk.$request->template);
//            $dir_file = public_path('file-manager/TemplateApk/');
//            @rename($dir_file.$data->template_apk, $dir_file.$request->template.'.apk');
//            $data['template_apk'] = $request->template.'.apk';
//        }
        if($request->template_apk){
            if($data->template_apk){
                $path_Remove =  public_path('file-manager/TemplateApk/').$data->template_apk;
                if(file_exists($path_Remove)){
                    unlink($path_Remove);
                }
            }
            $destinationPath = public_path('file-manager/TemplateApk/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file = $request->template_apk;
            $extension = $file->getClientOriginalExtension();
            $file_name_apk = $request->template.'.'.$extension;
            $data->template_apk = $file_name_apk;
            $file->move($destinationPath, $file_name_apk);
        }

//        if($data->template_data){
//            $dir_file = public_path('file-manager/TemplateData/');
//            rename($dir_file.$data->template_data, $dir_file.$request->template.'.zip');
//            $data['template_data'] = $request->template.'.zip';
//        }
        if($request->template_data){
            if($data->template_data){
                $path_Remove =  public_path('file-manager/TemplateData/').$data->template_data;
                if(file_exists($path_Remove)){
                    unlink($path_Remove);
                }
            }
            $destinationPath = public_path('file-manager/TemplateData/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file = $request->template_data;
            $extension = $file->getClientOriginalExtension();
            $file_name_data = $request->template.'.'.$extension;
            $data->template_data = $file_name_data;
            $file->move($destinationPath, $file_name_data);
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


    public function extract_file($file_path, $to_path = "./")
    {
        $file_type = $file_path->getClientOriginalExtension();
        if ("zip" === $file_type) {
            $xmlZip = new ZipArchive();
            if ($xmlZip->open($file_path)) {
                $xmlZip->extractTo($to_path);
                return true;
            } else {
                echo "extract fail";
                return false;
            }
        } elseif ("rar" == $file_type) {

            $archive = RarArchive::open($file_path);
            $entries = $archive->getEntries();
            if ($entries) {
                foreach ($entries as $entry) {
                    $entry->extract($to_path);
                }
                $archive->close();
                return true;
            }else{
                echo "extract fail";
                return false;
            }
        }


    }
}
