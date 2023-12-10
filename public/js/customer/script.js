$(document).ready(function () {

    const sidebar = $(".sidebar");
    const openSidebarBtn = $("#open-sidebar");
    const citySelect = $("#city-select");
    const saveCityBtn = $("#save-city");
    const cityMessage = $("#city-message");
    const closeBtn = $("#close-btn");

    // SIDEBAR
    openSidebarBtn.on("click", function () {
        sidebar.css({
            "display": "block",
            "left": "0"
        });
    });

    if (localStorage.getItem("city") != null && localStorage.getItem("city") !== "") {
        citySelect.val(localStorage.getItem("city"));
        openSidebarBtn.text(localStorage.getItem("city") || "Select City");
    }

    if (localStorage.getItem("city") == null || localStorage.getItem("city") === "") {
        sidebar.css({
            "left": "0",
            "display": "block"
        });
    }

    closeBtn.on('click', function () {
        if (localStorage.getItem("city") == null || citySelect.val() === "") {
            sidebar.css({
                "left": "0",
                "display": "block"
            });
            cityMessage.css("display", "block");
        } else {
            sidebar.css({
                "left": "-20vw",
                "display": "none"
            });
        }
    });

    citySelect.on('change', function () {
        localStorage.setItem("city", citySelect.val());
        cityMessage.css("display", "none");
        openSidebarBtn.text(localStorage.getItem("city") || "Select City");
        fetchRestaurants();
        let citySpan = $('#city-name').html(localStorage.getItem("city"));
        localStorage.removeItem('cart');
    });

    openSidebarBtn.text(localStorage.getItem("city") || "Select City");
    let citySpan = $('#city-name').html(localStorage.getItem("city"));

    function fetchRestaurants() {
        let city = localStorage.getItem("city").toLowerCase();
        $.ajax({
            method: 'GET',
            url: '/api/restaurants/' + city,
            dataType: 'json',
            success: function (data) {
                let row = $('#row');
                row.html('');
                data.forEach(function (restaurant) {
                    let col = $('<div class="col-lg-3 col-md-6"></div>');
                    col.html(
                        '<div class="card">' +
                        '<img src="https://img.freepik.com/premium-vector/restaurant-building-city-background-street_165488-4443.jpg" class="card-img-top" alt="...">' +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' + restaurant.name + '</h5>' +
                        '</div>' +
                        '</div>');
                    row.append(col);
                });
            },
            error: function (err) {
                console.log(err);
            }
        });
        addEventToCards();
    }

    fetchRestaurants();

    function addEventToCards() {
        $('#row').on('click', '.card', function () {
            window.location.href = "restaurant/" + $(this).find(".card-title").text();
        });
    }

});
