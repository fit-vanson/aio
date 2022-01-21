<?php

namespace App\Http\Controllers;


use App\Models\cocsim;
use App\Models\khosim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KhosimController extends Controller
{

    public function index()
    {
        $cocsim = cocsim::all();
        return view('khosim.index',compact(['cocsim']));
    }

    /* Process ajax request */
    public function getKhosim(Request $request)
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
        $totalRecords = khosim::select('count(*) as allcount')->count();
        $totalRecordswithFilter = khosim::select('count(*) as allcount')->where('phone', 'like', '%' . $searchValue . '%')->count();

        // Get records, also we have included search filter as well
        $records = khosim::join('ngocphandang_cocsim','ngocphandang_cocsim.id','ngocphandang_khosim.cocsim')
            ->where('ngocphandang_khosim.phone', 'like', '%' . $searchValue . '%')

            ->orWhere('ngocphandang_khosim.cocsim', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_khosim.time', 'like', '%' . $searchValue . '%')
            ->select('ngocphandang_khosim.*','ngocphandang_cocsim.cocsim as cocsim_name')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "phone" => $record->phone,
                "cocsim" => $record->cocsim_name,
                "stt" => $record->stt,
                "action" => '<a href="javascript:void(0)" onclick="editKhosim('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>' . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteKhosim"><i class="ti-trash"></i></a>' ,

                "time" => date('d-m-Y',$record->time),
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rules = [
            'phone' =>'numeric|unique:ngocphandang_khosim,phone',
            'stt' =>'numeric|min:1|max:15'
        ];
        $message = [
            'phone.unique'=>'Phone đã tồn tại',
            'phone.numeric'=>'Phone là số',
            'stt.numeric'=>'STT là số',
            'stt.min'=>'STT tối thiệu là 1',
            'stt.max'=>'STT tối đa là 15',

        ];


        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }

        $data = new khosim();
        $data['phone'] = $request->phone;
        $data['cocsim'] = $request->cocsim;
        $data['stt'] = $request->stt;
        $data['time'] = 0;
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
        $dev = khosim::find($id);
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
            'phone' =>'numeric|unique:ngocphandang_khosim,phone,'.$id.',id',
            'stt' =>'numeric|min:1|max:15'
        ];
        $message = [
            'phone.unique'=>'Phone đã tồn tại',
            'phone.numeric'=>'Phone là số',
            'stt.numeric'=>'STT là số',
            'stt.min'=>'STT tối thiệu là 1',
            'stt.max'=>'STT tối đa là 15',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = khosim::find($id);
        $data->phone = $request->phone;
        $data->cocsim = $request->cocsim;
        $data->stt = $request->stt;
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
        khosim::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }

    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }

}
