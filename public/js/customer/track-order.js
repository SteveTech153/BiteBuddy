$(document).ready(function () {
    function fetchOrderDetails() {
    $.ajax({
        url: '/get-order-details',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if(response.data.length === 0) {
                //set a image here
                $('#card-container').html('<img src="https://hsnbazar.com/images/empty-cart.png" alt="empty-cart" class="empty-cart">');
            }
            console.log(response.data[0]);
            $('#restaurant-name').text(response.data[0].restaurant_name);
            if(response.data[0].status == 'delivered') {
                $('#status').text('Your order has been delivered');
            }
            else if(response.data[0].status=='confirmed' || response.data[0].status=='pending') {
                $('#status').text('Your order is being prepared by the restaurant');
            }
            if(response.data[0].delivery_personnel == 'Not assigned') {
                $('#delivery-personnel-name').text('Delivery partner will be assigned soon');
            }else{
                $('#delivery-personnel-name').text("Your delivery partner is "+response.data[0].delivery_personnel);
            }

            $('#delivery-personnel-name').text(response.data[0].delivery_personnel);
            $('#items').empty();
            response.data[0].products.forEach(function(item) {
                $('#items').append(
                    '<div class="item">' +
                    '<div class="item-display-name"><i></i> ' + item.name + '</div>' +
                    '<input type="hidden" name="itemId" value="' + item.itemId + '">' +
                    '<div class="add-btn">' +
                    '<div class="qty">' + item.quantity + '</div>' +
                    '</div>' +
                    '<div class="price">$' + item.price + '</div>' +
                    '</div>'
                );
            });
        },
        error: function(error) {
            console.log(error);
        }
    });
    }
    fetchOrderDetails();

    $('#reload-status').click(function() {
        fetchOrderDetails();
    } );
});