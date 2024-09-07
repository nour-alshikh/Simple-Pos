@extends('layouts.dashboard')
@section('page_header')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.products')</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item "><a href="{{ route('dashboard') }}">@lang('site.dashboard')</a></li>
                    <li class="breadcrumb-item "><a href="{{ route('products.index') }}">@lang('site.products')</a>
                    </li>
                    <li class="breadcrumb-item active">Add Product</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('site.products')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('layouts.partials._errors')
                        <div class="card-body">

                            <div class="form-group d-flex flex-column">
                                <label for="category">@lang('site.category')</label>
                                <select class="form-select" name="category_id" id="">
                                    <option value="" selected disabled>All Categories</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id')==$category->id ?
                                        "selected" :"" }}>{{ $category->name }}</option>

                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="name">@lang('site.name')</label>
                                <input type="text" class="form-control" autofocus name="name" id="name"
                                    placeholder="Enter Name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="description">@lang('site.description')</label>
                                <textarea class="form-control p-2" autofocus name="description" id="description"
                                    placeholder="Enter Name">
                                {{ old('description') }}
                                </textarea>
                            </div>


                            <div class="form-group">
                                <label for="image">@lang('site.image')</label>
                                <input type="file" class="form-control image" name="image" id="image">
                            </div>

                            <div class="form-group">
                                <img src="{{ asset('uploads/product_images/default.png') }}" style="width:100px"
                                    class="img-thumbnail image-preview" alt="">
                            </div>

                            <div class="form-group">
                                <label for="purchase_price">@lang('site.purchase_price')</label>
                                <input min="1" type="number" class="form-control " step="0.01" name="purchase_price"
                                    value="{{ old('purchase_price') }}" id="purchase_price">
                            </div>
                            <div class="form-group">
                                <label for="sell_price">@lang('site.sell_price')</label>
                                <input min="1" type="number" class="form-control" step="0.01"
                                    value="{{ old('sell_price') }}" name="sell_price" id="sell_price">
                            </div>
                            <div class="form-group">
                                <label for="stock">@lang('site.stock')</label>
                                <input min="1" type="number" class="form-control " value="{{ old('stock') }}"
                                    name="stock" id="stock">
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('site.add')</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->


                <!-- /.card -->

            </div>
        </div>
    </div>
</section>
@endsection
