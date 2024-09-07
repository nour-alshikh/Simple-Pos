@extends('layouts.dashboard')
@section('page_header')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.users')</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item "><a href="{{ route('dashboard') }}">@lang('site.dashboard')</a></li>
                    <li class="breadcrumb-item "><a href="{{ route('users.index') }}">@lang('site.users')</a></li>
                    <li class="breadcrumb-item active">Edit User</li>
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
                        <h3 class="card-title">@lang('site.users')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('layouts.partials._errors')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="first_name">@lang('site.first_name')</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    placeholder="Enter First Name" value="{{ $user->first_name }}">
                            </div>
                            <div class="form-group">
                                <label for="last_name">@lang('site.last_name')</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    placeholder="Enter Last Name" value="{{ $user->last_name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">@lang('site.email')</label>
                                <input type="text" class="form-control" name="email" id="email"
                                    placeholder="Enter Email" value="{{ $user->email }}">
                            </div>

                            <div class="form-group">
                                <label for="image">@lang('site.image')</label>
                                <input type="file" class="form-control image" name="image" id="image">
                            </div>

                            <div class="form-group">
                                <img src="{{ $user->image_path }}" style="width:100px"
                                    class="img-thumbnail image-preview" alt="">
                            </div>

                            <div class="form-group">
                                <label for="permissions">@lang('site.permissions')</label>
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Custom Tabs -->
                                        <div class="card">
                                            <div class="card-header d-flex p-0">
                                                <ul class="nav nav-pills ml-auto p-2">

                                                    @php
                                                    $models = ['users', 'categories', 'products', 'clients' ,
                                                    'orders'];
                                                    $maps = ['create', 'read', 'update', 'delete'];
                                                    @endphp

                                                    @foreach ($models as $index => $model)
                                                    <li class="nav-item"><a
                                                            class="nav-link {{ $index == 0 ? 'active' : '' }}"
                                                            href="#{{ $model }}" data-toggle="tab">@lang('site.' .
                                                            $model)</a></li>
                                                    @endforeach
                                                </ul>
                                            </div><!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="tab-content">

                                                    @foreach ($models as $index => $model)
                                                    <div class="tab-pane {{ $index == 0 ? 'active' : '' }}"
                                                        id="{{ $model }}">

                                                        @foreach ($maps as $map)
                                                        <div class="form-check">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $model . '_' . $map }}"
                                                                class="form-check-input" {{ $user->hasPermission($model
                                                            . '_' . $map) ? 'checked' : '' }}
                                                            id="{{ $map }}">
                                                            <label class="form-check-label"
                                                                for="{{ $map }}">@lang('site.' . $map . '_' .
                                                                $model)</label>
                                                        </div>
                                                        @endforeach

                                                    </div>
                                                    @endforeach
                                                    <!-- /.tab-pane -->

                                                </div>
                                                <!-- /.tab-content -->
                                            </div><!-- /.card-body -->
                                        </div>
                                        <!-- ./card -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('site.update')</button>
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
