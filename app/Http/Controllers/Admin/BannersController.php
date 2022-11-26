<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Session;
use Image;

class BannersController extends Controller
{
    public function banners()
     {
        $banners = Banner::get()->toArray();
        Session::flash('page', 'banners');
       // dd($banners); die;
       return view('admin.banners.banners')->with(compact('banners'));
     }

     public function addEditBanner(Request $request, $id=null)
     {
         if($id=="") {
             $title = "Add Banner Image";
             $button ="Submit";
             $banner = new Banner;
             $bannerdata = array();
             $message = "Banner Image has been added sucessfully!";
         }else{
             $title = "Edit Banner Image";
             $button ="Update";
             $banner = Banner::where('id',$id)->first();
             $bannerdata= json_decode(json_encode($banner),true);
             $banner = Banner::find($id);
             $message = "Banner Image has been updated sucessfully!";
         }
         if($request->isMethod('post')) {
           $data = $request->all();
             //dd($data);
           //echo "<pre>"; print_r($data); die;
             if(empty($data['image']))
             {
                 $data['image'] = "";
             }
             if(empty($data['link']))
             {
                 $data['link'] = "";
             }
             if(empty($data['title']))
             {
                 $data['title'] = "";
             }
             if(empty($data['alt']))
             {
                 $data['alt'] = "";
             }
        
             if(!empty($data['image'])){
              $image_tmp = $data['image'];
              // dd($image_tmp);
              if($image_tmp->isValid())
              {
                  // get extension
                  $extension = $image_tmp->getClientOriginalExtension();
                  // generate new image name
                  $imageName = rand(111,99999).'.'.$extension;
                  $imagePath = 'images/banner_images/'.$imageName;
                  $result = Image::make($image_tmp)->save($imagePath);
                  // dd($result);
                  $banner->image =$imagePath;
  
              }
          }

             $banner->link = $data['link'];
             $banner->title = $data['title'];
             $banner->alt = $data['alt'];
             $banner->save();
             Session::flash('success_message',$message);
             return redirect('admin/banners');
         }
         return view('admin.banners.add_edit_banner', compact('title','button','bannerdata'));
     }

     public function updateBannerStatus(Request $request){
      if($request->ajax()){
          $data = $request->all();
          //echo "<pre>"; print_r($data); die;
          if($data['status']=="Active"){
              $status = 0;
          }else{
              $status = 1;
          }
          Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
          return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
      }
  }

     public function deleteBanner($id)
     {
      //Get Banner Image
        $bannerImage = Banner::where('id',$id)->first();

        //Get Banner Image Path
        $banner_image_path = "images/banner_images/";

        //Delete Bannner Image if exists in banners folder
        if(file_exists($banner_image_path.$bannerImage->image)){
          unlink($banner_image_path.$bannerImage->image);
        }

        //Delete Banner from banners table
        Banner::where('id',$id)->delete();

        Session::flash('success_message','Banner Image has been deleted successfully!');
        return redirect()->back();
     }
}
