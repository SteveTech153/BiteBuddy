@extends('restaurant-page.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0" style="text-align:center">Edit Restaurant Details</h1>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('restaurantPage.update', $restaurant->id) }}" method="POST"
                      style="margin: 20px auto 20px auto; width:50%">
                    @csrf
                    @method('PUT')
                    <!-- Restaurant Details -->
                    <div class="form-group">
                        <label for="name">Restaurant Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $restaurant->name }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="location" name="location"
                               value="{{ $restaurant->address }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Contact Information</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $restaurant->phone }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="opening_time">Opening Time</label>
                        <input type="time" class="form-control" id="opening_time" name="opening_time"
                               value="{{ $restaurant->opening_time }}" required>
                    </div>

                    <div class="form-group">
                        <label for="closing_time">Closing Time</label>
                        <input type="time" class="form-control" id="closing_time" name="closing_time"
                               value="{{ $restaurant->closing_time }}" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update Restaurant</button>
                </form>
            </div>
        </section>
    </div>
@endsection