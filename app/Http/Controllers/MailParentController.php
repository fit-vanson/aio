<?php

namespace App\Http\Controllers;

use App\Models\MailParent;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MailParentController extends Controller
{
    public function index(Request $request)
    {
        $parent = MailParent::latest('timeadd')->limit(100,100)->get();
        if ($request->ajax()) {
            $data = MailParent::latest('timeadd')->limit(100,100)->get();
            return Datatables::of($data)
                ->make(true);
        }
        return view('mailparent.index',compact(['parent']));
    }
}
//4&pm42xS@
