<?php

namespace App\Http\Controllers;


use App\Models\CategoryTemplate;
use App\Models\Da;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryTemplateController extends Controller
{
    public function create(Request  $request)
    {


        $rules = [
            'category_template_name' =>'unique:category_templates,category_template_name',
        ];
        $message = [
            'category_template_name.unique'=>'Tên đã tồn tại',
        ];
        $error = Validator::make($request->all(),$rules, $message );
        if($error->fails()){
            return response()->json(['errors'=> $error->errors()->all()]);
        }
        $data = new CategoryTemplate();
        $data['category_template_name'] = $request->category_template_name;
        $data['category_template_parent'] = $request->category_template_parent ? $request->category_template_parent : 0;
        $data->save();
        $allCateTemp  = CategoryTemplate::latest()->where('category_template_parent',0)->get();
        $allCateTempChild  = CategoryTemplate::latest()->where('category_template_parent','<>',0)->get();

        return response()->json([
            'success'=>'Thêm mới thành công',
            'cate_temp' => $allCateTemp,
            'allCateTempChild' => $allCateTempChild,
        ]);

    }
    public function getCateTempParent($id){
        $cateParent = CategoryTemplate::where('category_template_parent',$id)->get();
        $cateName = CategoryTemplate::find($id);
        return response()->json([
            'success'=>'Thêm mới thành công',
            'cateParent' => $cateParent,
            'cateName' => $cateName
        ]);

    }
}
