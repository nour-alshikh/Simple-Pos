@extends('layouts.dashboard')
@section('page_header')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.clients')</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item "><a href="{{ route('dashboard') }}">@lang('site.dashboard')</a></li>
                    <li class="breadcrumb-item "><a href="{{ route('orders.index') }}">@lang('site.orders')</a>
                    </li>
                    <li class="breadcrumb-item active">update order</li>
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
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header d-flex">
                        <h3 class="card-title text-right">@lang('site.categories')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        @foreach ($categories as $category)
                        <div class="col-md-12">

                            <div id="accordion">
                                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                                <div class="card card-primary">
                                    <div class="card-header p-0">
                                        <h4 class="card-title w-100 h-100">
                                            <a data-toggle="collapse" class="w-100 h-100 d-block px-2 py-3"
                                                data-parent="#accordion"
                                                href="#{{ str_replace(' ' , '_' , $category->name) }}">
                                                {{ $category->name }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="{{ str_replace(' ' , '_' , $category->name) }}"
                                        class="panel-collapse collapse in">
                                        <div class="card-body">

                                            <table class="table  table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>@lang('site.name')</th>
                                                        <th>@lang('site.stock')</th>
                                                        <th>@lang('site.price')</th>
                                                        <th>@lang('site.action')</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($category->products as $product)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->stock }}</td>
                                                        <td>{{ number_format($product->sell_price , 2) }}</td>
                                                        <td>
                                                            <a href="#" id="product-{{ $product->id }}"
                                                                data-name="{{ $product->name }}"
                                                                data-id="{{ $product->id }}"
                                                                data-price="{{ $product->sell_price }}"
                                                                class="btn btn-sm add-product-btn {{ in_array($product->id, $order->products->pluck('id')->toArray()) ?'btn btn-default disabled'  : 'btn-success' }}">+</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                </div>

                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        @endforeach

                    </div>
                </div>
                <!-- /.card -->


                <!-- /.card -->

            </div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header d-flex">
                        <h3 class="card-title text-right">@lang('site.orders')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">

                        <form method="POST"
                            action="{{ route('orders.update', ['client' => $client->id , 'order' => $order->id]) }}">
                            @csrf

                            @method("PUT")
                            @include('layouts.partials._errors')


                            <table class="table  table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.product')</th>
                                        <th>@lang('site.quantity')</th>
                                        <th>@lang('site.unit-price')</th>
                                        <th>@lang('site.price')</th>
                                        <th>@lang('site.action')</th>


                                    </tr>
                                </thead>
                                <tbody class="order-list">
                                    @foreach ($order->products as $product)
                                    <tr>
                                        <td></td>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            <input type="number" name="products[{{ $product->id }}][quantity]"
                                                data-unit-price="{{ number_format($product->sell_price , 2) }}"
                                                class="form-control product-quantity" min="1"
                                                value="{{ $product->pivot->quantity }}" />
                                        </td>
                                        <td>{{ number_format($product->sell_price, 2) }}</td>
                                        <td class="product_price">{{ number_format($product->sell_price *
                                            $product->pivot->quantity , 2) }}
                                        </td>

                                        <td><button class="btn btn-danger remove-product-btn"
                                                data-id="{{ $product->id }}}"><i
                                                    class="fa fa-trash"></i></button></button>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <h4>
                                                total : <span class="total-price">{{ $order->total_price }}</span>
                                                <input type="hidden" name="total_price" id="total_price">
                                            </h4>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>


                            <button class="btn btn-primary d-block w-100 mt-3 disabled" id="add-order-btn">
                                update order
                            </button>
                        </form>
                    </div>

                </div>
                <!-- /.card -->


                <!-- /.card -->

                @if ($client->orders->count() > 0)
                <div class="card card-primary">
                    <div class="card-header d-flex">
                        <h3 class="card-title text-right">@lang('site.previous_orders')

                            <small>{{ $orders->total() }}</small>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">


                        @foreach ($orders as $order)
                        <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                        <div class="card card-primary">
                            <div class="card-header p-0">
                                <h4 class="card-title w-100 h-100">

                                    {{ $order->created_at->toFormattedDateString() }}

                                </h4>
                            </div>
                            <div id="{{ $order->created_at->format('d-m-Y-s') }}">
                                <div class="card-body">
                                    <ul class="list-group">

                                        @foreach ($order->products as $product)
                                        <li class="list-group-item">{{ $product->name }}</li>
                                        @endforeach
                                    </ul>

                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        @endforeach

                        {{ $orders->links() }}




                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>
@endsection
