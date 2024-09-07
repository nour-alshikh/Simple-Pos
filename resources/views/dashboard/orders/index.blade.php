@extends('layouts.dashboard')
@section('page_header')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.orders')</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Categories</li>
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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">
                        <h3 class="col-md-4 d-inline card-title">@lang('site.orders')<small>{{ $orders->total()
                                }}</small>
                        </h3>
                        <div class="d-flex justify-content-around col-md-6">
                            <form action="{{ route('orders.index') }}" method="GET" class="d-flex">
                                @csrf
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                    placeholder="@lang('site.search')" />
                                <button class="btn mx-2 btn-primary" type="submit">@lang('site.search')</button>
                            </form>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table  table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.total_price')</th>
                                    <th>@lang('site.products_count')</th>
                                    <th>@lang('site.created_at')</th>

                                    <th>@lang('site.Action')</th>

                                </tr>
                            </thead>
                            <tbody>

                                @php
                                $i = 0;
                                @endphp
                                @if ($orders->count() > 0)
                                @foreach ($orders as $order)
                                @php
                                $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $order->client->name }}</td>
                                    <td>{{ $order->total_price }}</td>
                                    <td>{{ $order->products->count() }}</td>
                                    <td>{{ $order->created_at->toFormattedDateString() }}</td>
                                    {{-- <td>{{ $order->created_at->diffForHumans() }}</td> --}}

                                    <td>
                                        <a class="btn btn-warning order-products"
                                            data-url="{{ route('orders.get-products', $order->id) }}">
                                            @lang('site.show')</a>


                                        @if (auth()->user()->hasPermission(['orders_update']))
                                        <a class="btn btn-info"
                                            href="{{ route('orders.edit' , ['client' => $order->client->id, 'order' => $order->id]) }}">
                                            @lang('site.edit')</a>
                                        @else
                                        <a class="btn btn-info disabled">
                                            @lang('site.edit')</a>
                                        @endif

                                        @if (auth()->user()->hasPermission(['orders_delete']))
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
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
                        {{ $orders->appends(request()->query())->links() }}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">
                        <h3 class="col-md-4 d-inline card-title">
                        </h3>

                    </div>
                    <!-- /.card-header -->
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div id="loading" class="text-danger text-center" style="display: none">
                            LOADING...
                        </div>
                        <div id="order-products-list">

                        </div>
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
