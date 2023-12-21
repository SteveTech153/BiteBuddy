$(document).ready(function () {

    const sidebar = $(".sidebar");
    const openSidebarBtn = $("#open-sidebar");
    const citySelect = $("#city-select");
    const saveCityBtn = $("#save-city");
    const cityMessage = $("#city-message");
    const closeBtn = $("#close-btn");
    let $restaurantsJson;

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
                $restaurantsJson = data;
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

// autocomplete search
// Getting all required elements
    const searchInput = document.querySelector(".searchInput");
    const input = searchInput.querySelector("input");
    const resultBox = searchInput.querySelector(".resultBox");

    let allItems = [];  // Array to store all items fetched from the backend
    let allRestaurants = [];  // Array to store all restaurants fetched from the backend

// Function to fetch all items and restaurants in the city
//     async function fetchAllData(city) {
//         const itemsResponse = await fetch(`/api/items/${city}`);
//         const restaurantsResponse = await fetch(`/api/restaurants/${city}`);
//
//         allItems = await itemsResponse.json();
//         allRestaurants = await restaurantsResponse.json();
//     }
    async function fetchAllData(city) {
        try {
            const itemsResponse = await fetch(`/api/items/${city}`);
            const restaurantsResponse = await fetch(`/api/restaurants/${city}`);

            allItems = await itemsResponse.json();
            allRestaurants = await restaurantsResponse.json();

            console.log("Fetched items:", allItems);
            console.log("Fetched restaurants:", allRestaurants);
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }


// Function to filter items based on user input
    function filterItems(userInput) {
        // Flatten the nested array and filter items
        return allItems.flat().filter(item => item && item.name.toLowerCase().startsWith(userInput.toLowerCase()));
    }

// Function to filter restaurants based on user input
    function filterRestaurants(userInput) {
        return allRestaurants.filter(restaurant => restaurant && restaurant.name.toLowerCase().startsWith(userInput.toLowerCase()));
    }


// If the user presses any key and releases
    input.onkeyup = (e) => {
        let userData = e.target.value; // User entered data

        if (userData) {
            // Filter items based on user input
            let filteredItems = filterItems(userData);
            let itemSuggestions = filteredItems.map(item => {
                let restaurantName = getRestaurantNameById(item.restaurant_id);
                return `<li class="item" style="min-height: 5em !important" data-restaurant-id="${item.restaurant_id}" data-item-id="${item.id}">
                        <img style="height:50px; width:50px" src="${item.image}" alt="${item.name}" />
                        <span>${item.name}</span>
                        <span>${item.price}</span>
                        <span>by ${restaurantName}</span>
                    </li>`;
            });

            // Filter restaurants based on user input
            let filteredRestaurants = filterRestaurants(userData);
            let restaurantSuggestions = filteredRestaurants.map(restaurant => {
                return `<li class="restaurant" data-restaurant-id="${restaurant.id}">
                        <img style="height:50px; width:50px" src="${restaurant.image}" alt="${restaurant.name}" />
                        <span>${restaurant.name}</span>
                    </li>`;
            });

            // Combine item and restaurant suggestions
            let emptyArray = [...itemSuggestions, ...restaurantSuggestions];

            // Show autocomplete box
            searchInput.classList.add("active");
            showSuggestions(emptyArray);

            // Adding onclick attribute in all li tags
            let allList = resultBox.querySelectorAll("li");
            for (let i = 0; i < allList.length; i++) {
                allList[i].addEventListener("click", function () {
                    // Check if it's an item or a restaurant and perform actions accordingly
                    if (this.classList.contains("item")) {
                        let restaurantId = this.dataset.restaurantId;
                        let itemId = this.dataset.itemId;
                        // Handle item click, for example, redirect to the item's restaurant
                        window.location.href = `/restaurant/${restaurantId}`;
                    } else if (this.classList.contains("restaurant")) {
                        let restaurantId = this.dataset.restaurantId;
                        // Handle restaurant click, for example, redirect to the restaurant's details
                        window.location.href = `/restaurant/${restaurantId}`;
                    }
                    // You can customize the actions for items and restaurants here
                });
            }
        } else {
            // Hide autocomplete box
            searchInput.classList.remove("active");
        }
    };

    function showSuggestions(list) {
        let listData;
        if (!list.length) {
            userValue = input.value;
            listData = `<li>${userValue}</li>`;
        } else {
            listData = list.join('');
        }
        resultBox.innerHTML = listData;
    }

// Function to get restaurant name by ID
    function getRestaurantNameById(restaurantId) {
        let restaurant = allRestaurants.find(r => r.id === restaurantId);
        return restaurant ? restaurant.name : '';
    }

// Example: Fetch all data for a specific city (replace 'cityName' with the actual city name)
    fetchAllData(localStorage.getItem("city").toLowerCase());


});
