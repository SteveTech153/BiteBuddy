<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <script defer src="{{ asset('js/customer/checkout.js') }}"></script>
</head>
<body>
@include('customer.header')
<div class="sidebar">
    <div id="sidebar-content">
        <a href="javascript:void(0)" id="close-btn" >&times;</a>
        <select class="form-select" id="city-select">
            <option value="">Select a city</option>
            <option value="karur">Karur</option>
            <option value="trichy">Trichy</option>
            <option value="karaikudi">Karaikudi</option>
            <!-- Add more city options here -->
        </select>
        <p id="city-message" style="display: none;">Please select a city</p>
    </div>
</div>
<section class="checkout-section col-lg-4 col-md-6">
    <!-- Add a loading spinner element -->
    <div id="loadingOverlay" class="overlay">
        <div class="spinner"></div>
    </div>

    <div id="checkout">
        <div id="restaurant-info">
            <div class="restaurant-image">
                <img id="restaurant-image" src="https://img.freepik.com/premium-vector/restaurant-building-city-background-street_165488-4443.jpg" alt="">
            </div>
            <div id="restaurant-name-and-address">
                <h5 id="restaurant-name"></h5>
                <p id="restaurant-address"></p>
            </div>
        </div>
        <div id="items">
            <div class="item">
                <div class="item-display-name"><i></i> </div>
                <input type="hidden" name="itemId" value="1">
                <div class="add-btn">
                    <div class="minus-btn">-</div><div class="qty">2</div><div class="plus-btn">+</div></div> <div class="price">$</div>
            </div>
        </div>
        <button class="btn btn-warning" id="add-more-btn">Add more items</button>
        <div id="bill">
            <h6>Bill Details</h6>
            <div id="price-list">
                <div class="price-list-item">
                    <p>Item Total</p><div id="item-total">$</div>
                </div>
                <div class="price-list-item">
                    <p>Platform fee</p><div id="platform-fee">$</div>
                </div>
            </div>
            <div id="total">
                <p>To Pay</p>
                <div id="total-price">$</div>
            </div>
            <div class="address">
                <h6>Enter Delivery Address</h6>
                <div id="address">
                    <textarea name="address" id="address-input" cols="53" rows="5" required></textarea>
                    <div id="address-error"></div>
                </div>
            </div>
            <form action= "{{ route('orders.store') }}" method="POST" id="checkout-form">
                @csrf
                <input type="hidden" name="restaurantId" id="restaurant-id-input" value="">
                <input type="hidden" name="restaurantName" id="restaurant-name-input" value="">
                <input type="hidden" name="items" id="items-input" value="">
                <input type="hidden" name="totalPrice" id="total-price-input" value="">
                <input type="hidden" name="address" id="customer-address-input" value="">
                <button class="btn btn-success" id="pay-btn" type="submit">Pay Now</button>
            </form>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>