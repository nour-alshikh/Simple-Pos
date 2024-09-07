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
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Product</li>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">
                        <h3 class="col-md-4 d-inline card-title">@lang('site.products')<small>{{ $products->total()
                                }}</small>
                        </h3>
                        <div class="d-flex justify-content-around col-md-6">
                            <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                                @csrf
                                <div class="d-flex">

                                    <div class="form-group d-flex flex-column">
                                        <input type="text" name="search" class="form-control"
                                            value="{{ request()->search }}" placeholder="@lang('site.search')" />
                                    </div>


                                    <div class="form-group">
                                        <select class="form-select" name="category_id" id="">
                                            <option value="" selected>All Categories</option>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ request()->category_id ==
                                                $category->id ? "selected" : "" }}>{{ $category->name }}</option>

                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <button class="btn mx-2 btn-primary" type="submit">@lang('site.search')</button>
                            </form>
                            <div class="col-md-6">
                                @if (auth()->user()->hasPermission(['products_create']))
                                <a class="btn btn-primary" href="{{ route('products.create') }}">@lang('site.add')</a>
                                @else
                                <a class="btn btn-primary disabled">@lang('site.add')</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table  table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.image')</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.description')</th>
                                    <th>@lang('site.category')</th>
                                    <th>@lang('site.purchase_price')</th>
                                    <th>@lang('site.sell_price')</th>
                                    <th>@lang('site.profit')</th>
                                    <th>@lang('site.profit_percentage')</th>
                                    <th>@lang('site.stock')</th>

                                    <th>@lang('site.Action')</th>

                                </tr>
                            </thead>
                            <tbody>

                                @php
                                $i = 0;
                                @endphp
                                @if ($products->count() > 0)
                                @foreach ($products as $product)
                                @php
                                $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td style="width: 220px">
                                        <div style="width: 200px">
                                            <img src="{{ $product->image_path }}" class="img-thumbnail"
                                                style="width: 100%" alt="{{ $product->name }}">
                                        </div>
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->purchase_price }}</td>
                                    <td>{{ $product->sell_price }}</td>
                                    <td>{{ $product->profit }}</td>
                                    <td>% {{ $product->profit_percentage }} </td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if (auth()->user()->hasPermission(['products_update']))
                                        <a class="btn btn-info" href="{{ route('products.edit', $product->id) }}">
                                            @lang('site.edit')</a>
                                        @else
                                        <a class="btn btn-info disabled">
                                            @lang('site.edit')</a>
                                        @endif
                                        @if (auth()->user()->hasPermission(['products_delete']))
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">@lang('site.delete')</button>
                                        </form>
                                        @else
                                        <button type="submit"
                                            class="btn btn-danger disabled">@lang('site.delete')</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                @endif


                            </tbody>
                        </table>
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
@endsection
