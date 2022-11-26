<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        //Get Featured Items
        $featuredItemsCount = Product::where('is_featured','Yes')->where('status',1)->count();
        $featuredItems = Product::where('is_featured','Yes')->where('status',1)->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems,4);
                //  echo "<pre>"; print_r($featuredItemsChunk); die;

        $newProducts = Product::orderBy('id','Desc')->where('status',1)->limit(6)->get()->toArray();
        // $newProducts = json_decode(json_encode($newProducts),true);
        // echo "<pre>"; print_r($newProducts); die;

        $page_name = "index";
        return view('front.index', compact('page_name','featuredItemsChunk','featuredItemsCount','newProducts'));
    }
}
