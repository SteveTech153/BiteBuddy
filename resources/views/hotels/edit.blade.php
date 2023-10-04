@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Hotels details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('hotel.index')}}">Hotels</a></li>
                        <li class="breadcrumb-item active">Edit Hotels details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Form content -->
    <form action="{{ route('hotel.update', $hotel->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Hotel Owner Details -->
        <div class="form-group">
            <label for="owner_name">Hotel Owner Name</label>
            <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ $hotelOwner->name }}" required>
        </div>

        <div class="form-group">
            <label for="owner_email">Hotel Owner Email</label>
            <input type="email" class="form-control" id="owner_email" name="owner_email" value="{{ $hotelOwner->email }}" required>
        </div>

        <!-- Hotel Details -->
        <div class="form-group">
            <label for="name">Hotel Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $hotel->name }}" required>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $hotel->location }}" required>
        </div>
        
        <div class="form-group">
            <label for="area">Area</label>
            <input type="text" class="form-control" id="area" name="area" value="{{ $hotel->area }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Contact Information</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ $hotel->phone }}" required>
        </div>

        <div class="form-group">
            <label for="opening_time">Opening Time</label>
            <input type="time" class="form-control" id="opening_time" name="opening_time" value="{{ $hotel->opening_time }}" required>
        </div>

        <div class="form-group">
            <label for="closing_time">Closing Time</label>
            <input type="time" class="form-control" id="closing_time" name="closing_time" value="{{ $hotel->closing_time }}" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Hotel</button>
    </form>




    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection