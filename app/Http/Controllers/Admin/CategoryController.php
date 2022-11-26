<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Section;
use Session;
use Image;

class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with(['section','parentcategory'])->get();
        // $categories = json_decode(json_encode($categories));
        //echo "<pre>"; print_r($categories); die;
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id=null){
        if($id==""){
               //Add category functionality
            $title = "Add Category";
            $button ="Submit";
            $category = new Category;
            $categorydata = array();
            $getCategories = array();
            $message = "Category has been added sucessfully";
        }else{
             //Edit category functionality
            $title = "Edit Category";
            $button ="Update";
            $categorydata = Category::where('id',$id)->first();
            $categorydata = json_decode(json_encode($categorydata),true);
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$categorydata['section_id']])->get();
            $category = Category::find($id);
            $message = "Category has been updated sucessfully";

        }

        if($request->isMethod('post')) {
 $data = $request->all();
    // echo "<pre>"; print_r($data); die;
            //dd($data);
            // if(empty($data['category_name'])){
            //     return redirect()->back()->with('error_message', 'Category name is required !');
            // }
            // if(empty($data['category_name']))
            // {
            //     $data['category_name'] = "";
            // }
              
            // if(empty($data['parent_id']))
            // {
            //     $data['parent_id'] = "";
            // }
            if(empty($data['section_id']))
            {
                $data['section_id'] = "";
            }
            // if(empty($data['category_image']))
            // {
            //     $data['category_image'] = "";
            // }
               
            // if(empty($data['category_discount']))
            // {
            //     $data['category_discount'] = "";
            // }
            if(empty($data['description']))
            {
                $data['description'] = "";
            }
               
            if(empty($data['url']))
            {
                $data['url'] = "";
            }
            if(empty($data['meta_title']))
            {
                $data['meta_title'] = "";
            }
            if(empty($data['meta_description']))
            {
                $data['meta_description'] = "";
            }
            if(empty($data['meta_keywords']))
            {
                $data['meta_keywords'] = "";
            }
            if(empty($data['status']))
            {
                $data['status'] = "";
            }

            if(!empty($data['category_image'])){
                $image_tmp = $data['category_image'];
                // dd($image_tmp);
                if($image_tmp->isValid())
                {
                    // get extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // generate new image name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'images/category_images/'.$imageName;
                    $result = Image::make($image_tmp)->save($imagePath);
                    // dd($result);
                    $category->category_image =$imagePath;
    
                }
            }
       
            // $category->admin_id = auth('admin')->user()->id;
            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();
            Session::flash('success_message', $message);
            return redirect('admin/categories');
        }
        //Get all sections
        $getSections = Section::get();

        return view('admin.categories.add_edit_category')->with(compact('title','getSections','categorydata','button','getCategories'));
    }

    public function appendCategoryLevel(Request $request){
           if($request->ajax()){
               $data = $request->all();
            //   
            $getCategories = Category::with('subcategories')->where(['section_id'=>$data['section_id'],'parent_id'=>0,'status'=>1])->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            // echo "<pre>"; print_r($getCategories); die;
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
           }
    }

    public function deleteCategoryImage($id){
          //Get category image
          $categoryImage = Category::select('category_image')->where('id',$id)->first();

          //get category image path
          $category_image_path = 'images/category_images';

          //Delete category image from category_images folder if exists
          if(file_exists($category_image_path.$categoryImage->category_image)){
              unlink($category_image_path.$categoryImage->category_image);
          }

          //Delete category image from categories table
          Category::where('id',$id)->update(['category_image'=>'']);
          $message ='Category image has been deleted successfully!';
          Session::flash('success_message',$message);
          return redirect()->back(); 
    }

    public function deleteCategory($id){
        //Delete category
        Category::where('id',$id)->delete();

        $message ='Category has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
}
