$(document).ready(function () {
    const openSidebarBtn = document.querySelector("#open-sidebar");
    openSidebarBtn.innerText = localStorage.getItem("city");
    openSidebarBtn.style.display = "none";
    function fetchOrderDetails() {
    $.ajax({
        url: '/get-order-details',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if(response.data.length === 0) {
                //set a image here
                $('#card-container').html('<img style="height:30%; width:30%;" src="https://static.vecteezy.com/system/resources/previews/014/814/239/large_2x/no-order-a-flat-rounded-icon-is-up-for-premium-use-vector.jpg" alt="empty-cart" class="empty-cart">');
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
    setInterval(fetchOrderDetails, 30000);
});