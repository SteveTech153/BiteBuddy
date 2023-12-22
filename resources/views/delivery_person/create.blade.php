@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <h1 style="text-align: center" class="m-0">Add Delivery Person</h1>
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
    {{--                <div class="col-sm-6">--}}
    {{--                    <ol class="breadcrumb float-sm-right">--}}
    {{--                        <li class="breadcrumb-item"><a href="{{route('delivery_person.index')}}">Delivery Persons</a></li>--}}
    {{--                        <li class="breadcrumb-item active">Add Delivery Persons</li>--}}
    {{--                    </ol>--}}
    {{--                </div><!-- /.col -->--}}
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Form content -->
    <!-- User creation form with role assignment -->
    <form action="{{ route('delivery_person.store') }}" method="POST" style="width: 50%;margin-top:30px;margin-left: auto;margin-right: auto;">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email Id</label>
            <input type="mail" class="form-control" id="email" name="email" required>
        </div>

        <input type="hidden" name="role" value="delivery_person">

        <button type="submit" class="btn btn-primary">Create Delivery Person</button>
    </form>



    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection