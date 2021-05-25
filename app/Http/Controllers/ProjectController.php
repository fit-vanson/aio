<?php

namespace App\Http\Controllers;

use App\Models\ProjectModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $project = ProjectModel::latest()->get();
        if ($request->ajax()) {
            $data = ProjectModel::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->projectid.'" data-original-title="Edit" class="btn btn-warning btn-sm editProject"><i class="ti-pencil-alt"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->projectid.'" data-original-title="Quick Edit" class="btn btn-success btn-sm quickEditProject"><i class="mdi mdi-playlist-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->projectid.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProject"><i class="ti-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('project.index',compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        $rules = [
            'projectname' =>'unique:ngocphandang_project,projectname'
        ];
        $message = [
            'projectname.unique'=>'Tên Project đã tồn tại',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new ProjectModel();
        $data['projectname'] = $request->projectname;
        $data['template'] = $request->template;
        $data['ma_da'] = $request->ma_da;
        $data['package'] = $request->package;
        $data['title_app'] = $request->title_app;
        $data['buildinfo_app_name_x'] =  $request->buildinfo_app_name_x;
        $data['buildinfo_store_name_x'] =  $request->buildinfo_store_name_x;
        $data['buildinfo_link_policy_x'] = $request->buildinfo_link_policy_x;
        $data['buildinfo_link_fanpage'] = $request->buildinfo_link_fanpage;
        $data['buildinfo_link_website'] =  $request->buildinfo_link_website;
        $data['buildinfo_link_store'] = $request->buildinfo_link_store;
        $data['buildinfo_vernum' ]= $request->buildinfo_vernum;
        $data['buildinfo_verstr'] = $request->buildinfo_verstr;
        $data['buildinfo_keystore'] = $request->buildinfo_keystore;
        $data['ads_id'] = $request->ads_id;
        $data['ads_banner'] = $request->banner;
        $data['ads_inter'] = $request->ads_inter;
        $data['ads_reward'] = $request->ads_reward;
        $data['ads_native'] = $request->ads_native;
        $data['ads_open'] = $request->ads_open;
        $data['buildinfo_console'] = $request->buildinfo_console;

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



        ProjectModel::updateOrCreate(
            ['projectid' => $request->project_id],
            [
                'projectid' => $request->project_id,
                'projectname' => $request->projectname,
                'template' => $request->template,
                'ma_da' => $request->ma_da,
                'package' => $request->package,
                'title_app' =>$request->title_app,
                'buildinfo_app_name_x' => $request->buildinfo_app_name_x,
                'buildinfo_store_name_x' => $request->buildinfo_store_name_x,
                'buildinfo_link_policy_x' => $request->buildinfo_link_policy_x,
                'buildinfo_link_fanpage' => $request->buildinfo_link_fanpage,
                'buildinfo_link_website' => $request->buildinfo_link_website,
                'buildinfo_link_store' => $request->buildinfo_link_store,
                'buildinfo_vernum' => $request->buildinfo_vernum,
                'buildinfo_verstr' => $request->buildinfo_verstr,
                'buildinfo_keystore' => $request->buildinfo_keystore,
                'ads_id' => $request->ads_id,
                'ads_banner' => $request->banner,
                'ads_inter' => $request->ads_inter,
                'ads_reward' => $request->ads_reward,
                'ads_native' => $request->ads_native,
                'ads_open' => $request->ads_open,
                'buildinfo_console' => $request->buildinfo_console,
            ]);

        return response()->json(['success'=>'Book saved successfully.']);
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

        $project = ProjectModel::find($id);
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

        $id = $request->project_id;
        $rules = [
            'projectname' =>'unique:ngocphandang_project,projectname,'.$id.',projectid',
        ];
        $message = [
            'projectname.unique'=>'Tên Project đã tồn tại',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = ProjectModel::find($id);
        $data->projectname = $request->projectname;
        $data->template = $request->template;
        $data->ma_da = $request->ma_da;
        $data->package = $request->package;
        $data->title_app = $request->title_app;
        $data->buildinfo_app_name_x =  $request->buildinfo_app_name_x;
        $data->buildinfo_store_name_x =  $request->buildinfo_store_name_x;
        $data->buildinfo_link_policy_x = $request->buildinfo_link_policy_x;
        $data->buildinfo_link_fanpage = $request->buildinfo_link_fanpage;
        $data->buildinfo_link_website =  $request->buildinfo_link_website;
        $data->buildinfo_link_store = $request->buildinfo_link_store;
        $data->buildinfo_vernum= $request->buildinfo_vernum;
        $data->buildinfo_verstr = $request->buildinfo_verstr;
        $data->buildinfo_keystore = $request->buildinfo_keystore;
        $data->ads_id = $request->ads_id;
        $data->ads_banner = $request->banner;
        $data->ads_inter = $request->ads_inter;
        $data->ads_reward = $request->ads_reward;
        $data->ads_native = $request->ads_native;
        $data->ads_open = $request->ads_open;
        $data->buildinfo_console = $request->buildinfo_console;

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

        ProjectModel::find($id)->delete();

        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function callAction($method, $parameters)
    {
//        $this->AuthLogin();
        return parent::callAction($method, array_values($parameters));
    }
}
