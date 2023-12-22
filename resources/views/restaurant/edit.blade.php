@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0" style="text-align: center">Edit Restaurant details</h1>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Form content -->
    <form action="{{ route('restaurant.update', $restaurant->id) }}" method="POST" style="margin: 20px auto 20px auto; width:50%">
        @csrf
        @method('PUT')
        <!-- Restaurant Owner Details -->
        <div class="form-group">
            <label for="owner_name">Restaurant Owner Name</label>
            <input type="text" class="form-control" id="owner_name" name="owner_name" value="{{ $restaurantOwner->name }}" required>
        </div>

        <div class="form-group">
            <label for="owner_email">Restaurant Owner Email</label>
            <input type="email" class="form-control" id="owner_email" name="owner_email" value="{{ $restaurantOwner->email }}" required>
        </div>

        <!-- Restaurant Details -->
        <div class="form-group">
            <label for="name">Restaurant Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $restaurant->name }}" required>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $restaurant->location }}" required>
        </div>
        
        <div class="form-group">
            <label for="area">Area</label>
            <input type="text" class="form-control" id="area" name="area" value="{{ $restaurant->area }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Contact Information</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ $restaurant->phone }}" required>
        </div>

        <div class="form-group">
            <label for="opening_time">Opening Time</label>
            <input type="time" class="form-control" id="opening_time" name="opening_time" value="{{ $restaurant->opening_time }}" required>
        </div>

        <div class="form-group">
            <label for="closing_time">Closing Time</label>
            <input type="time" class="form-control" id="closing_time" name="closing_time" value="{{ $restaurant->closing_time }}" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update Restaurant</button>
    </form>




    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection