<?php

namespace App\Http\Controllers;

use App\Models\cocsim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CocsimController extends Controller
{
    public function index(Request $request)
    {
        $cocsim= cocsim::latest('id')->get();
        if ($request->ajax()) {
            $data = cocsim::latest('id')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = ' <a href="javascript:void(0)" onclick="editCocsim('.$row->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger deleteCocsim"><i class="ti-trash"></i></a>';
                    return $btn;
                })
                ->editColumn('time', function($data) {
                    if($data->time == 0 ){
                        return  null;
                    }
                    return date( 'd/m/Y - H:i:s ',$data->time);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('cocsim.index',compact(['cocsim']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
        $rules = [
            'cocsim' =>'unique:ngocphandang_cocsim,cocsim',

        ];
        $message = [
            'cocsim.unique'=>'Tên cọc sim đã tồn tại',

        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new cocsim();
        $data['cocsim'] = $request->cocsim;
        $data['note'] = $request->note;
        $data['time'] = time();
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
        $dev = cocsim::find($id);
        return response()->json($dev);
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
        $id = $request->id;
        $rules = [
            'cocsim' =>'unique:ngocphandang_cocsim,cocsim,'.$id.',id'

        ];
        $message = [
            'cocsim.unique'=>'Tên cọc sim đã tồn tại',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = cocsim::find($id);
        $data->cocsim = $request->cocsim;
        $data->note = $request->note;
        $data->time = time();
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
        cocsim::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }
}
