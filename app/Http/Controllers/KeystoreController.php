<?php

namespace App\Http\Controllers;

use App\Models\Dev;
use App\Models\ProjectModel;
use App\Models\Keystore;
use Faker\Provider\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class KeystoreController extends Controller
{
    public function index(){
        return view('keystore.index');
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
        $totalRecords = Keystore::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Keystore::select('count(*) as allcount')
            ->where('name_keystore', 'like', '%' . $searchValue . '%')
            ->orwhere('pass_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('aliases_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('pass_aliases', 'like', '%' . $searchValue . '%')
            ->orWhere('SHA_256_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('note', 'like', '%' . $searchValue . '%')
            ->count();

        // Get records, also we have included search filter as well
        $records = Keystore::orderBy($columnName, $columnSortOrder)
            ->where('name_keystore', 'like', '%' . $searchValue . '%')
            ->orwhere('pass_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('aliases_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('pass_aliases', 'like', '%' . $searchValue . '%')
            ->orWhere('SHA_256_keystore', 'like', '%' . $searchValue . '%')
            ->orWhere('note', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editKeytore('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteKeystore"><i class="ti-trash"></i></a>';


            $project = DB::table('ngocphandang_project')
                ->where('ngocphandang_project.buildinfo_keystore',$record->name_keystore)
                ->orWhere('ngocphandang_project.Chplay_keystore_profile', $record->name_keystore)
                ->orWhere('ngocphandang_project.Amazon_keystore_profile', $record->name_keystore)
                ->orWhere('ngocphandang_project.Samsung_keystore_profile', $record->name_keystore)
                ->orWhere('ngocphandang_project.Xiaomi_keystore_profile', $record->name_keystore)
                ->orWhere('ngocphandang_project.Oppo_keystore_profile', $record->name_keystore)
                ->orWhere('ngocphandang_project.Vivo_keystore_profile', $record->name_keystore)
                ->orWhere('ngocphandang_project.Huawei_keystore_profile', $record->name_keystore)
                ->count();
            $html = '../uploads/keystore/'.$record->name_keystore.'/'.$record->file;
            $data_arr[] = array(
//                "name_keystore" => $record->name_keystore,
                "name_keystore" => '<a href="/project?q=key_store&id='.$record->name_keystore.'"> <span>'.$record->name_keystore.' - ('.$project.')</span></a>',
                "pass_keystore" => $record->pass_keystore,
                "aliases_keystore" => $record->aliases_keystore,
                "SHA_256_keystore" => $record->SHA_256_keystore,
                "pass_aliases" => $record->pass_aliases,
                "file" => '<a href="'.$html.'">'.$record->file.'</a>',
                "note"=> $record->note,
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
            'name_keystore' =>'unique:ngocphandang_keystores,name_keystore',
            'keystore_file' => 'mimes:zip,jks'
        ];
        $message = [
            'name_keystore.unique'=>'Tên Keystore đã tồn tại',
            'keystore_file.mimes'=>'Định dạng File: *.zip, *.jks',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new Keystore();
        $data['name_keystore'] = $request->name_keystore;
        $data['pass_keystore'] = $request->pass_keystore;
        $data['aliases_keystore'] = $request->aliases_keystore;
        $data['pass_aliases'] = $request->pass_aliases;
        $data['SHA_256_keystore'] = $request->SHA_256_keystore;
        $data['note'] = $request->note;

        $destinationPath = public_path('uploads/keystore/'.$request->name_keystore);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        if(isset($request->keystore_file)){
            $file = $request->file('keystore_file');
            $data['file'] = 'keystore_'.time().'.'.$file->extension();
            $file->move($destinationPath, $data['file']);
        }

        $data->save();
        $allKeys  = Keystore::latest('id')->get();
        return response()->json([
            'success'=>'Thêm mới thành công',
            'keys' => $allKeys

        ]);
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
        $keystore = Keystore::find($id);
        return response()->json($keystore);
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

        $id = $request->keystore_id;
        $rules = [
            'name_keystore' =>'unique:ngocphandang_keystores,name_keystore,'.$id.',id',
            'keystore_file' => 'mimes:zip,jks'
        ];
        $message = [
            'name_keystore.unique'=>'Tên Keystore đã tồn tại',
            'keystore_file.mimes'=>'Định dạng File: *.zip, *.jks',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }

        $data = Keystore::find($id);
        if($data->name_keystore <> $request->name_keystore){
            $dir = (public_path('uploads/keystore/'));
            rename($dir.$data->name_keystore, $dir.$request->name_keystore);
        }
        if(isset($request->keystore_file)){
            $file = $request->file('keystore_file');
            $data['file'] = 'keystore_'.time().'.'.$file->extension();
            $destinationPath = public_path('uploads/keystore/'.$request->name_keystore);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $data['file']);

        }
        $data->name_keystore = $request->name_keystore;
        $data->pass_keystore = $request->pass_keystore;
        $data->aliases_keystore= $request->aliases_keystore;
        $data->pass_aliases= $request->pass_aliases;
        $data->SHA_256_keystore = $request->SHA_256_keystore;
        $data->note = $request->note;
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
        Keystore::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }

}
