@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Restaurant</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Restaurant</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- "Create" Button -->
    <div class="text-right mb-3">
        <a href="{{ route('restaurant.create') }}" class="btn btn-primary">Create Restaurant</a>
    </div>

    <!-- Table content -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Restaurant Owner</th>
                <th>Owner Email</th>
                <th>Name</th>
                <th>Location</th>
                <th>Area</th>
                <th>Contact Information</th>
                <th>Opening Time</th>
                <th>Closing Time</th>
                <th>Menu</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($restaurants as $restaurant)
            <tr>
                <td>{{ $restaurant->owner->name }}</td>
                <td>{{ $restaurant->owner->email }}</td>
                <td>{{ $restaurant->name }}</td>
                <td>{{ $restaurant->location }}</td>
                <td>{{ $restaurant->area }}</td>
                <td>{{ $restaurant->phone }}</td>
                <td>{{ $restaurant->opening_time }}</td>
                <td>{{ $restaurant->closing_time }}</td>
                <td>
                    <ul>
                        <a href="" class="btn">Manage Menu </a>
                    </ul>
                </td>
                <td>
                    <a href="{{route('restaurant.edit',['id' => $restaurant->id])}}" class="btn btn-primary">Edit</a>
                    <form action="{{route('restaurant.delete',['id' => $restaurant->id])}}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this restaurant?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $restaurants->links() }}
    </div>


    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection