<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand;
use Session;
use Image;

class BrandController extends Controller
{
    public function Brands()
    {
        $brands = Brand::get();
        Session::flash('page', 'brands');
        return view('admin.brands.brands', compact('brands'));
    }

    
    public function updateBrandStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Brand::where('id',$data['brand_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'brand_id'=>$data['brand_id']]);
        }
    }

    public function addEditBrand(Request $request, $id=null)
    {
        if($id=="") {
            $title = "Add Brand";
            $button ="Submit";
            $brand = new Brand;
            $branddata = array();
            $message = "Brand has been added sucessfully";
        }else{
            $title = "Edit Brand";
            $button ="Update";
            $brand = Brand::where('id',$id)->first();
            $branddata= json_decode(json_encode($brand),true);
            $brand = Brand::find($id);
            $message = "Brand has been updated sucessfully";
        }
        if($request->isMethod('post')) {
          $data = $request->all();
            //dd($data);
          
            if(empty($data['name']))
            {
                $data['name'] = "";
            }
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];

            $customMessages = [
                'name.required' => 'Brand Name is required',
                'name.regex' => 'Valid Brand Name is required',
            ];

            $this->validate($request,$rules,$customMessages);
       
            $brand->name = $data['name'];
            $brand->save();
            Session::flash('success_message',$message);
            return redirect('admin/brands');
        }
        return view('admin.brands.add_edit_brand', compact('title','button','branddata'));
    }

    public function deleteBrand($id)
    {
      $id =Brand::find($id);
      $id->delete();
      return redirect()->back()->with('success_message', 'Brand has been deleted successfully!');

    }
}