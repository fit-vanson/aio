<?php

namespace App\Http\Controllers;

use App\Models\ProjectModel;
use App\Models\Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $template = Template::latest('id')->get();
        if ($request->ajax()) {
            $data = Template::latest('id')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-warning btn-sm editTemplate"><i class="ti-pencil-alt"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTemplate"><i class="ti-trash"></i></a>';
                    return $btn;
                })
                ->editColumn('time_create', function($data) {
                    if($data->time_create == 0 ){
                        return  null;
                    }
                    return date( 'd/m/Y',$data->time_create);
                })
                ->editColumn('time_update', function($data) {
                    if($data->time_update == 0 ){
                        return  null;
                    }
                    return date( 'd/m/Y',$data->time_update);
                })
                ->editColumn('time_get', function($data) {
                    if($data->time_get == 0 ){
                        return  null;
                    }
                    return date( 'd/m/Y - H:i:s ',$data->time_get);
                })
                ->editColumn('template', function($data){
                    return '
                                    <span>'.$data->template.'</span>
                                    <p class="text-muted m-b-30 ">'.$data->ver_build.'</p>
                                ';
                })
                ->editColumn('link_chplay', function($data){
                    if ($data->link_chplay !== null){
                        return "<a  target= _blank href='$data->link_chplay'>Link</a>";
                    }
                    return null;
                })
                ->addColumn('script', function($row){
                    if($row['script_copy'] !== Null){
                        $script_copy = "<i style='color:green;' class='ti-check-box h5'></i>";
                    } else {
                        $script_copy = "<i style='color:red;' class='ti-close h5'></i>";
                    }
                    if($row['script_img'] !== Null){
                        $script_img = "<i style='color:green;' class='ti-check-box h5'></i>";
                    } else {
                        $script_img = "<i style='color:red;' class='ti-close h5'></i>";
                    }
                    if($row['script_svg2xml'] !== Null){
                        $script_svg2xml = "<i style='color:green;' class='ti-check-box h5'></i>";
                    } else {
                        $script_svg2xml = "<i style='color:red;' class='ti-close h5'></i>";
                    }
                    return $script_copy .' '. $script_img.' '. $script_svg2xml ;
                })

                ->rawColumns(['action','link_chplay','script','template'])
                ->make(true);
        }
        return view('template.index',compact('template'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        $rules = [
            'template' =>'unique:ngocphandang_template,template'
        ];
        $message = [
            'template.unique'=>'Tên Template đã tồn tại',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new Template();
        $data['template'] = $request->template;
        $data['ver_build'] = $request->ver_build;
        $data['script_copy'] = $request->script_copy;
        $data['script_img'] = $request->script_img;
        $data['script_svg2xml'] = $request->script_svg2xml;
        $data['time_create'] =  time();
        $data['time_update'] = time();
        $data['time_get'] = time();
        $data['note'] = $request->note;
        $data['link_chplay'] = $request->link_chplay;
        $data['category'] =  $request->category;
        $data->save();
        $allTemp  = Template::latest('time_create')->get();
        return response()->json([
            'success'=>'Thêm mới thành công',
            'temp'=>$allTemp
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
        ];
        $message = [
            'template.unique'=>'Tên template đã tồn tại',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = Template::find($id);
        $data->template = $request->template;
        $data->ver_build = $request->ver_build;
        $data->script_copy = $request->script_copy;
        $data->script_img= $request->script_img;
        $data->script_svg2xml = $request->script_svg2xml;
        $data->time_update = time();
        $data->note = $request->note;
        $data->link_chplay = $request->link_chplay;
        $data->category =  $request->category;
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
}
