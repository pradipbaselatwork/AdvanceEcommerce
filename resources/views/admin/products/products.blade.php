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
              <li class="breadcrumb-item active">Products</li>
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
              <h3 class="card-title">Products</h3>
              {{-- <a href="" style="max-width: 150px; float:right; display:inline-block;" class="btn btn-block btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Add Products</a> --}}
              {{-- <a href="{{route('admin.add.edit.product')}}" style="max-width: 150px; float:right; display:inline-block;" class="btn btn-block btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Add Product</a> --}}
              <a href="{{route('add.edit.product')}}" style="max-width: 150px; float:right; display:inline-block;" class="btn btn-block btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;Add Product</a>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="banner" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Product Name</th>
                  <th>Product Code</th>
                  <th>Product Color</th>
                  <th>Product Image</th>
                  <th>Category</th>
                  <th>Section</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($products as $product)
                  <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->product_code }}</td>
                    <td>{{ $product->product_color }}</td>
                    <td>
                      <?php
                         $product_image_path = "images/product_images/small/".$product->main_image;
                         ?>

                      @if(!empty($product->main_image) && file_exists($product_image_path))
                      <img src="{{ asset('images/product_images/small/'.$product->main_image) }}" width="100" height="110"></td>
                     @else
                     <img src="{{ asset('images/product_images/small/no-image.png'.$product->main_image) }}" width="100" height="110"></td>
                      @endif
                    {{-- <td><img src="{{asset($product->main_image)}}" alt="" width="100" height="100" srcset=""></td> --}}
                    <td>@if(!empty($product->category->category_name)){{ $product->category->category_name }} @endif</td>

                    <td>{{ $product->section->name }}</td>
                    <td>
                      @if($product->status==1)
                      <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                      @else 
                      <a class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
                      @endif
                    </td>
                    <td style="width: 100px;">
                      <a title="Add/Edit Attributes" href="{{route('add.attributes', $product->id)}}"><i class="fa fa-plus" aria-hidden="true"></i></a>&nbsp;&nbsp;
                      <a title="Add Images" href="{{route('add.images', $product->id)}}"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>&nbsp;&nbsp;
                      <a title="Edit Products" href="{{route('add.edit.product', $product->id)}}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                      {{-- <a title="Delete Products" href="javascript:" class="delete_form" record="product"  rel="{{$product->id}}" style="display:inline;">
                        <i class="fa fa-trash fa-" aria-hidden="true" ></i>
                      </a> --}}
                      <a href="javascript:" class="delete_form" record="product"  rel="{{$product->id}}" style="display:inline;">
                        <i class="fa fa-trash fa-" aria-hidden="true" ></i>
                      </a>
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

