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
              <li class="breadcrumb-item active">Categories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if(Session::has('success_message'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
        {{ Session::get('success_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    @if(Session::has('error_message'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
        {{ Session::get('error_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
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
        {{-- <form name="categoryForm"  id="CategoryForm" @if(empty($categorydata['id'])) action="{{ url('admin/add-edit-category') }}" @else action="{{ url('admin/add-edit-category/'.$categorydata['id']) }}" @endif method="post" enctype="multipart/form-data"> --}}
          <form
          @if(!empty($categorydata['id'])) action="{{route('add.edit.category',$categorydata['id'])}}" @else action="{{route('add.edit.category')}}" @endif
          method="post" enctype="multipart/form-data">
        @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="category_name">Category Name</label>
                    <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category Name" @if(!empty($categorydata['category_name']))
                    value= "{{$categorydata['category_name']}}"
                    @else value="{{old('category_name')}}"
                    @endif>
                  </div>

                  <div id="appendCategoriesLevel">
                    @include('admin.categories.append_categories_level')
                  </div>
                </div>
                 <div class="col-md-6">
                  <div class="form-group">
                    <label for="section_id">Select Section</label>
                    <select name="section_id" id="section_id" class="form-control select" style="width: 100%;">
                        <option value="" >Select</option>
                        @foreach($getSections as $section)
                        <option value="{{ $section->id }}" @if(!empty($categorydata['section_id']) &&
                          $categorydata['section_id'] ==$section->id) selected @endif>{{ $section->name }}</option>  
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="category_image">Category Image</label>
                    <input type="file" class="form-control" id="category_image" name="category_image" @if(!empty($categorydata['category_image']))
                  value= "{{$categorydata['category_image']}}"
                  @else value="{{old('category_image')}}"
                  @endif><br> <div>Recommended Image Size:Width:1040px,Height:1200px)</div>
                  @if(!empty($categorydata['category_image']))
                    <img src="{{ asset($categorydata['category_image']) }}" width="100" height="100" alt="" srcset="">
                   <a href="{{ route('delete.category.image',$categorydata['id']) }}" class="confirmDelete" href="javascript:void(0)" record="category-image" recordid="{{ $categorydata['id'] }}">Delete Image</a> 
                    {{-- <a href="{{ url('admin/delete-category-image/'.$categorydata['id']) }}">Delete Image</a> --}}
                  @endif
                 
                </div>

                 </div>
            

    
                 <div class="col-12 col-sm-6" >
            <div class="form-group">
              <label for="category_discount">Category Discount</label>
                <input type="text" class="form-control" name="category_discount" id="category_discount" placeholder="Enter Category Discount" @if(!empty($categorydata['category_discount']))
                value= "{{$categorydata['category_discount']}}"
                @else value="{{old('category_discount')}}"
                @endif>
              </div> 

              <div class="form-group">
                <label for="description">Category Description</label>
                <textarea name="description" id="description" cols="20" class="form-control" rows="4"> @if(!empty($categorydata['description']))
                  {{$categorydata['description']}}
                  @else {{old('description')}}
                  @endif</textarea>
                  </div>
                </div>

                
                <div class="col-12 col-sm-6" >
                <div class="form-group">
                  <label for="url">Category URL</label>
                    <input type="text" class="form-control" name="url" id="url" placeholder="Enter Url" @if(!empty($categorydata['url']))
                    value= "{{$categorydata['url']}}"
                    @else value="{{old('url')}}"
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <textarea name="meta_title" id="meta_title" cols="20" class="form-control" rows="4"> @if(!empty($categorydata['meta_title']))
                      {{$categorydata['meta_title']}}
                      @else {{old('meta_title')}}
                      @endif</textarea>
              </div>
           </div>

           <div class="col-12 col-sm-6" >
              <div class="form-group">
                <label for="meta_description">Meta description</label>
                <textarea name="meta_description" id="meta_description" cols="20" class="form-control" rows="4"> @if(!empty($categorydata['meta_description']))
                  {{$categorydata['meta_description']}}
                  @else {{old('meta_description')}}
                  @endif</textarea>
          </div></div>

          <div class="col-12 col-sm-6" >
            <div class="form-group">
              <label for="meta_keywords">Meta Keywords</label>
              <textarea name="meta_keywords" id="meta_keywords" cols="20" class="form-control" rows="4"> @if(!empty($categorydata['meta_keywords']))
                {{$categorydata['meta_keywords']}}
                @else {{old('meta_keywords')}}
                @endif</textarea>
        </div>
        
        
      </div> 
      </div>
        
          <div class="card-footer">
           <button type="submit" class="btn btn-primary">{{$button}}</button>
          </div>
        </form>
      </div>
    </div>
  </section>

</div>
@endsection