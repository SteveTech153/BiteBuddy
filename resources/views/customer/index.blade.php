<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BiteBuddy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="{{ asset('css/customer/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer/login-register.css') }}">
    <script defer src="{{ asset('js/customer/script.js') }}"></script>
    <script defer src="{{ asset('js/customer/login-register.js') }}"></script>
    @vite([ 'resources/js/app.js'])
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

<section class="border border-5 border-white" style="padding: 7em 0 7em 0;" >
    <div class="content d-flex flex-column align-items-center justify-content-between" style="height: 6em;">
        <h4>Get the best foods and deals</h4>
        <form class="d-flex col-8" role="search">
            <input class="form-control me-2" type="search" placeholder="Search for restaurants or dishes" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
</section>

<!-- <section class="p-5" style="width: 80%; margin-left: auto; margin-right: auto;">
  <h5 class="mb-5">Recent Orders</h5>
  <div class="recent-orders">
      <div class="row">
          <div class="col-lg-4 col-sm-6">
            <div class="card my-4">
              <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                  <ul class="list-group list-group-flush">
                      <li class="list-group-item">An item</li>
                      <li class="list-group-item">A second item</li>
                      <li class="list-group-item">A third item</li>
                  </ul>
                </div>
            </div>
          </div>
          <div class="col-lg-4 col-sm-6">
            <div class="card my-4">
              <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                  <ul class="list-group list-group-flush">
                      <li class="list-group-item">An item</li>
                      <li class="list-group-item">A second item</li>
                      <li class="list-group-item">A third item</li>
                  </ul>
                </div>
            </div>
          </div>

        </div>
  </div>
</section> -->



<section class="p-5" style="width: 80%; margin-left: auto; margin-right: auto;">
    <h5 class="mb-5">Available restaurants in <span id="city-name"></span></h5>

    <div class="row" id="row">
{{--        <div class="col-lg-3 col-md-6">--}}
{{--            <div class="card" id="card-1">--}}
{{--                <img src="https://content.jdmagicbox.com/comp/chennai/h7/044pxx44.xx44.130405113636.n2h7/catalogue/a2b-adyar-ananda-bhavan-pondy-bazaar-thyagaraya-nagar-chennai-north-indian-restaurants-sctq6sk8ye.jpg" class="card-img-top" alt="...">--}}
{{--                <div class="card-body">--}}
{{--                    <h5 class="card-title">RS Puram A2b</h5>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-3 col-md-6">--}}
{{--            <div class="card" >--}}
{{--                <img src="https://content.jdmagicbox.com/comp/chennai/h7/044pxx44.xx44.130405113636.n2h7/catalogue/a2b-adyar-ananda-bhavan-pondy-bazaar-thyagaraya-nagar-chennai-north-indian-restaurants-sctq6sk8ye.jpg" class="card-img-top" alt="...">--}}
{{--                <div class="card-body">--}}
{{--                    <h5 class="card-title">Card title</h5>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-3 col-md-6">--}}
{{--            <div class="card" >--}}
{{--                <img src="https://content.jdmagicbox.com/comp/chennai/h7/044pxx44.xx44.130405113636.n2h7/catalogue/a2b-adyar-ananda-bhavan-pondy-bazaar-thyagaraya-nagar-chennai-north-indian-restaurants-sctq6sk8ye.jpg" class="card-img-top" alt="...">--}}
{{--                <div class="card-body">--}}
{{--                    <h5 class="card-title">Card title</h5>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-3 col-md-6">--}}
{{--            <div class="card" >--}}
{{--                <img src="https://content.jdmagicbox.com/comp/chennai/h7/044pxx44.xx44.130405113636.n2h7/catalogue/a2b-adyar-ananda-bhavan-pondy-bazaar-thyagaraya-nagar-chennai-north-indian-restaurants-sctq6sk8ye.jpg" class="card-img-top" alt="...">--}}
{{--                <div class="card-body">--}}
{{--                    <h5 class="card-title">Card title</h5>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</section>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</html>