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

// Get the product ID from POST data
$productId = $_POST['productId'];

// Decrement quantity in the database
$sql = "UPDATE products SET quantity = quantity - 1 WHERE id = $productId";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
