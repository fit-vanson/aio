<?php

namespace App\Http\Controllers;


use App\Models\Ga_dev;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class Ga_devController extends Controller
{
    public function index(Request $request)
    {

        $ga_dev = Ga_dev::all();
//        dd($request);


        if ($request->ajax()) {
            $data = Ga_dev::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->gmail.'" data-original-title="Edit" class="btn btn-warning btn-sm editGadev"><i class="ti-pencil-alt"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->gmail.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteGadev"><i class="ti-trash"></i></a>';
                    return $btn;
                })
                ->editColumn('bk1', function($data){
                    if ($data->bk_1 !== null){
                        return "<i style='color:green;' class='ti-check-box h5'></i>";
                    }
                    return "<i style='color:red;' class='ti-close h5'></i>";
                })
                ->editColumn('bk2', function($data){
                    if ($data->bk_2 !== null){
                        return "<i style='color:green;' class='ti-check-box h5'></i>";
                    }
                    return "<i style='color:red;' class='ti-close h5'></i>";
                })
                ->editColumn('bk3', function($data){
                    if ($data->bk_3 !== null){
                        return "<i style='color:green;' class='ti-check-box h5'></i>";
                    }
                    return "<i style='color:red;' class='ti-close h5'></i>";
                })
                ->editColumn('bk4', function($data){
                    if ($data->bk_4 !== null){
                        return "<i style='color:green;' class='ti-check-box h5'></i>";
                    }
                    return "<i style='color:red;' class='ti-close h5'></i>";
                })
                ->editColumn('bk5', function($data){
                    if ($data->bk_5 !== null){
                        return "<i style='color:green;' class='ti-check-box h5'></i>";
                    }
                    return "<i style='color:red;' class='ti-close h5'></i>";
                })
                ->editColumn('bk6', function($data){
                    if ($data->bk_6 !== null){
                        return "<i style='color:green;' class='ti-check-box h5'></i>";
                    }
                    return "<i style='color:red;' class='ti-close h5'></i>";
                })
                ->editColumn('bk7', function($data){
                    if ($data->bk_7 !== null){
                        return "<i style='color:green;' class='ti-check-box h5'></i>";
                    }
                    return "<i style='color:red;' class='ti-close h5'></i>";
                })
                ->editColumn('bk8', function($data){
                    if ($data->bk_8 !== null){
                        return "<i style='color:green;' class='ti-check-box h5'></i>";
                    }
                    return "<i style='color:red;' class='ti-close h5'></i>";
                })
                ->editColumn('bk9', function($data){
                    if ($data->bk_9 !== null){
                        return "<i style='color:green;' class='ti-check-box h5'></i>";
                    }
                    return "<i style='color:red;' class='ti-close h5'></i>";
                })
                ->editColumn('bk10', function($data){
                    if ($data->bk_10 !== null){
                        return "<i style='color:green;' class='ti-check-box h5'></i>";
                    }
                    return "<i style='color:red;' class='ti-close h5'></i>";
                })
                ->rawColumns(['action','bk1','bk2','bk3','bk4','bk5','bk6','bk7','bk8','bk9','bk10'])
                ->make(true);
        }
        return view('gadev.index',compact('ga_dev'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        $rules = [
            'gmail' =>'unique:ngocphandang_gadev,gmail'
        ];
        $message = [
            'gmail.unique'=>'Gmail đã tồn tại',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new Ga_dev();
        $data['gmail'] = $request->gmail;
        $data['mailrecovery'] = $request->mailrecovery;
        $data['vpn_iplogin'] = $request->vpn_iplogin;
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
        $gadev = Ga_dev::find($id);
        return response()->json($gadev);
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
        $id = $request->gadev_id;
        $rules = [
            'gmail' =>'unique:ngocphandang_gadev,gmail,'.$id.',gmail',
        ];
        $message = [
            'gmail.unique'=>'Tên Gmail đã tồn tại',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = Ga_dev::find($id);
        $data->gmail = $request->gmail;
        $data->mailrecovery = $request->mailrecovery;
        $data->vpn_iplogin= $request->vpn_iplogin;
        $data->bk_1= $request->bk_1;
        $data->bk_2= $request->bk_2;
        $data->bk_3= $request->bk_3;
        $data->bk_4= $request->bk_4;
        $data->bk_5= $request->bk_5;
        $data->bk_6= $request->bk_6;
        $data->bk_7= $request->bk_7;
        $data->bk_8= $request->bk_8;
        $data->bk_9= $request->bk_9;
        $data->bk_10= $request->bk_10;
        $data->note= $request->note;
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
        Ga_dev::find($id)->delete();

        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function callAction($method, $parameters)
    {
//        $this->AuthLogin();
        return parent::callAction($method, array_values($parameters));
    }
}
