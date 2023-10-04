@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0" style="text-align: center">Add User</h1>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Form content -->
    <!-- User creation form with role assignment -->
    <form action="{{ route('user.store') }}" method="POST" style="width: 50%;margin-top:30px;margin-left: auto;margin-right: auto;">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email Id</label>
            <input type="mail" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role">
                @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create User</button>
    </form>



    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection