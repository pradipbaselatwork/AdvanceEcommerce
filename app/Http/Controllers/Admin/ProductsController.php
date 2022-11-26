<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Section;
use Image;
use Session;
use App\Brand;

class ProductsController extends Controller
{
    public function products(){
        Session::put('page','products');
        $products = Product::with(['category'=>function($query){
            $query->select('id','category_name');
        },'section'=>function($query){
            $query->select('id','name');
        }])->get();
        //$products = json_decode(json_encode($products),true);
        //echo "<pre>"; print_r($products); die;
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }

    public function deleteProductImage($id){
        //Get product image
        $productImage = Product::select('main_image')->where('id',$id)->first();

        //get product image path
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';

        //Delete small images from small folder if exists
        if(file_exists($small_image_path.$productImage->main_image)){
            unlink($small_image_path.$productImage->main_image);
        }

        //Delete medium images from medium folder if exists
        if(file_exists($medium_image_path.$productImage->main_image)){
            unlink($medium_image_path.$productImage->main_image);
        }

        //Delete large images from large folder if exists
        if(file_exists($large_image_path.$productImage->main_image)){
            unlink($large_image_path.$productImage->main_image);
        }

        //Delete product image from products table
        Product::where('id',$id)->update(['main_image'=>'']);
        $message ='Product image has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back(); 
  }

  public function deleteProduct($id){
    //Delete product
    Product::where('id',$id)->delete();
    $message ='Product has been deleted successfully!';
    Session::flash('success_message',$message);
    return redirect()->back();
}



  public function deleteProductVideo($id){
    //Get product video
    $productVideo = Product::select('product_video')->where('id',$id)->first();

    //get product video path
    $product_video_path = 'videos/product_videos/';

    //Delete product video from product_videos folder if exists
    if(file_exists($product_video_path.$productVideo->product_video)){
        unlink($product_video_path.$productVideo->product_video);
    }

    //Delete product video from categories table
    product::where('id',$id)->update(['product_video'=>'']);
    $message ='Product video has been deleted successfully!';
    Session::flash('success_message',$message);
    return redirect()->back(); 
}

  public function addAttributes(Request $request, $id){
   if($request->isMethod('post')){
       $data = $request->all();
        //echo "<pre>"; print_r($data); die;
        foreach($data['sku'] as $key=>$value){
            if(!empty($value)){

                //SKU already exists check
                $attrCountSKU = ProductsAttribute::where('sku',$value)->count();
                if($attrCountSKU>0){
                    $message = 'SKU already exists. Please add another SKU!';
                    Session::flash('error_message',$message);
                    return redirect()->back();
                }

                     //Size already exists check
                     $attrCountSize = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                     if($attrCountSize>0){
                         $message = 'Size already exists. Please add another Size!';
                         Session::flash('error_message',$message);
                         return redirect()->back();
                     }

                $attribute = new ProductsAttribute;
                $attribute->product_id = $id;
                $attribute->sku = $value;
                $attribute->size = $data['size'][$key];
                $attribute->price = $data['price'][$key];
                $attribute->stock = $data['stock'][$key];
                $attribute->status = 1;
                $attribute->save();
            }
        }
        $message ='Product Attributes has been added successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
   }

    $productdata = Product::select('id','product_name','product_code','product_color','main_image')->with('attributes')->find($id);
   //$productdata = json_decode(json_encode($productdata),true);
    $title = "Product Attributes";
    //echo "<pre>"; print_r($productdata); die;
   return view('admin.products.add_attributes')->with(compact('productdata','title'));
  }

 public function editAttributes(Request $request, $id){
    // echo"test"; die;
    if($request->isMethod('post')){
        $data= $request->all();
      // echo "<pre>"; print_r($data); die;
      foreach($data['attrId'] as $key => $attr) {
        if(!empty($attr)){
            ProductsAttribute::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
        }
      }
      $message ='Product Attributes has been upadated successfully!';
      Session::flash('success_message',$message);
      return redirect()->back();
    }
 }

 public function updateAttributeStatus(Request $request){
    if($request->ajax()){
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
    }
}
public function deleteAttribute($id){
    //Delete product
    ProductsAttribute::where('id',$id)->delete();
    $message ='Product Attributes has been deleted successfully!';
    Session::flash('success_message',$message);
    return redirect()->back();
}

public function addImages(Request $request, $id){
    if($request->isMethod('post')){
        // echo "<pre>"; print_r($request->all()); die;
        if($request->hasFile('image')){
            $images = $request->file('image');
            // dd($images);

            foreach($images as $key => $image){
                // return $images[1];
                $productImage = new ProductsImage;
                $image_tmp = Image::make($image);
                    //get image extension
                $extension = $image->getClientOriginalExtension();
                $imageName = rand(111,99999).time().".".$extension;

                //set paths for small medium and larage images
                $large_image_path = 'images/product_images/large/'.$imageName;
                $medium_image_path = 'images/product_images/medium/'.$imageName;
                $small_image_path = 'images/product_images/small/'.$imageName;

                //set path for small medium and large image for resize
                Image::make($image_tmp)->save($large_image_path);//w:1040  h:1200
                Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                //save main image in products table
                $productImage->image =$imageName;
                $productImage->product_id =$id;
                $productImage->save();
            }
            $message ='Product images has been added successfully!';
            Session::flash('success_message',$message);
            return redirect()->back();
          
        }
         
    }
        $productdata = Product::with('images')->select('id','product_name','product_code','product_color','main_image')->find($id);
        //$productdata = json_decode(json_encode($productdata),true);
        //  echo "<pre>"; print_r($productdata); die;  
         $title="Product Images";
        return view('admin.products.add_images')->with(compact('productdata','title'));
}



public function updateImageStatus(Request $request){
    if($request->ajax()){
        $data = $request->all();
        // echo "<pre>"; print_r($data); die;
        if($data['status']=="Active"){
            $status = 0;
        }else{
            $status = 1;
        }
        ProductsImage::where('id',$data['image_id'])->update(['status'=>$status]);
        return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
    }
}
public function deleteImage($id){
    //Delete product
    ProductsImage::where('id',$id)->delete();
    $message ='Product Images has been deleted successfully!';
    Session::flash('success_message',$message);
    return redirect()->back();
}

    public function addEditProduct(Request $request, $id=null){
        if($id==""){
               //Add category functionality
            $title = "Add Products"; 
            $product = New Product;  
            $productdata = Array(); 
            $message = "Product added successfully!";
        }else{
             //Edit Products functionality
            $title = "Edit Products"; 
            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata),true);
            // echo "<pre>"; print_r($productdata); die;
            $product = Product::find($id);
            $message = "Product updated successfully!";
        }

        if($request->isMethod('post')){

            $data= $request->all();
           // echo "<pre>"; print_r($data); die;
           $rules = [
            'category_id' => 'required',
            'brand_id' => 'required',
            'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'product_code' => 'required|regex:/^[\w-]*$/',
            'product_price' => 'required|numeric',
            'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
        ];

        $customMessages = [
            'category_id.required' => 'Category is required',
            'brand_id.required' => 'Brand is required',
            'product_name.required' => 'Product Name is required',
            'product_name.regex' => 'Valid Product Name is required',
            'product_code.required' => 'Product Code is required',
            'product_code.regex' => 'Valid Product Code is required',
            'product_price.required' => 'Product Price is required',
            'product_price.numeric' => 'Valid Product Price is required',
            'product_color.required' => 'Product Color is required',
            'product_color.regex' => 'Valid Product Color is required',
        ];

        $this->validate($request,$rules,$customMessages);
        
        if(empty($data['is_featured'])){
            $is_featured = "No";
        }else{
            $is_featured = "Yes";
        }
 //dd($is_featured); die;
        // if(empty($data['product_price']))
        // {
        //     $data['product_price'] = "";
        // }

        if(empty($data['product_weight']))
        {
            $data['product_weight'] = "";
        }

        // if(empty($data['product_video']))
        // {
        //     $data['product_video'] = "";
        // }

        // if(empty($data['main_video']))
        // {
        //     $data['main_image'] = "";
        // }

        if(empty($data['product_discount']))
        {
            $data['product_discount'] = 0;
        }

        if(empty($data['wash_care']))
        {
            $data['wash_care'] = "";
        }

        if(empty($data['fabric']))
        {
            $data['fabric'] = "";
        }

        if(empty($data['pattern']))
        {
            $data['pattern'] = "";
        }

        if(empty($data['sleeve']))
        {
            $data['sleeve'] = "";
        }

        if(empty($data['fit']))
        {
            $data['fit'] = "";
        }

        if(empty($data['occassion']))
        {
            $data['occassion'] = "";
        }

        if(empty($data['description']))
        {
            $data['description'] = "";
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

        //upload product image
        if($request->hasFile('main_image')){
            $image_tmp = $request->file('main_image');
            if($image_tmp->isValid()){
                //get orginal image name
                $image_name = $image_tmp->getClientOriginalName();
                //get image extension
                $extension = $image_tmp->getClientOriginalExtension();
                //generate new image name
                $imageName = $image_name.'-'.rand(111,99999).'.'.$extension;
               //set path for small medium and large image
                $large_image_path = 'images/product_images/large/'.$imageName;
                $medium_image_path = 'images/product_images/medium/'.$imageName;
                $small_image_path = 'images/product_images/small/'.$imageName;

                //upload medium and small images after resize
                Image::make($image_tmp)->save($large_image_path);//w:1040  h:1200
                Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                //save main image in products table
                $product->main_image =$imageName;
            }
        }

        //upload product video
        if($request->hasFile('product_video')){
           $video_tmp = $request->file('product_video'); 
           if($video_tmp->isValid()){
            //upload video
            $video_name = $video_tmp->getClientOriginalName();
            $extension = $video_tmp->getClientOriginalExtension();
            $videoName = $video_name.'-'.rand().'.'.$extension;
            $video_path = 'videos/product_videos';
            $video_tmp->move($video_path,$videoName);
            //Save video in products table
            $product->product_video =$videoName;
        }
        }


        //Save Product Details in Product tables
         $categoryDetails = Category::find($data['category_id']);
         $product->section_id = $categoryDetails['section_id'];
         $product->brand_id = $data['brand_id'];
         $product->category_id = $data['category_id'];
         $product->product_name = $data['product_name'];
         $product->product_code = $data['product_code'];
         $product->product_color = $data['product_color'];
         $product->product_price = $data['product_price'];
         $product->product_discount = $data['product_discount'];
         $product->product_weight = $data['product_weight'];
         $product->description = $data['description'];
         $product->wash_care = $data['wash_care'];
         $product->fabric = $data['fabric'];
         $product->pattern = $data['pattern'];
         $product->sleeve = $data['sleeve'];
         $product->fit = $data['fit'];
         $product->occassion = $data['occassion'];
         $product->meta_title = $data['meta_title'];
         $product->meta_keywords = $data['meta_keywords'];
         $product->meta_description = $data['meta_description'];
         $product->is_featured = $is_featured;
         $product->status = 1;
         $product->save();
         Session::flash('success_message',$message);
         return redirect('admin/products');
        }

        //Product Filters
        $productFilters = Product::productFilters();
        $fabricArray = $productFilters['$fabricArray'];
        $sleeveArray = $productFilters['$sleeveArray'];
        $patternArray = $productFilters['$patternArray'];
        $fitArray = $productFilters['$fitArray'];
        $occassionArray = $productFilters['$occassionArray'];

    //Sections with categories and sub categories
    $categories = Section::with('categories')->get();
     // $categories = json_decode(json_encode($categories),true);
    //echo "<pre>"; print_r($categories); die;

    //Get ALL Brands
    $brands = Brand::where('status',1)->get();
    $brands = json_decode(json_encode($brands),true);
        
        Session::flash('page', 'product');
        return view('admin.products.add_edit_product')->with(compact('title','fabricArray','sleeveArray','patternArray','fitArray','occassionArray','categories','productdata','brands'));

    }



    
}
