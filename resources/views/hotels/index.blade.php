@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Hotels</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Hotels</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- "Create" Button -->
    <div class="text-right mb-3">
        <a href="{{ route('hotel.create') }}" class="btn btn-primary">Create Hotel</a>
    </div>

    <!-- Table content -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Hotel Owner</th>
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
            @foreach ($hotels as $hotel)
            <tr>
                <td>{{ $hotel->owner->name }}</td>
                <td>{{ $hotel->owner->email }}</td>
                <td>{{ $hotel->name }}</td>
                <td>{{ $hotel->location }}</td>
                <td>{{ $hotel->area }}</td>
                <td>{{ $hotel->phone }}</td>
                <td>{{ $hotel->opening_time }}</td>
                <td>{{ $hotel->closing_time }}</td>
                <td>
                    <ul>
                        <a href="" class="btn">Manage Menu </a>
                    </ul>
                </td>
                <td>
                    <a href="{{route('hotel.edit',['id' => $hotel->id])}}" class="btn btn-primary">Edit</a>
                    <form action="{{route('hotel.delete',['id' => $hotel->id])}}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this hotel?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $hotels->links() }}
    </div>


    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection