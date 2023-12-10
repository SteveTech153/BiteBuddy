<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{--    <link rel="stylesheet" href="{{ asset('css/customer/style.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/customer/login-register.css') }}">
    <script defer src="{{ asset('js/customer/script.js') }}"></script>
    <script defer src="{{ asset('js/customer/login-register.js') }}"></script>
    @vite([ 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/customer/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/track-order.css') }}">
    <script src="{{ asset('js/customer/track-order.js') }}"></script>
</head>
<body>
@include('customer.header')
<div class="gap"></div>
<div class="card-container" id="card-container">
    <div class="card">
        <h5 class="card-header">
            <span id="restaurant-name"></span>
            <span id="status">Your Order is being prepared by the restaurant</span>
            <i class="bi bi-arrow-clockwise" id="reload-status"></i>
        </h5>
        <div class="card-body">
            <h5 class="card-title">
                Your Delivery Partner is&nbsp<span id="delivery-personnel-name"></span>
                &nbsp<i class="bi bi-person-badge"></i>
            </h5>
            <h6>Your Items</h6>
            <div id="items">
{{--                @foreach ($items as $item)--}}
{{--                    <div class="item">--}}
{{--                        <div class="item-display-name"><i></i> {{ $item['name'] }}</div>--}}
{{--                        <input type="hidden" name="itemId" value="{{ $item['itemId'] }}">--}}
{{--                        <div class="add-btn">--}}
{{--                            <div class="qty">{{ $item['quantity'] }}</div>--}}
{{--                        </div>--}}
{{--                        <div class="price">${{ $item['price'] }}</div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
            </div>
        </div>
    </div>
</div>
    <script>
        $(document).ready(function() {
            //write ajax to get-order-details and display it

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>