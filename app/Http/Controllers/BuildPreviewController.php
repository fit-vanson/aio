<?php

namespace App\Http\Controllers;

use App\Models\CategoryTemplate;
use App\Models\TemplatePreview;
use App\Models\TemplateTextPr;
use FFMpeg\Filters\Frame\FrameFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
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

        $out = Image::make($outData.'/out.jpg')
            ->resize(1080*6, 1920)
            ->save($outData.'/temp30.png');
        for ($i = 1; $i<=6; $i++ ){
            $img2 = Image::make($outData.'/'.$dataFile[2].'/sc_'.$i.'.jpg')->resize(624, 1365);

            $img1 = Image::make($outData.'/zzz/pr'.$i.'.png')
                ->resize(1080, 1920)->save($outData.'/temp'.$i.'.png');
            $img3 = Image::make($img1)
                ->insert($img2, 'top-left', 226, 470)
                ->insert($outData.'/temp'.$i.'.png','top-left', 0, 0)
                ->insert($outData.'/xxx/Pink/text_'.$i.'.png', 'top-left-right', 0, 40)
                ->save($outData.'/pr_'.$i.'.jpg');
        }
        $out1 = Image::make($outData.'/temp30.png')
            ->insert($outData.'/pr_1.jpg', 'top-right', 1080*0, 0)
            ->insert($outData.'/pr_2.jpg', 'top-right', 1080*1, 0)
            ->insert($outData.'/pr_3.jpg', 'top-right', 1080*2, 0)
            ->insert($outData.'/pr_4.jpg', 'top-right', 1080*3, 0)
            ->insert($outData.'/pr_5.jpg', 'top-right', 1080*4, 0)
            ->insert($outData.'/pr_6.jpg', 'top-right', 1080*5, 0)
            ->save($outData.'/out.jpg');
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
