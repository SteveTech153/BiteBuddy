@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0" style="text-align: center">Edit Details</h1>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Form content -->
   
    <form action="{{ route('delivery_person.update', $deliveryPerson->id) }}" method="POST" style="width: 50%;margin-top:30px;margin-left: auto;margin-right: auto;">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $deliveryPerson->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $deliveryPerson->email }}" required>
        </div>
        <input type="hidden" name="role" value="delivery_partner">

        <button type="submit" class="btn btn-primary">Update Details</button>
    </form>



    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection