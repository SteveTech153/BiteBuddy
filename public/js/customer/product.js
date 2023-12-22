$(document).ready(function () {
    const addItemBtns = $('.additem-btn');
    const newCartOverlay = $('#new-cart-overlay');
    let tmpCart = {};
    let currentRestaurantId = "";

    addItemBtns.on('click', function () {
        currentRestaurantId = $('[name="restaurantId"]').val();

        if (localStorage.getItem('cart') != null && JSON.parse(localStorage.getItem('cart')).restaurantId !== currentRestaurantId) {
            newCartOverlay.css('top', 0);
            tmpCart = {
                "restaurant": $('#restaurantName').text(),
                "items": [
                    {
                        "name": $(this).closest('.item').find('#item-display-name').text(),
                        "price": $(this).closest('.item').find('#item-price').text(),
                        "quantity": 1,
                        "itemId": $(this).closest('.item').find('[name="itemId"]').val()
                    }
                ],
                "restaurantId": currentRestaurantId,
                "restaurantAddress": $('[name="restaurantAddress"]').val(),
            };
            localStorage.setItem('tmpCart', JSON.stringify(tmpCart));
        } else {
            let cart = JSON.parse(localStorage.getItem('cart')) || {
                "restaurant": $('#restaurantName').text(),
                "items": [],
                "restaurantId": currentRestaurantId,
                "restaurantAddress": $('[name="restaurantAddress"]').val(),
            };

            let item = {
                "name": $(this).closest('.item').find('#item-display-name').text(),
                "price": $(this).closest('.item').find('#item-price').text(),
                "quantity": 1,
                "itemId": $(this).closest('.item').find('[name="itemId"]').val()
            };

            cart.items.push(item);
            localStorage.setItem('cart', JSON.stringify(cart));

            $(this).hide();
            $(this).siblings('.add-btn').css({
                'visibility': 'visible',
                'display': 'flex'
            });
        }

        updateFooter();
    });

    if (localStorage.getItem('cart') != null && JSON.parse(localStorage.getItem('cart')).restaurantId === $('[name="restaurantId"]').val()) {
        let cart = JSON.parse(localStorage.getItem('cart'));
        let items = cart.items;

        items.forEach(function (item, i) {
            let itemId = item.itemId;
            let itemRight = $(`[id="add-${itemId}"]`).parent();

            itemRight.find('.additem-btn').hide();
            itemRight.find('.add-btn').css({
                'visibility': 'visible',
                'display': 'flex'
            });
            itemRight.find('.qty').text(item.quantity);
        });

        updateFooter();
    }

    const plusBtns = $('.plus-btn');
    const minusBtns = $('.minus-btn');

    plusBtns.on('click', function () {
        let qty = $(this).siblings('.qty');
        qty.text(parseInt(qty.text()) + 1);

        let cart = JSON.parse(localStorage.getItem('cart'));
        let items = cart.items;
        let itemId = $(this).closest('.item').find('[name="itemId"]').val();

        items.forEach(function (item, i) {
            if (item.itemId === itemId) {
                item.quantity = parseInt(qty.text());
                return;
            }
        });

        cart.items = items;
        localStorage.setItem('cart', JSON.stringify(cart));
        updateFooter();
    });

    minusBtns.on('click', function () {
        let qty = $(this).siblings('.qty');

        if (parseInt(qty.text()) === 1) {
            $(this).parent().css('visibility', 'hidden');
            $(this).closest('.item').find('.additem-btn').css('display', 'inline-block');

            let cart = JSON.parse(localStorage.getItem('cart'));
            cart.items = cart.items.filter(item => item.itemId !== ($(this).closest('.item').find('[name="itemId"]').val()));
            localStorage.setItem('cart', JSON.stringify(cart));
            updateFooter();
        } else {
            qty.text(parseInt(qty.text()) - 1);

            let cart = JSON.parse(localStorage.getItem('cart'));
            let items = cart.items;
            let itemId = $(this).closest('.item').find('[name="itemId"]').val();

            items.forEach(function (item, i) {
                if (item.itemId === itemId) {
                    item.quantity = parseInt(qty.text());
                    return;
                }
            });

            cart.items = items;
            localStorage.setItem('cart', JSON.stringify(cart));
            updateFooter();
        }

        checkIfCartEmpty();
    });

    function checkIfCartEmpty() {
        let cart = JSON.parse(localStorage.getItem('cart'));

        if (!cart || cart.items.length === 0) {
            localStorage.removeItem('cart');
            localStorage.removeItem('tmpCart');
        }
    }

    //item footer update
    function updateFooter() {
        const itemFooter = $('.item-footer');
        let noOfItems = itemFooter.find('#no-of-items');
        let totalPrice = itemFooter.find('#total-price');
        let total = 0;
        let cart = JSON.parse(localStorage.getItem('cart'));

        if (!cart) {
            noOfItems.text(0);
            totalPrice.text(0);
        } else {
            cart.items.forEach(item => {
                total += parseInt(item.price) * parseInt(item.quantity);
            });

            totalPrice.text(total);
            total = 0;

            cart.items.forEach(item => {
                total += parseInt(item.quantity);
            });

            noOfItems.text(total);
        }
    }

    updateFooter();

    const footerViewCartButton = $('.view-cart-footer');
    footerViewCartButton.on('click', function () {
        window.location.href = '/checkout';
    });

    const sidebar = $('.sidebar');
    sidebar.hide();
    const openSidebarBtn = $('#open-sidebar');
    openSidebarBtn.text(localStorage.getItem("city")).hide();

    const resetCartBtn = $('#reset-cart');
    const cancelBtn = $('#cancel');

    resetCartBtn.on('click', function () {
        localStorage.setItem('cart', localStorage.getItem('tmpCart'));
        localStorage.removeItem('tmpCart');
        newCartOverlay.css('top', '100%');
        updateFooter();
        window.location.reload();
    });

    cancelBtn.on('click', function () {
        newCartOverlay.css('top', '100%');
        localStorage.removeItem('tmpCart');
    });
});
