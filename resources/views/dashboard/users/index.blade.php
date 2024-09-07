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
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
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
                        <h3 class="col-md-4 d-inline card-title">@lang('site.users')<small>{{ $users->total() }}</small>
                        </h3>
                        <div class="d-flex justify-content-around col-md-6">
                            <form action="{{ route('users.index') }}" method="GET" class="d-flex">
                                @csrf
                                <input type="text" name="search" class="form-control" value="{{ request()->search }}"
                                    placeholder="@lang('site.search')" />
                                <button class="btn mx-2 btn-primary" type="submit">@lang('site.search')</button>
                            </form>
                            <div class="col-md-6">
                                @if (auth()->user()->hasPermission(['users_create']))
                                <a class="btn btn-primary" href="{{ route('users.create') }}">@lang('site.add')</a>
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
                                    <th>@lang('site.first_name')</th>
                                    <th>@lang('site.last_name')</th>
                                    <th>@lang('site.image')</th>
                                    <th>@lang('site.email')</th>
                                    <th>@lang('site.Action')</th>

                                </tr>
                            </thead>
                            @php
                            $i = 0;
                            @endphp


                            @if ($users->count() > 0)
                            <tbody>

                                @foreach ($users as $user)
                                @php
                                $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td style="width: 220px">
                                        <div style="width: 200px">
                                            <img src="{{ $user->image_path }}" class="img-thumbnail" style="width: 100%"
                                                alt="{{ $user->first_name }}">
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if (auth()->user()->hasPermission(['users_update']))
                                        <a class="btn btn-info" href="{{ route('users.edit', $user->id) }}">
                                            @lang('site.edit')</a>
                                        @else
                                        <a class="btn btn-info disabled">
                                            @lang('site.edit')</a>
                                        @endif
                                        @if (auth()->user()->hasPermission(['users_delete']))
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
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



                            </tbody>


                            @endif
                        </table>
                        {{ $users->appends(request()->query())->links() }}
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
