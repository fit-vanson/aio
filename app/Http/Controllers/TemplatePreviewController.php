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
            ->orWhere('tp_sc', 'like', '%' . $searchValue . '%')
            ->count();


        // Get records, also we have included search filter as well
        $records = TemplatePreview::orderBy($columnName, $columnSortOrder)
            ->where('tp_name', 'like', '%' . $searchValue . '%')
            ->orWhere('tp_sc', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editTemplatePreview('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteTemplatePreview"><i class="ti-trash"></i></a>';

            $data_arr[] = array(
                "tp_name" => $record->tp_name,
                "tp_sc" => $record->tp_sc,
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
            'tp_name' =>'unique:template_previews,tp_name',
            'tp_sc' => 'required|mimes:zip,rar',

        ];
        $message = [
            'tp_name.unique'=>'Tên đã tồn tại',
            'tp_sc.mimes'=>'Định dạng file: *.zip',
            'tp_sc.required'=>'Trường không để trống',
        ];



        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }

        $data = new TemplatePreview();
        $data['tp_name'] = $request->tp_name;
        $data['tp_script_1'] = $request->tp_script_1 ? $request->tp_script_1 : '';
        $data['tp_script_2'] = $request->tp_script_2 ? $request->tp_script_2 : '';
        $data['tp_script_3'] = $request->tp_script_3 ? $request->tp_script_3 : '';
        $data['tp_script_4'] = $request->tp_script_4 ? $request->tp_script_4 : '';
        $data['tp_script_5'] = $request->tp_script_5 ? $request->tp_script_5 : '';
        $data['tp_script_6'] = $request->tp_script_6 ? $request->tp_script_6 : '';
        $data['tp_script_7'] = $request->tp_script_7 ? $request->tp_script_7 : '';
        $data['tp_script_8'] = $request->tp_script_8 ? $request->tp_script_8 : '';
        $data['tp_black'] = $request->tp_black ? 1 : 0;
        $data['tp_blue'] = $request->tp_blue ? 1 : 0;
        $data['tp_while'] = $request->tp_while ? 1 : 0;
        $data['tp_pink'] = $request->tp_pink ? 1 : 0;

        if($request->tp_sc){
            $destinationPath = public_path('file-manager/TemplatePreview/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file = $request->tp_sc;
            $extension = $file->getClientOriginalExtension();
            $tp_sc = $request->tp_name.'.'.$extension;
            $data['tp_sc'] = $tp_sc;
            $file->move($destinationPath, $tp_sc);
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
        $temp = TemplatePreview::find($id);
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

        $id = $request->tp_id;

        $rules = [
            'tp_name' =>'unique:template_previews,tp_name,'.$id.',id',
            'tp_sc' => 'mimes:zip,rar',

        ];
        $message = [
            'tp_name.unique'=>'Tên đã tồn tại',
            'tp_sc.mimes'=>'Định dạng file: *.zip',
            'tp_sc.required'=>'Trường không để trống',
        ];


        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }

        $data = TemplatePreview::find($id);

//        dd($data);

        $data->tp_script_1 = $request->tp_script_1 ? $request->tp_script_1 : '';
        $data->tp_script_2 = $request->tp_script_2 ? $request->tp_script_2 : '';
        $data->tp_script_3 = $request->tp_script_3 ? $request->tp_script_3 : '';
        $data->tp_script_4 = $request->tp_script_4 ? $request->tp_script_4 : '';
        $data->tp_script_5 = $request->tp_script_5 ? $request->tp_script_5 : '';
        $data->tp_script_6 = $request->tp_script_6 ? $request->tp_script_6 : '';
        $data->tp_script_7 = $request->tp_script_7 ? $request->tp_script_7 : '';
        $data->tp_script_8 = $request->tp_script_8 ? $request->tp_script_8 : '';
        $data->tp_black = $request->tp_black ? 1 : 0;
        $data->tp_blue= $request->tp_blue ? 1 : 0;
        $data->tp_while = $request->tp_while ? 1 : 0;
        $data->tp_pink = $request->tp_pink ? 1 : 0;



        $destinationPath = public_path('file-manager/TemplatePreview/');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        if($request->tp_sc ){
            $path_Remove = public_path('file-manager/TemplatePreview/') . $data->tp_sc;
            if (file_exists($path_Remove)) {
                unlink($path_Remove);
            }
            $file = $request->tp_sc;
            $extension = $file->getClientOriginalExtension();
            $tp_sc = $request->tp_name.'.'.$extension;
            $data['tp_sc'] = $tp_sc;
            $file->move($destinationPath, $tp_sc);
        }
        if($data->tp_name != $request->tp_name){
            $file= pathinfo($destinationPath.$data->tp_sc);
            rename($destinationPath.$data->tp_sc, $destinationPath.$request->tp_name.'.'.$file['extension']);
            $data['tp_sc'] = $request->tp_name.'.'.$file['extension'];
        }
        $data->tp_name = $request->tp_name;
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
        $data = TemplatePreview::find($id);
        $path_Remove = public_path('file-manager/TemplatePreview/') . $data->tp_sc;
        if (file_exists($path_Remove)) {
            unlink($path_Remove);
        }
        $data->delete();
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
