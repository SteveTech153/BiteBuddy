$(document).ready(function(){
    // Retrieve cart data from localStorage
    const cartData = JSON.parse(localStorage.getItem('cart'));
    let totalPrice = 0;
    // Check if cartData is available and not empty
    if (cartData) {
        // Update restaurant info
        document.getElementById('restaurant-name').textContent = cartData.restaurant;
        document.getElementById('restaurant-address').textContent = cartData.restaurantAddress;

        // Update restaurant image (if available)
        const restaurantImage = document.getElementById('restaurant-image');
        if (cartData.restaurantImage) {
            restaurantImage.src = cartData.restaurantImage;
            restaurantImage.alt = 'Restaurant Image';
        }

        // Update the list of items
        const itemsContainer = document.getElementById('items');
        itemsContainer.innerHTML = ''; // Clear existing items

        cartData.items.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.classList.add('item');
            itemElement.innerHTML = `
                <div class="item-display-name">${item.name}</div>
                <input type="hidden" name="itemId" value="${item.itemId}">
                <div class="add-btn">
                    <div class="minus-btn">-</div>
                    <div class="qty">${item.quantity}</div>
                    <div class="plus-btn">+</div>
                </div>
                <div class="price">$${item.price}</div>
            `;
            itemsContainer.appendChild(itemElement);
        });

        // Update the bill details
        document.getElementById('item-total').textContent = `$${calculateItemTotal(cartData.items)}`;
        document.getElementById('platform-fee').textContent = `$2`;
        totalPrice = `${calculateTotalPrice(cartData.items, 2)}`;
        document.getElementById('total-price').textContent =  "$"+totalPrice;
    } else {
        // Handle the case where cart data is not available
        console.log('Cart data is empty or not available in localStorage.');
        let checkoutSection = document.getElementById('checkout');
        checkoutSection.innerHTML = `<img style="margin-left:-2.5em" src = "https://hsnbazar.com/images/empty-cart.png" alt = "Empty Cart" > `;
    }

    // Helper function to calculate item total price
    function calculateItemTotal(items) {
        // reduce to 2 decimal places
        return items.reduce((total, item) => total + (item.quantity * item.price), 0).toFixed(2);
    }

    // Helper function to calculate total price including platform fee
    function calculateTotalPrice(items, platformFee) {
        const itemTotal = calculateItemTotal(items);
        return (parseFloat(itemTotal) + parseFloat(platformFee));
    }

    $(document).on('click', '.plus-btn', function() {
        const itemContainer = $(this).closest('.item');
        const quantityElement = itemContainer.find('.qty');
        const currentQuantity = parseInt(quantityElement.text());
        quantityElement.text(currentQuantity + 1);
        let itemId = itemContainer.find('[name="itemId"]').val();
        let cart = JSON.parse(localStorage.getItem('cart'));
        let items = cart.items;
        items.forEach(item => {
            if(item.itemId === itemId){
                item.quantity = currentQuantity + 1;
            }
        });
        cart.items = items;
        localStorage.setItem('cart', JSON.stringify(cart));
        // Update the total price
        updateTotalPrice();
    });

    // Event listener for minus button
    $(document).on('click', '.minus-btn', function() {
        const itemContainer = $(this).closest('.item');
        const quantityElement = itemContainer.find('.qty');
        const currentQuantity = parseInt(quantityElement.text());

        // Ensure the quantity does not go below 1
        if (currentQuantity > 1) {
            quantityElement.text(currentQuantity - 1);
            let itemId = itemContainer.find('[name="itemId"]').val();
            let cart = JSON.parse(localStorage.getItem('cart'));
            let items = cart.items;
            items.forEach(item => {
                if(item.itemId === itemId){
                    item.quantity = currentQuantity - 1;
                }
            });
            cart.items = items;
            localStorage.setItem('cart', JSON.stringify(cart));
            // Update the total price
            updateTotalPrice();
        }
        else {
            // Remove the item from the cart
            itemContainer.remove();
            let itemId = itemContainer.find('[name="itemId"]').val();
            let cart = JSON.parse(localStorage.getItem('cart'));
            let items = cart.items;
            items = items.filter(item => item.itemId !== itemId);
            cart.items = items;
            localStorage.setItem('cart', JSON.stringify(cart));
            // Update the total price
            updateTotalPrice();
            checkIfCartEmpty();
        }
    });

    function checkIfCartEmpty(){
        let cart = JSON.parse(localStorage.getItem('cart'));
        if(cart.items.length===0){
            localStorage.removeItem('cart');
            localStorage.removeItem('tmpCart');
        }
    }
    // Helper function to update the total price based on item quantities
    function updateTotalPrice() {
        const items = [];
        $('.item').each(function() {
            const itemName = $(this).find('.item-display-name').text();
            const itemQuantity = parseInt($(this).find('.qty').text());
            const itemPrice = parseFloat($(this).find('.price').text().replace('$', ''));
            items.push({
                name: itemName,
                quantity: itemQuantity,
                price: itemPrice
            });
        });

        // Update the item total and total price
        const itemTotal = calculateItemTotal(items);
        const platformFee = 2; // Set your platform fee here
        const totalPrice = calculateTotalPrice(items, platformFee);

        $('#item-total').text(`$${itemTotal}`);
        $('#total-price').text(`$${totalPrice}`);
    }

    const addMoreItemsButton = document.getElementById('add-more-btn');
    if(addMoreItemsButton) {
        addMoreItemsButton.addEventListener('click', function () {
            window.location.href = 'restaurant/' + cartData.restaurant;
        });
    }
    const sidebar = document.querySelector(".sidebar");
    sidebar.style.display = "none";
    const openSidebarBtn = document.querySelector("#open-sidebar");
    openSidebarBtn.innerText = localStorage.getItem("city");
    openSidebarBtn.style.display = "none";

    const payBtn = $('#pay-btn');

    function showLoadingOverlay() {
        document.getElementById('loadingOverlay').style.display = 'block';
    }

// Function to hide loading overlay
    function hideLoadingOverlay() {
        document.getElementById('loadingOverlay').style.display = 'none';
    }

    let isUserLoggedIn= 'no';
    payBtn.on('click', function (e) {
        e.preventDefault();
        const address = $('#address-input').val();
        const addressError = $('#address-error');
        if(address === ''){
            addressError.text('Please enter your address');
            addressError.css({
                'display': 'block',
                'color': 'red'
            });
        }else {
            userLoggedIn();
            showLoadingOverlay();
            setTimeout(function() {
                hideLoadingOverlay();
                if (isUserLoggedIn ==='yes') {
                    placeOrder();
                } else {
                    openLoginModal();
                }
            }, 2000);
        }
    });

    function userLoggedIn(){
        $.ajax({
            method: 'GET',
            url: 'current-user',
            dataType: 'json',
            success: function (data) {
                console.log(data.message);
                isUserLoggedIn = data.message;
            },
            error: function (err) {
                console.log(err);
                return false;
            }
        });
    }

    function placeOrder() {
        // const orderData = JSON.parse(localStorage.getItem('cart'));
        // orderData.address = $('#address-input').val();
        // orderData.totalPrice = totalPrice;
        // localStorage.removeItem('cart');
        // localStorage.removeItem('tmpCart');
        //
        // // Get the CSRF token value from the meta tag
        // const csrfToken = $('meta[name="csrf-token"]').attr('content');
        // $.ajax({
        //     method: 'POST',
        //     url: '/place-order',
        //     data: orderData,
        //     dataType: 'json',
        //     async: false,
        //     headers: {
        //         'X-CSRF-TOKEN': csrfToken
        //     },
        //     success: function (data) {
        //         console.log(data.message);
        //     },
        //     error: function (err) {
        //         console.log(err);
        //         return false;
        //     }
        // });
        // $.ajax({
        //     method: 'POST',
        //     url: '/place-order',
        //     data: orderData,
        //     dataType: 'json',
        //     headers: {
        //         'X-CSRF-TOKEN': csrfToken
        //     },
        //     success: function (data) {
        //         console.log(data.message);
        //
        //         // Assuming your server returns a 'redirect_url' in the response
        //         if (data.redirect_url) {
        //             window.location.href = data.redirect_url;
        //         }
        //     },
        //     error: function (err) {
        //         console.log(err);
        //         // Handle error as needed
        //     }
        // });
        const checkOutForm = $('#checkout-form');
        $('#restaurant-id-input').val(cartData.restaurantId);
        $('#restaurant-name-input').val(cartData.restaurant);
        $('#customer-address-input').val($('#address-input').val());
        $('#total-price-input').val(totalPrice);
        $('#items-input').val(JSON.stringify(cartData.items));
        localStorage.removeItem('cart');
        localStorage.removeItem('tmpCart');
        checkOutForm.submit();
    }



});