<?php
// Assuming you're using MySQL database
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
// Get product ID and change in quantity from POST request
$productId = $_POST['productId'];
$change = $_POST['change'];

// Update quantity in the database
$sql = "UPDATE products SET quantity = quantity + $change WHERE id = $productId";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
