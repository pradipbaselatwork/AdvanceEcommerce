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
              <li class="breadcrumb-item active">Products Attributes</li>
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
        {{-- <form name="productForm"  id="productForm" @if(empty($productdata['id'])) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$productdata['id']) }}" @endif method="post" enctype="multipart/form-data"> --}}
          <form id="AddAttributeForm" name="AddAttributeForm" method="post" action="{{route('add.attributes',$productdata['id'])}}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $productdata['id'] }}">
          <div class="card-body">
            <div class="row">

    <div class="col-md-6">
    <div class="form-group">
        <label for="product_name">Product Name:</label>&nbsp;{{ $productdata->product_name }}
        </div>

    <div class="form-group">
    <label for="product_code">Product Code</label>&nbsp;{{ $productdata->product_code }}
    </div>

    <div class="form-group">
        <label for="product_color">Product Color</label>&nbsp;{{ $productdata->product_color }}
        </div>
   </div>

        <div class="col-md-6">
                    <div class="form-group">  
                    @if(!empty($productdata['main_image']))
                      <img src="{{ asset('images/product_images/small/'.$productdata['main_image']) }}" width="120" height="120" alt="" srcset="">
                    @endif
                  </div>
                 </div>

                 
        <div class="col-md-6">
            <div class="form-group">  
                <div class="field_wrapper">
                    <div>
                        <input id="size" name="size[]" type="text" name="size[]" value="" placeholder="Size" style="width: 120px;" required=""/>
                        <input id="sku" name="sku[]" type="text" name="sku[]" value="" placeholder="Sku" style="width: 120px;" required=""/>
                        <input id="price" name="price[]" type="number" name="price[]" value="" placeholder="Price" style="width: 120px;" required=""/>
                        <input id="stock" name="stock[]" type="number" name="stock[]" value="" placeholder="Stock" style="width: 120px;" required=""/>
                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                    </div>
                </div>
          </div>
         </div>
 
          <div class="card-footer col-md-12">
           <button type="submit" class="btn btn-primary">Add Attributes</button>
          </div>
        </form>

     

      </div>

      <form id="EditAttributeForm" name="EditAttributeForm" method="post" action="{{route('edit.attributes',$productdata['id'])}}">
@csrf
   {{-- i added here --}}
   <div class="card">
    <div class="card-header">
      <h3 class="card-title">Added Product Attributes</h3>
    
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="banner" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>ID</th>
          <th>Size</th>
          <th>SKU</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
          @foreach($productdata['attributes'] as $attribute)
          <input style="display:none;" type="text" name="attrId[]" value="{{ $attribute['id'] }}">
          <tr>
            <td>{{ $attribute['id'] }}</td>
            <td>{{ $attribute['size'] }}</td>
            <td>{{ $attribute['sku'] }}</td>
            <td>
              <input type="number" name="price[]" value="{{ $attribute['price'] }}" required="">
            </td>
            <td>
              <input type="number" name="stock[]" value="{{ $attribute['stock'] }}" required="">
            </td>

            <td>
              @if($attribute['status']==1)
              <a class="updateAttributeStatus" id="attribute-{{ $attribute['id']}}" attribute_id="{{ $attribute['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
              @else 
              <a class="updateAttributeStatus" id="attribute-{{ $attribute['id']}}" attribute_id="{{ $attribute['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
              @endif
                &nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;
              <a title="Delete Attributes" href="javascript:" class="delete_form" record="attribute"  rel="{{$attribute['id']}}" style="display:inline;">
                <i class="fa fa-trash fa-" aria-hidden="true" ></i>
              </a>
              {{-- <a href="javascript:void(0)" onclick="deleteData(this.getAttribute('rel'), this.getAttribute('record'))"  record="attribute"  rel="{{$attribute->id}}" >
                <i class="fa fa-trash fa-" aria-hidden="true" ></i>
              </a> --}}
            </td>
          </tr>
          @endforeach
        </tbody>
        {{-- <tfoot>
        </tfoot> --}}
      </table>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Update Attributes</button>
     </div>
    <!-- /.card-body -->
  </div>
      </form>
    </div>
  </section>

</div>
@endsection