@extends('layouts.dashboard')
@section('page_header')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('site.categories')</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item "><a href="{{ route('dashboard') }}">@lang('site.dashboard')</a></li>
                    <li class="breadcrumb-item "><a href="{{ route('categories.index') }}">@lang('site.categories')</a>
                    </li>
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
                        <h3 class="card-title">@lang('site.categories')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('categories.update', $category->id) }}">
                        @csrf
                        @method('PUT')
                        @include('layouts.partials._errors')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">@lang('site.name')</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Enter First Name" value="{{ $category->name }}">
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