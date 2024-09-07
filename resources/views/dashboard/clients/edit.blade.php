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
                    <li class="breadcrumb-item "><a href="{{ route('clients.index') }}">@lang('site.clients')</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Client</li>
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
                        <h3 class="card-title">@lang('site.clients')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('clients.update' , $client->id) }}">
                        @csrf
                        @method("PUT")
                        @include('layouts.partials._errors')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">@lang('site.name')</label>
                                <input type="text" class="form-control" autofocus name="name" id="name"
                                    placeholder="Enter Name" value="{{ $client->name }}">
                            </div>

                            @for ($i=0 ; $i <2 ; $i++) <div class="form-group">
                                <label for="phone">@lang("site.phone" . $i+1)</label>
                                <input type="text" class="form-control" name="phone[]" placeholder="Enter Name"
                                    value="{{$client->phone[$i] }}">
                        </div>
                        @endfor




                        <div class="form-group">
                            <label for="address">@lang('site.address')</label>
                            <textarea class="form-control" autofocus name="address" id="address"
                                placeholder="Enter Name">{{$client->address }}</textarea>
                        </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">@lang('site.edit')</button>
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
