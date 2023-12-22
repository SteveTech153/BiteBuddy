@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
{{--                <div class="col-sm-6">--}}
{{--                    <ol class="breadcrumb float-sm-right">--}}
{{--                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>--}}
{{--                        <li class="breadcrumb-item active">Users</li>--}}
{{--                    </ol>--}}
{{--                </div><!-- /.col -->--}}
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- "Create" Button -->
    <div class="text-right mb-3" style="margin-right : 30px">
        <a href="{{ route('user.create') }}" class="btn btn-primary">Add user</a>
    </div>

    <!-- Table content -->
    <table class="table table-striped table-hover" style="margin: 0px 0px 0px 30px; width:95%">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach ($user->roles as $role)
                    {{ $role->name }}
                    @if (!$loop->last)
                    ,
                    @endif
                    @endforeach
                </td>
                <td>
                    <a href="{{route('user.edit',['id' => $user->id])}}" class="btn btn-primary">Edit</a>
                    <form action="{{route('user.delete',['id' => $user->id])}}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center" style="margin-top: 20px">
        {{ $users->links('vendor.pagination.bootstrap-5') }}
    </div>



    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection