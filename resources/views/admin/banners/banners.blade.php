@extends('layouts.admin_layout.admin_layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
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

        <!-- /Session message -->
        @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
          {{ Session::get('success_message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Banner Image</h3>
              <a href="{{route('add.edit.banner')}}" style="max-width: 175px; float:right; display:inline-block;" class="btn btn-block btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Add Banner Image</a>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="banner" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Image</th>
                  <th>Link</th>
                  <th>Title</th>
                  <th>Alt</th>
                  {{-- <th>Status</th> --}}
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($banners as $banner)
                  <tr>
                    <td>{{ $banner['id'] }}</td>
                    <td><img style="width:220px; margin-top:15px; margin-bottom:5px;" src="{{ asset($banner['image']) }}" ></td>
                    <td>{{ $banner['link'] }}</td>
                    <td>{{ $banner['title'] }}</td>
                    <td>{{ $banner['alt'] }}</td>
                    {{-- <td>
                      @if($banner['status']==1)
                      <a class="updatebannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}" href="javascript:void(0)">Active</a>
                      @else 
                      <a class="updatebannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}" href="javascript:void(0)">Inactive</a>
                      @endif
                    </td> --}}
                    <td>
                      <a href="{{route('add.edit.banner', $banner['id']) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href="javascript:" class="delete_form" record="banner"  rel="{{ $banner['id'] }}" style="display:inline;">
                        <i class="fa fa-trash fa-" aria-hidden="true" ></i>
                      </a>&nbsp;&nbsp;&nbsp;

                      @if($banner['status']==1)
                      <a class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}" href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                      @else 
                      <a class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
                      @endif

                     </td>
                  </tr>
                  @endforeach
                </tbody>
                {{-- <tfoot>
                </tfoot> --}}
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection