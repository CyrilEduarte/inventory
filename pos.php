<!DOCTYPE html>
<html lang="en">

<?php
require_once('includes/load.php');
?>

<head>
    <link rel="icon" type="" href="libs/images/Mark-red.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point of Sale</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        /* Custom CSS for fixing the sidebar and styling the confirm button */
        body {
            font-family: Poppins, sans-serif;
        }

        .fixed-sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0;
            z-index: 1030;
            /* Adjust z-index if necessary */
            overflow-y: auto;
            overflow-x: hidden;
            /* Disable horizontal scroll */
            padding: 20px;
            /* Add padding for better visibility */
            background-color: #fff;
            /* Add background color if needed */
            border-left: 1px solid #dee2e6;
            /* Add border for separation */
        }

        .cart-section {
            height: calc(80vh);
            /* 80% of viewport height minus height of total menu */
            overflow-y: auto;
            /* Enable vertical scrollbar if needed */
            position: relative;
            /* Make it relative */
        }

        .total-menu {
            position: absolute;
            /* Make it absolute */
            bottom: 0;
            /* Align it to the bottom of the sidebar */
            width: 100%;
            /* Full width */
            background-color: white;
            /* Add your preferred background color */
            /* Add some padding */
            border-top: 1px solid #ccc;
            /* Add a border to separate from the cart section */
        }

        .fixed-total {
            position: absolute;
            bottom: 50px;
            /* Adjust the bottom position */
            width: 100%;
            padding: 20px;
            background-color: #f8f9fa;
            /* Add background color if needed */
            border-top: 1px solid #dee2e6;
            /* Add border for separation */
        }

        .confirm-button {
            width: 80%;
        }

        .product-list-container {
            display: flex;
            flex-direction: column;
            height: calc(80vh - 50px);
            /* 80% of viewport height minus height of total menu */
            overflow-y: auto;
            /* Enable vertical scrollbar if needed */
            position: relative;
            /* Make it relative */
        }

        .card {
            border-bottom: 5px solid #BD2025;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .card-body {
            flex-grow: 1;
        }

        .btn-primary {
            background-color: #20BDB8;
        }

        .cart-item-qty {
            width: 50px;
        }

        .search-bar {
            border-radius: 20px;
        }

        .grey-bg {
            background-color: #f9f9f9;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top border bg-white">
        <div class="container-fluid">
            <a class="navbar-brand " href="index.php">
                <img src="libs/images/red.png" alt="Logo" width="150px">
            </a>
            <!-- Add any additional navbar items or links here -->
        </div>
    </nav>
    <div class="container-fluid bg-light pt-3">
        <div class="row ">
            <div class="col-md-9">
                <div class="col-md-12 mb-3">
                    <h2>Products</h2>
                    <input type="text" class="form-control search-bar" id="searchInput" placeholder="Search products...">
                </div>

                <div class="row container row-cols-3 g-5 p-5" id="product-list">
                    <!-- Products will be dynamically added here -->
                </div>
            </div>


            <div class="row row-cols-1 col-md-3 fixed-sidebar">
                <h2>CART</h2>
                <div class="cart-section mb-1">
                    <div id="cart">
                        <!-- Cart items will be dynamically added here -->
                    </div>
                </div>
                <div class="total-menu">
                    <div id="total" class="py-2">Total: ₱ 0.00</div>
                    <div class="pb-3"><button class="btn btn-primary confirm-button" id="confirmOrderBtn" name="confirmOrderBtn">Confirm Order</button></div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Confirm Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="confirmedCartItems">
                        <!-- Display confirmed items here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelOrderModalBtn" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmOrderModalBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="pos.js"></script>
    <script></script>
</body>

</html>