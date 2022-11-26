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
              <li class="breadcrumb-item active">Edit Brand</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    {{-- validation messages --}}
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
        {{-- <form name="brandForm"  id="brandForm" @if(empty($branddata['id'])) action="{{ url('admin/add-edit-brand') }}" @else action="{{ url('admin/add-edit-brand/'.$branddata['id']) }}" @endif method="post" enctype="multipart/form-data"> --}}
          <form
          @if(!empty($branddata['id'])) action="{{route('add.edit.brand',$branddata['id'])}}" @else action="{{route('add.edit.brand')}}" @endif
          method="post" enctype="multipart/form-data">
        @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Brand Name</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Enter Brand Name"
                      @if(!empty($branddata['name']))
                      value= "{{$branddata['name']}}"
                      @else value="{{old('name')}}"
                      @endif>
                    </div>
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