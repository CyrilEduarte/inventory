<?php
// Establish connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scinventory_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database with image file locations
$sql = "SELECT p.id, p.name, p.quantity, p.buy_price, p.sale_price, m.file_name AS image_path
        FROM products p
        INNER JOIN media m ON p.media_id = m.id";
$result = $conn->query($sql);

// Display products
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check if quantity is zero
        $disabled = ($row["quantity"] == 0) ? 'disabled' : '';
        
        echo '<div class="col-md-4 col-sm-2 pb-3">' .
                '<div class="card shadow p-4">' .
                    '<div class="card-body">' .
                        '<img class="rounded" src="uploads/products/' . $row["image_path"] . '" class="card-img-top" style="width: 100%; height: 200px; object-fit: cover;">' . // Fixed size for images
                        '<h6 class="card-title pt-3">' . $row["name"] . '</h6>' .
                        '<p class="card-text">Price: ₱' . $row["sale_price"] . '</p>' .
                        '<p class="card-text">Quantity: ' . $row["quantity"] . '</p>' .
                        '<input type="hidden" class="product-id" value="' . $row["id"] . '">' .
                        '<button class="btn btn-primary add-to-cart" data-product-id="' . $row["id"] . '" data-product-name="' . $row["name"] . '" data-product-price="' . $row["sale_price"] . '" ' . $disabled . '>Add to Cart</button>' .
                    '</div>' .
                '</div>' .
            '</div>';
    }
} else {
    echo "0 results";
}
$conn->close();
?>
