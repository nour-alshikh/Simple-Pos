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
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Clients</li>
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
                        <h3 class="col-md-4 d-inline card-title">@lang('site.clients')<small>{{ $clients->total()
                                }}</small>
                        </h3>
                        <div class="d-flex justify-content-around col-md-6">
                            <form action="{{ route('clients.index') }}" method="GET" class="d-flex">
                                @csrf
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                    placeholder="@lang('site.search')" />
                                <button class="btn mx-2 btn-primary" type="submit">@lang('site.search')</button>
                            </form>
                            <div class="col-md-6">
                                @if (auth()->user()->hasPermission(['clients_create']))
                                <a class="btn btn-primary" href="{{ route('clients.create') }}">@lang('site.add')</a>
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
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.phone')</th>
                                    <th>@lang('site.address')</th>
                                    <th>@lang('site.orders')</th>

                                    <th>@lang('site.Action')</th>

                                </tr>
                            </thead>
                            <tbody>

                                @php
                                $i = 0;
                                @endphp
                                @if ($clients->count() > 0)
                                @foreach ($clients as $client)
                                @php
                                $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>
                                        {{-- @foreach ($client->phone as $phone_num)
                                        <p class="mb-0">

                                            {{ $phone_num }}
                                        </p>
                                        @endforeach --}}
                                        {{ is_array($client->phone) ? implode(' - ' ,array_filter( $client->phone)):
                                        $client->phone }}

                                    </td>
                                    <td>{{ $client->address}}</td>
                                    <td>
                                        @if (auth()->user()->hasPermission(['orders_create']))
                                        <a href="{{ route('orders.create', $client->id) }}" class="btn btn-success">
                                            add order</a>
                                        @else
                                        <a href="#" disabled class="disabled btn btn-success">
                                            add order</a>
                                        @endif
                                    </td>

                                    <td>
                                        @if (auth()->user()->hasPermission(['clients_update']))
                                        <a class="btn btn-info" href="{{ route('clients.edit', $client->id) }}">
                                            @lang('site.edit')</a>
                                        @else
                                        <a class="btn btn-info disabled">
                                            @lang('site.edit')</a>
                                        @endif
                                        @if (auth()->user()->hasPermission(['clients_delete']))
                                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST"
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
                        {{ $clients->appends(request()->query())->links() }}
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
