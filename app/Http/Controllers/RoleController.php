<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{

    private $permission;
    private $role;
    public function __construct(Permission $permission, Role $role)
    {
        $this->permission = $permission;
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $permissionParent = $this->permission->where('parent_id',0)->get();
//        $permissionOfRole = $role->permissions;


        $role = Role::latest('id')->get();

        if ($request->ajax()) {
            $data = Role::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" onclick="editRole('.$row->id.')" class="btn btn-warning"><i class="ti-pencil-alt"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger deleteRole"><i class="ti-trash"></i></a>';

                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('role.index',compact(['role','permissionParent']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {



        $rules = [
            'name' =>'required|unique:roles,name,',
        ];
        $message = [
            'name.unique'=>'Tên vai trò đã tồn tại',
            'name.required'=>'Tên vai trò không để trống',
        ];

        $error = Validator::make($request->all(),$rules, $message );

        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
//        try {
//            DB::beginTransaction();
            $role = $this->role->create([
                'name' => $request->name,
                'display_name'=> $request->display_name,
            ]);
            $permissionIds = $request->permission_id;

            $role->permissions()->attach($permissionIds);
//            DB::commit();
            return response()->json(['success'=>'Thêm mới thành công']);
//        } catch (\Exception $exception) {
//            DB::rollBack();
//            Log::error('Message :' . $exception->getMessage() . '--- Line: ' . $exception->getLine());
//
//        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//
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
        $role = Role::find($id);
        $permissionOfRole = $role->permissions;

        return response()->json([$role,$permissionOfRole]);
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
        $id = $request->user_id;
        $rules = [
            'name' =>'unique:users,name,'.$id.',id',
            'email' =>'unique:users,email,'.$id.',id',
        ];
        $message = [
            'name.unique'=>'Tên người dùng đã tồn tại',
            'email.unique'=>'Email đã tồn tại',
        ];
//
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        try {
            DB::beginTransaction();
            if($request->password){
                $this->user->find($id)->update([
                    'name' => $request->name,
                    'email'=> $request->email,
                    'password' =>bcrypt($request->password),
                ]);
            }
            $this->user->find($id)->update([
                'name' => $request->name,
                'email'=> $request->email,
            ]);
            $roleIds = $request->role_id;
            $user = $this->user->find($id);
            $user->roles()->sync($roleIds);
            DB::commit();
            return response()->json(['success'=>'Thêm mới thành công']);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message :' . $exception->getMessage() . '--- Line: ' . $exception->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Role::find($id)->delete();
        return response()->json(['success'=>'Xóa người dùng.']);
    }

    public function callAction($method, $parameters)
    {
        return parent::callAction($method, array_values($parameters));
    }

}
