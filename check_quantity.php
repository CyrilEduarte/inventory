<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scinventory_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT ingredient_name, stock_quantity FROM raw_ingredients WHERE stock_quantity < 20";
$result = $conn->query($sql);

// Store the result in an array
$low_stock_items = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $low_stock_items[] = $row['ingredient_name'];
    }
}

// Close the connection
$conn->close();

// Return the low stock items as JSON
echo json_encode($low_stock_items);
?>
