<?php

namespace App\Http\Controllers;

use App\Models\MailParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MailParentController extends Controller
{
    public function index()
    {
        return view('mailparent.index');
    }

    public function indexNo()
    {
        return view('mailparent.indexNo');
    }

    /* Process ajax request */
    public function getMailParents(Request $request)
    {
        dd($request);
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
        $totalRecords = MailParent::select('count(*) as allcount')->count();
        $totalRecordswithFilter = MailParent::select('count(*) as allcount')
            ->where('ngocphandang_parent.user', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_parent.phone', 'like', '%' . $searchValue . '%')
            ->count();

        // Get records, also we have included search filter as well
        $records = MailParent::orderBy($columnName, $columnSortOrder)
            ->where('ngocphandang_parent.user', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_parent.phone', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_parent.timeadd', 'like', '%' . $searchValue . '%')
            ->select('ngocphandang_parent.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                "user" => $record->user,
                "phone" => $record->phone,
                "timeadd" => date('d-m-Y',$record->timeadd),
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

    public function getMailParentsNo(Request $request)
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

        // Get records, also we have included search filter as well
        $records = DB::table('ngocphandang_parent')
            ->leftJoin('ngocphandang_khosim','ngocphandang_khosim.phone','=','ngocphandang_parent.phone')
            ->where('ngocphandang_parent.user', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_parent.phone', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_parent.timeadd', 'like', '%' . $searchValue . '%')
            ->whereNull('ngocphandang_khosim.phone')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $totalRecords = MailParent::select('count(*) as allcount')
            ->whereNotExists(function($query)
            {
                $query->select(DB::raw('ngocphandang_khosim.phone'))
                    ->from('ngocphandang_khosim')
                    ->whereRaw('ngocphandang_khosim.phone = ngocphandang_parent.phone');
            })
            ->count();
        $totalRecordswithFilter = MailParent::select('count(*) as allcount')
            ->where('ngocphandang_parent.user', 'like', '%' . $searchValue . '%')
            ->orWhere('ngocphandang_parent.phone', 'like', '%' . $searchValue . '%')
            ->whereNotExists(function($query)
            {
                $query->select(DB::raw('ngocphandang_khosim.phone'))
                    ->from('ngocphandang_khosim')
                    ->whereRaw('ngocphandang_khosim.phone = ngocphandang_parent.phone');
            })
            ->dd();
        $data_arr = array();
        foreach ($records as $record) {

            $data_arr[] = array(
                "user" => $record->user,
                "phone" => $record->phone,
                "timeadd" => date('d-m-Y',$record->timeadd),
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
}
//



