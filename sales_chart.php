<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch sales data from the database
function fetchSalesData($interval) {
    global $conn;
    // Aggregate data based on the specified interval
    switch ($interval) {
        case 'daily':
            $sql = "SELECT DATE(date) AS date, SUM(price) AS total_sales FROM sales GROUP BY DATE(date)";
            break;
        case 'weekly':
            $sql = "SELECT YEAR(date) AS year, WEEK(date) AS week, SUM(price) AS total_sales FROM sales GROUP BY YEAR(date), WEEK(date)";
            break;
        case 'monthly':
            $sql = "SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(price) AS total_sales FROM sales GROUP BY YEAR(date), MONTH(date)";
            break;
        case 'yearly':
            $sql = "SELECT YEAR(date) AS year, SUM(price) AS total_sales FROM sales GROUP BY YEAR(date)";
            break;
        default:
            return [];
    }
    $result = $conn->query($sql);
    $salesData = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $salesData[] = $row;
        }
    }
    return $salesData;
}

// Get interval from the query parameters
$interval = isset($_GET['interval']) ? $_GET['interval'] : 'daily';
// Fetch sales data
$salesData = fetchSalesData($interval);
// Return data as JSON
header('Content-Type: application/json');
echo json_encode($salesData);
