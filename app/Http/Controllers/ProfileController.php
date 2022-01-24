<?php

namespace App\Http\Controllers;

use App\Models\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index()
    {
//        $ga_name = Ga::orderBy('ga_name','asc')->get();
//        $ga_dev = Ga_dev::orderBy('gmail','asc')->get();
        return view('profile.index');
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
        $totalRecords = Profile::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Profile::select('count(*) as allcount')
            ->where('profile_name', 'like', '%' . $searchValue . '%')
            ->orwhere('profile_sdt', 'like', '%' . $searchValue . '%')
            ->orWhere('profile_dia_chi', 'like', '%' . $searchValue . '%')
            ->orWhere('profile_cccd', 'like', '%' . $searchValue . '%')
            ->count();

        // Get records, also we have included search filter as well
        $records = Profile::orderBy($columnName, $columnSortOrder)
            ->where('profile_name', 'like', '%' . $searchValue . '%')
            ->orwhere('profile_sdt', 'like', '%' . $searchValue . '%')
            ->orWhere('profile_dia_chi', 'like', '%' . $searchValue . '%')
            ->orWhere('profile_cccd', 'like', '%' . $searchValue . '%')

            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = array();
        foreach ($records as $record) {
            $btn = ' <a href="javascript:void(0)" onclick="editProfile('.$record->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$record->id.'" data-original-title="Delete" class="btn btn-danger deleteProfile"><i class="ti-trash"></i></a>';
            $data_arr[] = array(
                "profile_logo" => $record->profile_logo,
                "profile_name" => $record->profile_name,
                "profile_sdt" => $record->profile_sdt,
                "profile_dia_chi" => $record->profile_dia_chi,
                "profile_cccd" => $record->profile_cccd,
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
//        dd($request->all());


        $rules = [
            'profile_name' =>'unique:ngocphandang_profiles,profile_name',

        ];
        $message = [
            'profile_name.unique'=>'Tên đã tồn tại',


        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }


        $data = new Profile();
        $destinationPath = public_path('uploads/profile');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $destinationPath_logo = public_path('uploads/profile/logo/');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $data['profile_name'] = $request->profile_name;
        $data['profile_sdt'] = $request->profile_sdt;
        $data['profile_dia_chi'] = $request->profile_dia_chi;
        $data['profile_cccd'] = $request->profile_cccd;
        $data['profile_anh_cccd'] = $request->profile_anh_cccd ? 1 :0 ;
        $data['profile_anh_bang_lai'] = $request->profile_anh_bang_lai ? 1 :0 ;
        $data['profile_anh_ngan_hang'] = $request->profile_anh_ngan_hang ? 1 :0 ;

        $img_file  = $request->logo;
        $img = Image::make($img_file);
        $imgName = $img_file->getClientOriginalName();
        $img->save($destinationPath_logo.$imgName);
        $data['profile_logo'] = $imgName;

        $file = $request->profile_file;
        $file_name = $file->getClientOriginalname();
        $data['profile_file'] = $file_name;
        $file->move($destinationPath, $data['profile_file']);

        $data->save();
        return response()->json([
            'success'=>'Thêm mới thành công',
        ]);
    }
    public function edit($id)
    {
        $data = Profile::find($id);
        return response()->json($data);

    }
    public function update(Request $request)
    {
        $id = $request->Profile_id;
        $rules = [
            'profile_name' =>'unique:ngocphandang_profiles,profile_name,'.$id.',id',
        ];
        $message = [
            'profile_name.unique'=>'Tên đã tồn tại',
        ];

        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = Profile::find($id);
        $data->profile_name = $request->profile_name;
        $data->profile_sdt = $request->profile_sdt;
        $data->profile_dia_chi = $request->profile_dia_chi;
        $data->profile_cccd = $request->profile_cccd;
        $data->profile_anh_cccd = $request->profile_anh_cccd ? 1 :0 ;
        $data->profile_anh_bang_lai = $request->profile_anh_bang_lai ? 1 :0 ;
        $data->profile_anh_ngan_hang = $request->profile_anh_ngan_hang ? 1 :0 ;
        if($request->logo){
            $path_Remove =  public_path('uploads/profile/logo/').$data->profile_logo;

            if(file_exists($path_Remove)){
                unlink($path_Remove);
            }
            $destinationPath_logo = public_path('uploads/profile/logo/');
            if (!file_exists($destinationPath_logo)) {
                mkdir($destinationPath_logo, 0777, true);
            }


            $img_file  = $request->logo;
            $img = Image::make($img_file);
            $imgName = $img_file->getClientOriginalName();
            $img->save($destinationPath_logo.$imgName);
            $data['profile_logo'] = $imgName;


        }
        if($request->profile_file){
            $path_Remove =  public_path('uploads/profile/').$data->profile_file;

            if(file_exists($path_Remove)){
                unlink($path_Remove);
            }
            $destinationPath = public_path('uploads/profile/');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file = $request->profile_file;
            $file_name = $file->getClientOriginalname();
            $data->profile_file = $file_name;
            $file->move($destinationPath, $data['profile_file']);
        }
        $data->save();
        return response()->json(['success'=>'Cập nhật thành công']);
    }
    public function delete($id)
    {
        Profile::find($id)->delete();
        return response()->json(['success'=>'Xóa thành công.']);
    }
    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }
}
