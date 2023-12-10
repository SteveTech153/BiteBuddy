@extends('restaurant-page.layout')

@section('content')
    <section class="content">
        <div class="container">
            <h1 style="text-align:center">Orders</h1>
            <div id="orderList" style="display: flex; flex-direction: column; align-items: center;">
                <!-- Orders will be displayed here -->
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            // Function to fetch orders and populate the order list
            function fetchOrders() {
                $.ajax({
                    method: 'GET',
                    url: '/api/orders/restaurants/{{ auth()->user()->restaurant->id }}',
                    dataType: 'json',
                    success: function (data) {
                        var orderList = $('#orderList');
                        orderList.empty(); // Clear existing content

                        $.each(data.data, function (index, order) {
                            var orderCard = $('<div style="width: 70%; margin-bottom: 20px; text-align: center;"></div>'); // Create a card
                            orderCard.html(
                                '<div class="card" style="border: 2px solid #FFC107; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15); border-radius: 5px;">' +
                                '<div class="card-header" style="background-color: #FFC107; color: white; font-size: 16px; font-weight: bold;">Order ID: ' + order.id + ' ' + order.order_time + '</div>' +
                                '<div class="card-body" style="padding: 10px;">' +
                                '<h5  style="font-size: 18px; font-weight: bold; color: #333; text-align: center;">Customer: ' + order.customer_name + '</h5>' +
                                '<p class="card-text" style="font-size: 16px; color: #777;">Status: <span style="font-weight: bold; color: #28A745;">' + order.status + '</span></p>' +
                                '<p class="card-text" style="font-size: 16px; color: #777;">Total Amount: $<span style="font-weight: bold; color: #333;">' + order.total_amount + '</span></p>' +
                                '<h6 class="card-subtitle mb-2 text-muted" style="font-size: 12px; color: #999;">Products in this Order:</h6>' +
                                '<ul class="list-group" style="margin-top: 10px;">' +
                                $.map(order.products, function (product) {
                                    return '<li class="list-group-item" style="font-size: 14px; color: #333;"><span style="font-weight: bold; color: #3c8dbc;">' + product.name + '</span> - $<span style="font-weight: bold; color: #333;">' + product.price + '</span></li>';
                                }).join('') +
                                '</ul>' +
                                '</div>' +
                                '</div>'
                            );
                            orderList.append(orderCard);
                        });
                    }
                });
            }

            // Initial fetch of orders when the page loads
            fetchOrders();
            setInterval(fetchOrders, 60000);
        });
    </script>
@endsection
