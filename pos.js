$(document).ready(function () {
    
    // // Function to load cart items from sessionStorage
    // function loadCartFromSessionStorage() {
    //     var cartItems = sessionStorage.getItem('cartItems');
    //     if (cartItems) {
    //         $('#cart').html(cartItems);

    //         // Update card-text on product cards
    //         $('.cart-item').each(function () {
    //             var productId = $(this).data('product-id');
    //             var quantity = parseInt($(this).find('.cart-item-qty').text());
    //             updateQuantityInCardText(productId, quantity);
    //         });

    //         updateTotal();
    //     }
    // }

    // // Load cart items when the page loads
    // loadCartFromSessionStorage();
    // Function to display modal with cart items
    function displayCartModal() {
        var cartItemsModal = $('#cartModal');
        cartItemsModal.modal('show');
    }

    // Fetch products from the database using PHP and add them to the UI
    $.ajax({
        url: 'fetch_products.php',
        type: 'GET',
        success: function (response) {
            $('#product-list').html(response);

            // Disable add to cart button if quantity is zero
            $('.card-body').each(function () {
                var quantity = parseInt($(this).find('.card-text').filter(':contains("Quantity:")').text().trim().split(':')[1]);
                if (quantity === 0) {
                    $(this).find('.add-to-cart').prop('disabled', true);
                }
            });
        }
    });

    // Add product to cart when clicked
    $('#product-list').on('click', '.add-to-cart', function () {
        var button = $(this);
        var productId = button.data('product-id');
        var productName = button.data('product-name');
        var productPrice = button.data('product-price');
        var cardQuantity = parseInt($('#product-list').find('[data-product-id="' + productId + '"]').closest('.card-body').find('.card-text').filter(':contains("Quantity:")').text().trim().split(':')[1]);

        if (cardQuantity > 0) {
            // Check if product already exists in the cart
            var existingCartItem = $('#cart').find('[data-product-id="' + productId + '"]');
            if (existingCartItem.length > 0) {
                var qtySpan = existingCartItem.find('.cart-item-qty');
                var qty = parseInt(qtySpan.text());
                qtySpan.text(qty + 1);
                updateQuantityInCardText(productId, -1); // Update quantity in card text

            } else {
                var cartItem = $('<div class="cart-item" data-product-id="' + productId + '">' +
                    '<span class="cart-item-name">' + productName + '</span><br>' +
                    '<button class="btn btn-secondary decrement-qty">-</button><span class="cart-item-qty mx-4">1</span><button class="btn btn-secondary increment-qty">+</button>' +
                    '<span class="ml-3">Price: </span><span class="cart-item-price">' + productPrice + '</span> <br>' +
                    '<button class="btn btn-danger remove-from-cart my-3">Remove</button>' +
                    '<hr></div>');
                updateQuantityInCardText(productId, -1); // Update quantity in card text                 
                $('#cart').append(cartItem);
            }
            // Update total price
            updateTotal();

            // Save cart items to sessionStorage
            sessionStorage.setItem('cartItems', $('#cart').html());
        }
    });


    // Increment quantity button clicked
    $('#cart').on('click', '.increment-qty', function () {
        var qtySpan = $(this).siblings('.cart-item-qty');
        var currentQty = parseInt(qtySpan.text());
        var productId = $(this).closest('.cart-item').data('product-id');
        var cardQuantity = parseInt($('#product-list').find('[data-product-id="' + productId + '"]').closest('.card-body').find('.card-text').filter(':contains("Quantity:")').text().trim().split(':')[1]);
        if (cardQuantity > 0) {
            qtySpan.text(currentQty + 1);
            updateQuantityInCardText(productId, -1); // Update quantity in card text
            updateTotal();
            // Save cart items to sessionStorage
            sessionStorage.setItem('cartItems', $('#cart').html());
        }
    });

    // Decrement quantity button clicked
    $('#cart').on('click', '.decrement-qty', function () {
        var qtySpan = $(this).siblings('.cart-item-qty');
        var currentQty = parseInt(qtySpan.text());
        if (currentQty >= 1) {
            qtySpan.text(currentQty - 1);
            var productId = $(this).closest('.cart-item').data('product-id');
            updateQuantityInCardText(productId, 1); // Update quantity in card text
            updateTotal();
            // Save cart items to sessionStorage
            sessionStorage.setItem('cartItems', $('#cart').html());
        }
    });


    // Remove product from cart when remove button is clicked
    $('#cart').on('click', '.remove-from-cart', function () {
        var cartItem = $(this).closest('.cart-item');
        var productId = cartItem.data('product-id');
        var qtySpan = cartItem.find('.cart-item-qty');
        var qty = parseInt(qtySpan.text());


        // Update quantity displayed on the product card
        updateQuantityInCardText(productId, qty);

        // Remove cart item from UI
        cartItem.remove();
        updateTotal();
        // Save cart items to sessionStorage
        sessionStorage.setItem('cartItems', $('#cart').html());
    });

    // Function to update total price
    function updateTotal() {
        var total = 0;
        $('.cart-item').each(function () {
            var price = parseFloat($(this).find('.cart-item-price').text());
            var qty = parseInt($(this).find('.cart-item-qty').text());
            total += price * qty;
        });
        $('#total').text('Total: ₱' + total.toFixed(2));
    }

    // Function to update quantity in card text
    function updateQuantityInCardText(productId, change) {
        var quantityText = $('#product-list').find('[data-product-id="' + productId + '"]').closest('.card-body').find('.card-text').filter(':contains("Quantity:")');
        var currentQuantity = parseInt(quantityText.text().trim().split(':')[1]);
        var newQuantity = currentQuantity + change;
        if (newQuantity >= 0) {
            quantityText.text('Quantity: ' + newQuantity);
        }
    }


    // Function to update quantity in the database
    function updateQuantityInDatabase(productId, change) {
        $.ajax({
            url: 'update_quantity.php',
            type: 'POST',
            data: { productId: productId, change: change },
            success: function (response) {
                if (response !== 'success') {
                    alert('Failed to update quantity in the database.');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error occurred while updating quantity in the database.');
            }
        });
    }
    // Confirm order button click event
    $('#confirmOrderBtn').click(function () {
        // Populate modal with cart items
        populateModalWithCartItems();
        // Display modal
        displayCartModal();
    });
    // Function to populate modal with cart items
    function populateModalWithCartItems() {
        $('#confirmedCartItems').html($('#cart').html());
    }

    // Confirm button in the modal clicked
    $('#confirmOrderModalBtn').click(function () {
        // Close modal
        $('#cartModal').modal('hide');
        // Send AJAX request to confirm order
        confirmOrder();
    });

    // Function to confirm order
    function confirmOrder() {
        var cartItems = [];
        $('.cart-item').each(function () {
            var productId = $(this).data('product-id');
            var quantity = parseInt($(this).find('.cart-item-qty').text());
            var price = parseFloat($(this).find('.cart-item-price').text());
            cartItems.push({ productId: productId, quantity: quantity, price: price });
        });

        var paymentMethod = $('#paymentMethod').val(); // Get selected payment method

        // AJAX call to insert cart items into database and update quantities
        $.ajax({
            url: 'confirm_order.php', // Update with your endpoint for confirming orders
            type: 'POST',
            data: { cartItems: cartItems, paymentMethod: paymentMethod },
            success: function (response) {
                // Clear cart and session storage upon successful order confirmation
                $('#cart').html('');
                sessionStorage.removeItem('cartItems');
                updateTotal();
                // Show toaster notification for successful order confirmation
                toastr.success('Your order has been confirmed successfully!');
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error occurred while confirming the order.');
            }
        });
    }


    // Cancel button in the modal clicked
    $('#cancelOrderModalBtn').click(function () {
        // Close modal without taking any action
        $('#cartModal').modal('hide');
    });
    $('#searchInput').on('input', function () {
        var searchQuery = $(this).val().toLowerCase();
        $('.card').each(function () {
            var productName = $(this).find('.card-title').text().toLowerCase();
            if (productName.includes(searchQuery)) {
                $(this).show().parent().show(); // Show the product card and its parent column
            } else {
                $(this).hide().parent().hide(); // Hide the product card and its parent column
            }
        });
    });
// Define the printCart function
function printCart() {
    // Open a new tab
    var printWindow = window.open('', '_blank');
    
    // Random address and contact number
    var address = "New Lancaster City, Cavite, Philippines";
    var contactNumber = "+63 999 999 9999";

    // Generate the content to print
    var contentToPrint = '<h1 style="text-align: center;">Scarlett\'s Munchie Delight</h1>'; // Letterhead
    contentToPrint += '<p style="text-align: center;">' + address + '<br>' + contactNumber + '</p>'; // Address and contact number
    contentToPrint += '<table style="width:100%; border-collapse: collapse; border: 1px solid black;">'; // Start of table
    contentToPrint += '<tr><th style="border: 1px solid black; padding: 8px;">Product Name</th><th style="border: 1px solid black; padding: 8px;">Quantity</th><th style="border: 1px solid black; padding: 8px;">Price</th></tr>'; // Table header

    var totalSum = 0; // Initialize total sum
    
    // Loop through each cart item in the cartModal and add it to the table
    $('#cartModal .cart-item').each(function () {
        var productName = $(this).find('.cart-item-name').text();
        var quantity = $(this).find('.cart-item-qty').text();
        var price = parseFloat($(this).find('.cart-item-price').text().replace('$', '')); // Parse price to float
        
        totalSum += price; // Add price to total sum
        
        contentToPrint += '<tr>';
        contentToPrint += '<td style="border: 1px solid black; padding: 8px;">' + productName + '</td>';
        contentToPrint += '<td style="border: 1px solid black; padding: 8px;">' + quantity + '</td>';
        contentToPrint += '<td style="border: 1px solid black; padding: 8px;">$' + price.toFixed(2) + '</td>';
        contentToPrint += '</tr>';
    });

    contentToPrint += '</table>'; // End of table
    
    // Add total sum below the table
    contentToPrint += '<h3 style="text-align: right; margin-top: 20px;">Total: Php' + totalSum.toFixed(2) + '</h3>';
    
    // Write the content to the print window
    printWindow.document.open();
    printWindow.document.write('<html><head><title>Print Cart</title></head><body>');
    printWindow.document.write(contentToPrint);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    
    // Print the content
    printWindow.print();
}

// Add a click event listener to the print button
$('#printCartBtn').unbind('click').click(function () {
    printCart();
});


// Add a click event listener to the print button
$('#printCartBtn').unbind('click').click(function () {
    printCart();
});




});
