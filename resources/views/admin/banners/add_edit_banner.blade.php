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
              <li class="breadcrumb-item active">Banners</li>
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
        {{-- <form name="bannerForm"  id="bannerForm" @if(empty($bannerdata['id'])) action="{{ url('admin/add-edit-banner') }}" @else action="{{ url('admin/add-edit-banner/'.$bannerdata['id']) }}" @endif method="post" enctype="multipart/form-data"> --}}
          <form
          @if(!empty($bannerdata['id'])) action="{{route('add.edit.banner',$bannerdata['id'])}}" @else action="{{route('add.edit.banner')}}" @endif
          method="post" enctype="multipart/form-data">
        @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                    <label for="image">Banner Image</label>
                    <input type="file" class="form-control" id="image" name="image" @if(!empty($bannerdata['image']))
                  value= "{{$bannerdata['image']}}"
                  @else value="{{old('image')}}"
                  @endif><br> <div>Recommended Image Size:Width:1170px,Height:480px)</div>
                  @if(!empty($bannerdata['image']))
                    <img src="{{ asset($bannerdata['image']) }}" width="200" height="100" alt="" srcset="">
                   {{-- <a href="{{ route('delete.banner.image',$bannerdata['id']) }}" class="confirmDelete" href="javascript:void(0)" record="banner-image" recordid="{{ $bannerdata['id'] }}"></a>  --}}
                    {{-- <a href="{{ url('admin/delete-banner-image/'.$bannerdata['id']) }}">Delete Image</a> --}}
                  @endif
                 
                </div>

                <div class="form-group">
                  <label for="link">Banner Link</label>
                    <input type="text" class="form-control" name="link" id="link" placeholder="Enter Banner Link" @if(!empty($bannerdata['link']))
                    value= "{{$bannerdata['link']}}"
                    @else value="{{old('link')}}"
                    @endif>
                  </div>

                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Banner Title</label>
                          <input type="text" class="form-control" name="title" id="title" placeholder="Enter Banner Title" @if(!empty($bannerdata['title']))
                          value="{{$bannerdata['title']}}"
                          @else value="{{old('title')}}"
                          @endif>
                        </div>

                        <div class="form-group">
                            <label for="alt">Banner Alternate Text</label>
                              <input type="text" class="form-control" name="alt" id="alt" placeholder="Enter Alternate Text" @if(!empty($bannerdata['alt']))
                              value="{{$bannerdata['alt']}}"
                              @else value="{{old('alt')}}"
                              @endif>
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