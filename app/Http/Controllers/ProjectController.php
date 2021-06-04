<?php

namespace App\Http\Controllers;

use App\Models\Da;
use App\Models\Dev;

use App\Models\ProjectModel;
use App\Models\Template;

use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use voku\helper\HtmlDomParser;
use voku\helper\SimpleHtmlDomNode;
use Yajra\DataTables\Facades\DataTables;
use function simplehtmldom_1_5\file_get_html;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $da =  Da::latest('id')->get();
        $template =  Template::latest('id')->get();
        $store_name=  Dev::latest('id')->get();
        $project = ProjectModel::latest()->get();
        if ($request->ajax()) {
            $data = ProjectModel::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = ' <a href="javascript:void(0)" onclick="editProject('.$row->projectid.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
                    $btn = $btn. ' <a href="javascript:void(0)" onclick="quickEditProject('.$row->projectid.')" class="btn btn-success"><i class="mdi mdi-playlist-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->projectid.'" data-original-title="Delete" class="btn btn-danger deleteProject"><i class="ti-trash"></i></a>';
                    return $btn;
                })
                ->editColumn('title_app', function($data){
                        return '
                                    <span>'.$data->title_app.'</span>
                                    <p class="text-muted m-b-30 ">'.$data->package.'</p>
                                ';
                })
                ->editColumn('bot_imglogo', function($data){
                    if($data->bot_imglogo == null ){
                        return '<img width="60px" height="60px" src="assets\images\logo.png">';
                    }
                    return '<a  target= _blank href='.$data->buildinfo_link_store.'><img width="60px" height="60px" src='.$data->bot_imglogo.'></a>';
                })

                ->editColumn('ma_da', function($data){
                    $ma_da = DB::table('ngocphandang_project')
                        ->join('ngocphandang_da','ngocphandang_da.id','=','ngocphandang_project.ma_da')
                        ->where('ngocphandang_da.id',$data->ma_da)
                        ->first();
                    if($ma_da != null){
                        return $ma_da->ma_da;
                    }
                })
                ->editColumn('template', function($data){
                    $template = DB::table('ngocphandang_project')
                        ->join('ngocphandang_template','ngocphandang_template.id','=','ngocphandang_project.template')
                        ->where('ngocphandang_template.id',$data->template)
                        ->first();
                    if($template != null){
                        return $template->template;
                    }
                })

                ->rawColumns(['action','title_app','bot_imglogo'])
                ->make(true);
        }
        return view('project.index',compact(['project','template','da','store_name']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        $rules = [
            'projectname' =>'required|unique:ngocphandang_project,projectname',
            'ma_da' => 'required',
            'template' => 'required',
            'title_app' =>'required',
            'buildinfo_vernum' =>'required',
            'buildinfo_verstr' =>'required',
        ];
        $message = [
            'projectname.unique'=>'Tên Project đã tồn tại',
            'projectname.required'=>'Tên Project không để trống',
            'ma_da.required'=>'Mã dự án không để trống',
            'template.required'=>'Mã template không để trống',
            'title_app.required'=>'Tiêu đề ứng không để trống',
            'buildinfo_vernum.required'=>'Version Number không để trống',
            'buildinfo_verstr.required'=>'Version String không để trống',
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
        $data['buildinfo_console'] = 0;
        $data['buildinfo_api_key_x'] = $request->buildinfo_api_key_x;
        $data['buildinfo_link_youtube_x'] = $request->buildinfo_link_youtube_x;
        $data['buildinfo_api_key_x'] = $request->buildinfo_api_key_x;
        $data['status'] = 0;
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
        $project = ProjectModel::where('projectid',$id)->first();
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
            'ma_da' => 'required',
            'template' => 'required',
            'title_app' =>'required',
            'buildinfo_vernum' =>'required',
            'buildinfo_verstr' =>'required',
        ];
        $message = [
            'projectname.unique'=>'Tên Project đã tồn tại',
            'projectname.required'=>'Tên Project không để trống',
            'ma_da.required'=>'Mã dự án không để trống',
            'template.required'=>'Mã template không để trống',
            'title_app.required'=>'Tiêu đề ứng không để trống',
            'buildinfo_vernum.required'=>'Version Number không để trống',
            'buildinfo_verstr.required'=>'Version String không để trống',
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
        $data->buildinfo_api_key_x = $request->buildinfo_api_key_x;
        $data->buildinfo_link_youtube_x = $request->buildinfo_link_youtube_x;
        $data->buildinfo_api_key_x = $request->buildinfo_api_key_x;
        $data->status = $request->status;


        if(isset($data->package)){
            $url = 'https://play.google.com/store/apps/details?id='.$data->package.'&hl=en';
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_NOBODY, true);
            $result = curl_exec($curl);
            if ($result !== false)
            {
                $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($statusCode == 404)
                {
                    return response()->json(['success'=>'Cập nhật thành công']);
                }
                else
                {
                    $html  = HtmlDomParser::file_get_html($url)->outerHtml();
                    $document = new \voku\helper\HtmlDomParser($html);
                    $dom = [];
                    foreach ($this->find_contains($document, 'div .IQ1z0d span .htlgb') as $child_dom) {
                        $dom[] = $child_dom->text();
                    }
                    $data->bot_verstr = $dom[3];
                    $data->bot_update = $dom[0];
                    $data->bot_install = $dom[2];
                    $data->bot_storename = $dom[8];
                }
            }
            else
            {
                return response()->json(['success'=>'Cập nhật thành công']);
            }


        }




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


    function find_contains(
        \voku\helper\HtmlDomParser $dom,
        string $selector,
        string $keyword = null
    ) {
        // init
        $elements = new SimpleHtmlDomNode();

        foreach ($dom->find($selector) as $e) {
            if (strpos($e->innerText(), $keyword) !== false) {
                $elements[] = $e;
            }
        }

        return $elements;
    }

// -----------------------------------------------------------------------------




    public function getList(){
        $url = 'https://play.google.com/store/apps/details?id=com.netringtones.astrohitspopular';
        $html  = HtmlDomParser::file_get_html($url)->text();
        $document = new \voku\helper\HtmlDomParser($html);
        dd($document);
        $dom = [];
        foreach ($this->find_contains($document, '.KZnDLd .r2Osbf ') as $child_dom) {
               $dom[] =  $child_dom->html() . "\n";
        }
        dd ($dom);
    }













}
