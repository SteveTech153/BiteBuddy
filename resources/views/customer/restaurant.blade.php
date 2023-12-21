<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiteBuddy</title>
    <link rel="icon" href=
            "{{asset('assets/images/logo.png')}}"
          type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="{{ asset('css/customer/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/login-register.css') }}">
    <script defer src="{{ asset('js/customer/login-register.js') }}"></script>
    @vite([ 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <script defer src="{{ asset('js/customer/product.js') }}"></script>

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
<section id="items-menu">
    <h4 class="mb-5" id="restaurantName">{{$restaurant->name}}</h4>
    <input type="hidden" name="restaurantId" value="{{$restaurant->id}}">
    <input type="hidden" name="restaurantAddress" value="{{$restaurant->address}}">
{{--    <div class="item">--}}
{{--        <div class="item-details">--}}
{{--            <i class="fa-solid fa-leaf" style="color: #29ff2c;"></i>--}}
{{--            <h6 id="item-display-name">Dosa</h6>--}}
{{--            <h6>$<span id="item-price">14</span></h6>--}}
{{--            <input type="hidden" name="itemId" value="1">--}}
{{--            <p class="item-description">south indian delicacy. fav food of the year comes with chutney</p>--}}
{{--        </div>--}}
{{--        <div class="item-right">--}}
{{--            <img src="https://media-assets.swiggy.com/swiggy/image/upload/fl_lossy,f_auto,q_auto,w_208,h_208,c_fit/femmvxqpq2sy2knhgpou" alt="" class="item-image">--}}
{{--            <button class="btn btn-success additem-btn" id="add-1">Add Item</button>--}}
{{--            <div class="add-btn">--}}
{{--                <div class="minus-btn">-</div><div class="qty">1</div><div class="plus-btn">+</div></div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div id="item-container">
    @if($products->isEmpty()) <img id="no-items-img" src="https://www.kandilglass.com/images/product-not-found.jpg" >

    @else
    @foreach($products as $item)
        <div class="item">
            <div class="item-details">
                @if($item->is_vegetarian)
                    <i class="bi bi-stop-btn" style="color: #29ff2c;"></i>
                @else
                    <i class="bi bi-caret-up-square" style="color: #ff0000;"></i>
                @endif
                <h6 id="item-display-name" class="item-display-name">{{$item->name}}</h6>
                <h6>$<span id="item-price">{{$item->price}}</span></h6>
                <input type="hidden" name="itemId" value="{{$item->id}}">
                <p class="item-description">{{$item->description}}</p>
            </div>
            <div class="item-right">
                <img src="{{$item->image}}" alt="" class="item-image">
                <button class="btn btn-success additem-btn" id="add-{{$item->id}}">Add Item</button>
                <div class="add-btn">
                    <div class="minus-btn">-</div><div class="qty">1</div><div class="plus-btn">+</div></div>
            </div>
        </div>
    @endforeach
    @endif
    </div>
    <div id="new-cart-overlay">
        <div class="new-cart-confirm">
            <h6>Items already in cart</h6>
            <p>Your cart contains items from other restaurant. Would you like to reset your cart for adding items from this restaurant?</p>
            <button class="btn btn-danger" id="cancel">Cancel</button>
            <button class="btn btn-success" id="reset-cart">Reset Cart</button>
        </div>
    </div>
</section>
@if($products->isNotEmpty())
<div class="item-footer">
    <div class="item-details-footer"><span id="no-of-items">0</span> item | $<span id="total-price">0</span></div>
    <div class="view-cart-footer">VIEW CART <i class="bi bi-bag-heart-fill"></i></div>
</div>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>