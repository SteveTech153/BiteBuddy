@extends('delivery-personnel.layout')

@section('content')
    @if(session()->has('success'))
            <div class="alert alert-success" style="margin-top: 20px;">
                {{ session()->get('success') }}
            </div>
    @endif
    <div class="content-wrapper">
        <div class="container">
            <h1 style="text-align:center">Orders</h1>
            <div id="orderList">
                <!-- Orders will be displayed here -->
                <div style="width: 70%; margin:40px 0px 20px 165px;">
                    @foreach($orders as $order)
                <div class="card mb-3" style="border: 2px solid #FFC107; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15); border-radius: 5px;">
                    <div class="card-header" style="background-color: #FFC107; color: white; font-size: 16px; font-weight: bold;">Pickup</div>
                    <div class="card-body" style="padding: 10px;">
                        <h5>Order placed at: {{$order->created_at}} </h5>
                        <h5>Hotel: {{$order->hotel->name}} </h5>
                        <p class="card-text">Hotel location: {{$order->hotel->address}} </p>
                        <p class="card-text">Total Amount: $ {{$order->total_amount}} </p>
                    </div>
                </div>
                <div class="card mb-3" style="border: 2px solid #FFC107; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15); border-radius: 5px;">
                    <div class="card-header" style="background-color: #FFC107; color: white; font-size: 16px; font-weight: bold;">Destination</div>
                    <div class="card-body" style="padding: 10px;">
                        <h5 >Customer: {{$order->customer->name}} </h5>
                        <p class="card-text">Customer location: {{$order->customer->address}} </p>
                        <button onclick="window.location.href= '/delivery-personnel/delivered/{{$order->id}}' " class="btn btn-success">Delivered</button>
                    </div>
                </div>
                    @endforeach
            </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            if ({{$orders->count()}} == 0) {
                $('#orderList').hide();
                $('h1').text('No orders');
            }
        });
    </script>
@endsection