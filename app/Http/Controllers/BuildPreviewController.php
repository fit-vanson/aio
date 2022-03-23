<?php

namespace App\Http\Controllers;

use App\Models\CategoryTemplate;
use App\Models\TemplatePreview;
use App\Models\TemplateTextPr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class BuildPreviewController extends Controller
{
    public function index(){
        $categoyTemplate =  CategoryTemplate::latest('id')->where('category_template_parent',0)->get();
        return view('category-template.index',compact('categoyTemplate'));
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
        $totalRecords = CategoryTemplate::select('count(*) as allcount')->count();
        $totalRecordswithFilter = CategoryTemplate::select('count(*) as allcount')
            ->where('category_template_name', 'like', '%' . $searchValue . '%')
            ->count();


        // Get records, also we have included search filter as well
        $records = CategoryTemplate::orderBy($columnName, $columnSortOrder)
            ->with('parent')
//            ->select('*',DB::raw("sum( IF(tp_script_1 = '',0,1)  + IF(tp_script_2 = '',0,1)  + IF(tp_script_3 = '',0,1)  + IF(tp_script_4 = '',0,1)  + IF(tp_script_5 = '',0,1)  + IF(tp_script_6 = '',0,1)  + IF(tp_script_7 = '',0,1)  + IF(tp_script_8 = '',0,1)  ) AS sum_script") )
            ->where('category_template_name', 'like', '%' . $searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editCategoryTemplate('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteCategoryTemplate"><i class="ti-trash"></i></a>';

            if($record->parent){
                $parent = $record->parent->category_template_name;
            }else{
                $parent = $record->category_template_name;
            }
            $data_arr[] = array(
                "id " => $parent ,
                "category_template_name" => $record->category_template_name,
                "category_template_parent" => $parent,
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
            'file_data' => 'mimes:zip,rar',
        ];
        $message = [
            'file_data.mimes'=>'File *.zip',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }

        if($request->template_frame_preview != 0){
            $frame = TemplatePreview::find($request->template_frame_preview);
        }else{
            $frame = TemplatePreview::where('tp_category',$request->category_template_frame)->inRandomOrder()->first();
        }
        if($request->template_text_preview != 0){
            $text = TemplateTextPr::find($request->template_text_preview);
        }else{
            $text = TemplateTextPr::where('tt_category',$request->category_child_template_text)->inRandomOrder()->first();
        }

        $srcDataPr = public_path('file-manager/TemplatePreview/'.$frame->tp_sc);
        $srcDataText = public_path('file-manager/TemplateTextPreview/'.$text->tt_file);
        $outData = public_path('file-manager/BuildTemplate/test');
        $dataPR = $this->extract_file($srcDataPr, $outData.'/zzz');
        $dataText = $this->extract_file($srcDataText, $outData.'/xxx');
        $dataSC =  $this->extract_file($request->file_data,$outData);

        $dataFile = scandir('file-manager/BuildTemplate/test');
//        dd($dataFile);
//        $tempFrame = json_decode(json_encode($frame), true);
//        dd($outData);

        for ($i = 1; $i<=6; $i++ ){
            $output1 = shell_exec('ffmpeg -i '.$outData.'/zzz/pr'.$i.'.png -vf scale=1080:1920 '.$outData.'/temp'.$i.'1.png');
            $output2 = shell_exec('ffmpeg -i '.$outData.'/'.$dataFile[2].'/sc_'.$i.'.jpg -vf scale=624:1365 '.$outData.'/temp'.$i.'2.png');
            $output3 = shell_exec('ffmpeg -i '.$outData.'/temp'.$i.'1.png -i '.$outData.'/temp'.$i.'2.png -filter_complex "overlay=226:470" -qscale:v 1 '.$outData.'/temp'.$i.'3.png -y');
            $output4 = shell_exec('ffmpeg -i '.$outData.'/temp'.$i.'3.png -i '.$outData.'/temp'.$i.'1.png -filter_complex "overlay=0:0" -qscale:v 1 '.$outData.'/temp'.$i.'4.png -y');
            $output4 = shell_exec('ffmpeg -i '.$outData.'/temp'.$i.'4.png -i '.$outData.'/xxx/Pink/text_'.$i.'.png -filter_complex "overlay=0:40" -qscale:v 1 '.$outData.'/pr_'.$i.'.png -y');

        }
        $out = shell_exec('ffmpeg -i '.$outData.'/pr_1.png -i '.$outData.'/pr_2.png -i '.$outData.'/pr_3.png -i '.$outData.'/pr_4.png -i '.$outData.'/pr_5.png -i '.$outData.'/pr_6.png -filter_complex "[0][1][2][3][4][5]hstack=inputs=6" '.$outData.'/output.png');


        return response()->json([
            'success'=>'Thêm mới thành công',
            'out' => '/output.png',
        ]);

    }
    public function edit($id)
    {
        $temp = CategoryTemplate::find($id);
        $cateParent =  CategoryTemplate::latest()->where('category_template_parent',0)->get();
        return response()->json([$temp,$cateParent] );
    }
    public function update(Request $request){
        $id = $request->category_template_id;
        $rules = [
            'category_template_name' =>'unique:category_templates,category_template_name,'.$id.',id',

        ];
        $message = [
            'category_template_name.unique'=>'Tên đã tồn tại',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = CategoryTemplate::find($id);
        $data->category_template_name = $request->category_template_name;
        $data->category_template_parent = $request->category_template_parent ? $request->category_template_parent : 0;
        $data->save();
        return response()->json(['success'=>'Cập nhật thành công']);
    }
    public function delete($id){
        $data = CategoryTemplate::find($id);
        if($data->category_template_parent == 0 ){
            $cateParent = CategoryTemplate::where('category_template_parent',$id)->count();
            if($cateParent ==0){
                $data->delete();
                return response()->json(['success'=>'Xóa thành công.']);
            }else{
                return response()->json(['errors'=>'Đang tồn tại cate child, không thể xoá.']);
            }

        }else{
            $data->delete();
            return response()->json(['success'=>'Xóa thành công.']);
        }
    }
    public function getCateTempParent($id){
        $cateParent = CategoryTemplate::where('category_template_parent',$id)->get();
        $cateName = CategoryTemplate::find($id);
        $textPreview = TemplateTextPr::where('tt_category',$id)->get();
        $text = TemplateTextPr::find($id);
        return response()->json([
            'success'=>'Thêm mới thành công',
            'cateParent' => $cateParent,
            'cateName' => $cateName,
            'textPreview' => $textPreview,
            'text' => $text,
        ]);

    }


    public function extract_file($file_path, $to_path = "./")
    {
//        dd($file_path);
//        $file_type = $file_path->getClientOriginalExtension();
//        if ("zip" === $file_type) {
            $xmlZip = new ZipArchive();
            if ($xmlZip->open($file_path)) {
                $xmlZip->extractTo($to_path);
                return true;
            } else {
                echo "extract fail";
                return false;
            }
//        } elseif ("rar" == $file_type) {
//
//            $archive = RarArchive::open($file_path);
//            $entries = $archive->getEntries();
//            if ($entries) {
//                foreach ($entries as $entry) {
//                    $entry->extract($to_path);
//                }
//                $archive->close();
//                return true;
//            }else{
//                echo "extract fail";
//                return false;
//            }
//        }


    }
}
