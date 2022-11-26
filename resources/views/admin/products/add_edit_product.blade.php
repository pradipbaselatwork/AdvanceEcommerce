@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    @if(Session::has('success_message'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
        {{ Session::get('success_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    {{-- @if(Session::has('error_message'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
        {{ Session::get('error_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif --}}
    @error('url')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{$message}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
      @enderror 
    <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">{{ $title}}</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
          </div>
        </div>
        {{-- <form name="productForm"  id="productForm" @if(empty($productdata['id'])) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$productdata['id']) }}" @endif method="post" enctype="multipart/form-data"> --}}
          <form
          @if(!empty($productdata['id'])) action="{{route('add.edit.product',$productdata['id'])}}" @else action="{{route('add.edit.product')}}" @endif
          method="post" enctype="multipart/form-data">
        @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="">Select Category</label>
                    <select name="category_id" id="category_id" class="form-control select" style="width: 100%;">
                        <option value="" >Select</option>
              @foreach($categories as $section)
                      <optgroup label="{{ $section['name'] }}"></optgroup>
                      @foreach($section['categories'] as $category)
                      <option value="{{ $category['id'] }}" @if(!empty(old('category_id')) && $category['id']==old('category_id')) selected=""
                       @elseif(!empty($productdata['category_id']) && $productdata['category_id']==$category['id'])
                           selected="" @endif>&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;
                        {{ $category['category_name'] }}</option>
                      @foreach($category['subcategories'] as $subcategory)
                      <option value="{{ $subcategory['id'] }}" @if(!empty(old('category_id')) && $subcategory['id']==old('category_id')) selected=""
                       @elseif(!empty($productdata['category_id']) && $productdata['category_id']==$subcategory['id'])
                           selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--
                        {{ $subcategory['category_name'] }}</option>
                      @endforeach
                      @endforeach
                @endforeach 
                    </select>
                  </div>
              
                  <div class="col-md-12">
                  <div class="form-group">
                    <label for="brand_id">Select Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control select" style="width: 100%;">
                        <option value="" >Select</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand['id'] }}" 
                        @if(!empty($productdata['brand_id']) && $productdata['brand_id']==$brand['id']) selected="" @endif>{{ $brand['name'] }}
                        </option>
                        @endforeach
                    </select>
                  </div> </div>

                  <div class="form-group">
                    <label for="product_name">Product Name</label>
                      <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter Product Name" @if(!empty($productdata['product_name']))
                      value= "{{$productdata['product_name']}}"
                      @else value="{{old('product_name')}}"
                      @endif>
                    </div>
                </div>

    <div class="col-md-6">
    <div class="form-group">
    <label for="product_code">Product Code</label>
        <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter Product Code" 
        @if(!empty($productdata['product_code']))
        value= "{{$productdata['product_code']}}"
        @else value="{{old('product_code')}}"
        @endif>
    </div>

    <div class="form-group">
        <label for="product_color">Product Color</label>
            <input type="text" class="form-control" name="product_color" id="product_color" placeholder="Enter Product Color"
            @if(!empty($productdata['product_color']))
            value= "{{$productdata['product_color']}}"
            @else value="{{old('product_color')}}"
            @endif>
        </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
            <label for="product_price">Product Price</label>
                <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Enter Product Price" 
                @if(!empty($productdata['product_price']))
                value= "{{$productdata['product_price']}}"
                @else value="{{old('product_price')}}"
                @endif>
            </div>
        
            <div class="form-group">
                <label for="product_discount">Product Discount (%)</label>
                    <input type="text" class="form-control" name="product_discount" id="product_discount" placeholder="Enter Product Discount"
                    @if(!empty($productdata['product_discount']))
                    value= "{{$productdata['product_discount']}}"
                    @else value="{{old('product_discount')}}"
                    @endif>
                </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                    <label for="product_weight">Product Weight</label>
                        <input type="text" class="form-control" name="product_weight" id="product_weight" placeholder="Enter Product Weight" 
                        @if(!empty($productdata['product_weight']))
                        value= "{{$productdata['product_weight']}}"
                        @else value="{{old('product_weight')}}"
                        @endif>
                    </div>
                
                    <div class="form-group">
                      <label for="main_image">Product Main Image</label>
                      <input type="file" class="form-control" id="main_image" name="main_image" @if(!empty($productdata['main_image']))
                    value= "{{$productdata['main_image']}}"
                    @else value="{{old('main_image')}}"
                    @endif><br> <div>Recommended Image Size:Width:1040px,Height:1200px)</div>
                    @if(!empty($productdata['main_image']))
                      <img src="{{ asset('images/product_images/small/'.$productdata['main_image']) }}" width="100" height="100" alt="" srcset="">
                     <a href="{{ route('delete.product.image',$productdata['id']) }}" class="confirmDelete" href="javascript:void(0)" record="product-image" recordid="{{ $productdata['id'] }}">Delete Image</a> 
                      {{-- <a href="{{ url('admin/delete-category-image/'.$productdata['id']) }}">Delete Image</a> --}}
                    @endif
                   
                  </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="product_video">Product Video</label>
                            <input type="file" class="form-control" id="product_video" name="product_video" @if(!empty($productdata['product_video']))
                          value= "{{$productdata['product_video']}}"
                          @else value="{{old('product_video')}}"
                          @endif><br>
                          @if(!empty($productdata['product_video']))
                           <div><a href="{{ asset('videos/product_videos/'.$productdata['product_video']) }}" download>Download</a>
                            |<a  href="{{ route('delete.product.video',$productdata['id']) }}" class="confirmDelete" href="javascript:void(0)" record="product-video" recordid="{{ $productdata['id'] }}">Delete Video</a> 
                          </div>
                        
                            {{-- <a href="{{ url('admin/delete-category-image/'.$productdata['id']) }}">Delete Image</a> --}}
                          @endif
                        </div>

                            <div class="form-group">
                                <label for="description">Product Description</label>
                                <textarea name="description" id="description" cols="20" class="form-control" rows="4"> @if(!empty($productdata['description']))
                                  {{$productdata['description']}}
                                  @else {{old('description')}}
                                  @endif</textarea>
                                  </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="wash_care">Wash Care</label>
                                        <textarea name="wash_care" id="wash_care" cols="20" class="form-control" rows="4">
                                             @if(!empty($productdata['wash_care']))
                                          {{$productdata['wash_care']}}
                                          @else {{old('wash_care')}}
                                          @endif</textarea>
                                          </div>

                                          <div class="form-group">
                                            <label for="fabric">Select Fabric</label>
                                            <select name="fabric" id="fabric" class="form-control select" style="width: 100%;">
                                                <option value="" >Select</option>
                                                @foreach($fabricArray as $fabric)
                                                <option value="{{ $fabric }}" 
                                                @if(!empty($productdata['fabric']) && $productdata['fabric']==$fabric) selected="" @endif>{{ $fabric }}
                                                </option>
                                                @endforeach
                                            </select>
                                          </div>
                                          </div>

                                          <div class="col-12 col-sm-6" >
                                            <div class="form-group">
                                              <label for="sleeve">Select Sleeve</label>
                                              <select name="sleeve" id="sleeve" class="form-control select" style="width: 100%;">
                                                  <option value="" >Select</option>
                                                  @foreach($sleeveArray as $sleeve)
                                                  <option value="{{ $sleeve }}"
                                                  @if(!empty($productdata['sleeve']) && $productdata['sleeve']==$sleeve) selected="" @endif>{{ $sleeve }}
                                              </option>
                                                  @endforeach
                                              </select>
                                            </div>

                                            <div class="form-group">
                                              <label for="pattern">Select Pattern</label>
                                              <select name="pattern" id="pattern" class="form-control select" style="width: 100%;">
                                                  <option value="" >Select</option>
                                                  @foreach($patternArray as $pattern)
                                                  <option value="{{ $pattern }}" 
                                                  @if(!empty($productdata['pattern']) && $productdata['pattern']==$pattern) selected="" @endif>{{ $pattern }}
                                                  </option>
                                                  @endforeach
                                              </select>
                                            </div>
                                          </div>

                                          <div class="col-12 col-sm-6" >
                                            <div class="form-group">
                                              <label for="fit">Select fit</label>
                                              <select name="fit" id="fit" class="form-control select" style="width: 100%;">
                                                  <option value="" >Select</option>
                                                  @foreach($fitArray as $fit)
                                                  <option value="{{ $fit }}"
                                                  @if(!empty($productdata['fit']) && $productdata['fit']==$fit) selected="" @endif>{{ $fit }}
                                                </option>
                                                  @endforeach
                                              </select>
                                            </div>

                                            <div class="form-group">
                                              <label for="occassion">Select Occassion</label>
                                              <select name="occassion" id="occassion" class="form-control select" style="width: 100%;">
                                                  <option value="" >Select</option>
                                                  @foreach($occassionArray as $occassion)
                                                  <option value="{{ $occassion }}"
                                                  @if(!empty($productdata['occassion']) && $productdata['occassion']==$occassion) selected="" @endif>{{ $occassion }}
                                                </option>
                                                  @endforeach
                                              </select>
                                            </div>
                                          </div>



                                          <div class="col-12 col-sm-6" >
                                       <div class="form-group">
                                        <label for="description">Product Description</label>
                                        <textarea name="description" id="description" cols="20" class="form-control" rows="4"> 
                                            @if(!empty($productdata['description']))
                                          {{$productdata['description']}}
                                          @else {{old('description')}}
                                          @endif</textarea>
                                          </div>
                                          
                                          <div class="form-group">
                                            <label for="meta_title">Meta Title</label>
                                            <textarea name="meta_title" id="meta_title" cols="20" class="form-control" rows="4"> 
                                                @if(!empty($productdata['meta_title']))
                                              {{$productdata['meta_title']}}
                                              @else {{old('meta_title')}}
                                              @endif</textarea>
                                              </div>

                                        </div>

                                        <div class="col-12 col-sm-6" >
                                          <div class="form-group">
                                           <label for="meta_description">Meta Description</label>
                                           <textarea name="meta_description" id="meta_description" cols="20" class="form-control" rows="4"> 
                                               @if(!empty($productdata['meta_description']))
                                             {{$productdata['meta_description']}}
                                             @else {{old('meta_description')}}
                                             @endif</textarea>
                                             </div>
                                             
                                             <div class="form-group">
                                               <label for="meta_keywords">Meta Keywords</label>
                                               <textarea name="meta_keywords" id="meta_keywords" cols="20" class="form-control" rows="4"> 
                                                   @if(!empty($productdata['meta_keywords']))
                                                 {{$productdata['meta_keywords']}}
                                                 @else {{old('meta_keywords')}}
                                                 @endif</textarea>
                                                 </div>
   
                                           </div>
                                           <div class="col-12 col-sm-6" >
                                            <div class="form-group">
                                              <label for="">Featured Item</label>
                                             <input type="checkbox" name="is_featured" id="is_featured" value="Yes"
                                             @if(!empty($productdata['is_featured']) && $productdata['is_featured']=="Yes") checked="" @endif>
                                                </div>
  
                                          </div>
      
 </div>        
          <div class="card-footer">
           <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </section>

</div>
@endsection