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
        $template = Template::all();
        if ($request->ajax()) {
            $data = Template::all();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->template.'" data-original-title="Edit" class="btn btn-warning btn-sm editTemplate"><i class="ti-pencil-alt"></i></a>';
//                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->projectid.'" data-original-title="Quick Edit" class="btn btn-success btn-sm quickEditProject"><i class="mdi mdi-playlist-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->template.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTemplate"><i class="ti-trash"></i></a>';
                    return $btn;
                })
                ->editColumn('time_create', function($data) {
                    return date( 'd/m/Y - H:i:s ',$data->time_create);
                })
                ->editColumn('time_update', function($data) {
                    return date( 'd/m/Y - H:i:s ',$data->time_update);
                })
                ->editColumn('time_get', function($data) {
                    return date( 'd/m/Y - H:i:s ',$data->time_get);
                })

                ->editColumn('link_chplay', function($data){
                    if ($data->link_chplay !== null){
                        return "<a href='$data->link_chplay'>Link</a>";
                    }
                    return null;
                })
                ->editColumn('script_copy', function($data){
                    if ($data->script_copy !== null){
                        return "<i style='color:green; ' class='ti-check-box h5'></i>";
                    }
                    return null;
                })
                ->editColumn('script_img', function($data){
                    if ($data->script_img !== null){
                        return "<i style='color:green; ' class='ti-check-box h5'></i> ";
                    }
                    return null;
                })
                ->editColumn('script_svg2xml', function($data){
                    if ($data->script_svg2xml !== null){
                        return "<i style='color:green; ' class='ti-check-box h5'></i>";
                    }
                    return null;
                })

                ->rawColumns(['action','link_chplay','script_copy','script_img','script_svg2xml'])
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
        $project = Template::find($id);
        return response()->json($project);
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
            'template' =>'unique:ngocphandang_template,template,'.$id.',template',
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
//        $this->AuthLogin();
        return parent::callAction($method, array_values($parameters));
    }
}
