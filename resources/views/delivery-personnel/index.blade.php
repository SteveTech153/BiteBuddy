@extends('delivery-personnel.layout')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Status</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="dropdown" style="margin-left:20px">
                <button class="btn btn-secondary dropdown-toggle" style="font-size: 24px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Offline
                </button>
                <div class="dropdown-menu" style="margin-top: 0; padding: 0;">
                    <a class="dropdown-item" style="border: none; padding: 10px 15px; color: #fff; background-color: #28A745;" id="online-btn" href="#">Online</a>
                    <a class="dropdown-item" style="border: none; padding: 10px 15px; color: #fff; background-color: #6C757D;" id="offline-btn" href="#">Offline</a>
                </div>
            </div>
        </section>

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner" style="padding: 40px 0 25px 40px;">
                                <h3>Orders <span id="order-progress" style="color:#01ff70; font-size:18px;"></span></h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{route('deliveryPersonnel.orders')}}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner" style="padding: 40px 0 25px 40px;">
                                <h3>Profile Details</h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="/users/{{Auth::user()->id}}/edit" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <script>
        $(document).ready(function () {
            $("#online-btn").click(function () {
                $("#dropdownMenuButton").text("Online");
                $("#dropdownMenuButton").css("background-color", "#28A745");
                $("order-progress").text("");
                // write ajax to url /api/delivery-personnel/mark-status
                $.ajax({
                    method: 'POST',
                    url: '/api/delivery-personnel/mark-status',
                    dataType: 'json',
                    data: {
                        user_id: '{{ Auth::user()->id }}',
                        status: 'online',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            $("#offline-btn").click(function () {
                $("#dropdownMenuButton").text("Offline");
                $("#dropdownMenuButton").css("background-color", "#6C757D");
                $("order-progress").text("");
                $.ajax({
                    method: 'POST',
                    url: '/api/delivery-personnel/mark-status',
                    dataType: 'json',
                    data: {
                        user_id: '{{ Auth::user()->id }}',
                        status: 'offline',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
            //write a function to fetch status from database and set the dropdown accordingly
            function fetchStatus(){
            $.ajax({
                method: 'GET',
                url: '/api/delivery-personnel/get-status/{{ Auth::user()->id }}',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data == 'online') {
                        $("#dropdownMenuButton").text("Online");
                        $("#dropdownMenuButton").css("background-color", "#28A745");
                        $("order-progress").text("");
                    } else if(data=='offline'){
                        $("#dropdownMenuButton").text("Offline");
                        $("#dropdownMenuButton").css("background-color", "#6C757D");
                        $("order-progress").text("");
                    }else{
                        $("#dropdownMenuButton").text("Busy");
                        $("#dropdownMenuButton").css("background-color", "#DC3545");
                        $("#dropdownMenuButton").attr("disabled", true);
                        $("#order-progress").text("(In Progress)");
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
            }
            fetchStatus();
            setInterval(fetchStatus, 60000);
        });

    </script>
@endsection