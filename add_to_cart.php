<?php
// Establish a connection to your database
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "inventory_system"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve product ID from POST request
$productId = $_POST['productId'];

// Check if the product already exists in the cart
$existingCartItemQuery = "SELECT * FROM cart WHERE product_id = $productId";
$existingCartItemResult = $conn->query($existingCartItemQuery);

if ($existingCartItemResult->num_rows > 0) {
    // Product already exists in the cart, update quantity
    $existingCartItem = $existingCartItemResult->fetch_assoc();
    $newQuantity = $existingCartItem['quantity'] + 1;
    $updateCartItemQuery = "UPDATE cart SET quantity = $newQuantity WHERE product_id = $productId";
    if ($conn->query($updateCartItemQuery) === TRUE) {
        echo "Quantity updated successfully";
    } else {
        echo "Error updating quantity: " . $conn->error;
    }
} else {
    // Fetch product details from the database based on $productId
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Product found, fetch details
        $product = $result->fetch_assoc();

        // Insert new cart item with quantity 1
        $insertCartItemQuery = "INSERT INTO cart (product_id, quantity) VALUES ($productId, 1)";
        if ($conn->query($insertCartItemQuery) === TRUE) {
            echo "New item added to cart successfully";
        } else {
            echo "Error adding new item to cart: " . $conn->error;
        }
    } else {
        echo "Product not found";
    }
}

// Close connection
$conn->close();
?>
