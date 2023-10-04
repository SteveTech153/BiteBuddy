@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Delivery Persons</h1>
                </div><!-- /.col -->
{{--                <div class="col-sm-6">--}}
{{--                    <ol class="breadcrumb float-sm-right">--}}
{{--                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>--}}
{{--                        <li class="breadcrumb-item active">Delivery Persons</li>--}}
{{--                    </ol>--}}
{{--                </div><!-- /.col -->--}}
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- "Create" Button -->
    <div class="text-right mb-3">
        <a href="{{ route('delivery_person.create') }}" class="btn btn-primary">Add delivery person</a>
    </div>

    <!-- Table content -->
    <table class="table table-striped table-hover" style="margin: 0px 0px 0px 30px; width:95%">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($deliveryPersons as $deliveryPerson)
            <tr>
                <td>{{ $deliveryPerson->name }}</td>
                <td>{{ $deliveryPerson->email }}</td>
                <td>
                    <a href="{{route('delivery_person.edit',['id' => $deliveryPerson->id])}}" class="btn btn-primary">Edit</a>
                    <form action="{{route('delivery_person.delete',['id' => $deliveryPerson->id])}}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove this delivery person?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        <div class="d-flex justify-content-center">
        {{ $deliveryPersons->links() }}
    </div>
    </table>



    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection