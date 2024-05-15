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
$sql = "SELECT ingredient_name, DATE_ADD(date_added, INTERVAL 7 DAY) AS expiry_date FROM raw_ingredients WHERE DATE_ADD(date_added, INTERVAL 7 DAY) <= NOW()";
$result = $conn->query($sql);

// Store the result in an array
$expiry_items = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $expiry_items[] = $row['ingredient_name'];
    }
}

// Close the connection
$conn->close();

// Return the expiry items as JSON
echo json_encode($expiry_items);
?>
