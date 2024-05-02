<?php

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if cart items are present in the request
    if (isset($_POST['cartItems']) && !empty($_POST['cartItems'])) {
        // Process cart items
        $cartItems = $_POST['cartItems'];

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

        // Prepare and execute SQL queries to update product quantities
        $success = true;
        foreach ($cartItems as $item) {
            $productId = $conn->real_escape_string($item['productId']); // Sanitize user input
            $quantity = $conn->real_escape_string($item['quantity']); // Sanitize user input

            // Update product quantity in the database using prepared statement
            $sqlUpdate = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("ii", $quantity, $productId);
            if ($stmtUpdate->execute() !== TRUE) {
                echo "Error updating record: " . $conn->error;
                $success = false;
                break; // Stop processing further items if one update fails
            }
            $stmtUpdate->close();
            break;
        }

        // Insert order details into orders table if all product updates were successful
        if ($success) {
            foreach ($cartItems as $item) {
                $productId = $conn->real_escape_string($item['productId']); // Sanitize user input
                $quantity = $conn->real_escape_string($item['quantity']); // Sanitize user input
                $price = $conn->real_escape_string($item['price']); // Sanitize user input

                // Insert order details into sales table using prepared statement
                $sqlInsert = "INSERT INTO sales (product_id, qty, price) VALUES (?, ?, ?)";
                $stmtInsert = $conn->prepare($sqlInsert);
                $stmtInsert->bind_param("iii", $productId, $quantity, $price);
                if ($stmtInsert->execute() !== TRUE) {
                    echo "Error inserting record: " . $conn->error;
                    $success = false;
                    break; // Stop processing further items if one insert fails
                }
                $stmtInsert->close();
                $conn->close();
            }
        }

        // Close database connection
        $conn->close();

        // Send a success response back to the client-side if all operations were successful
        if ($success) {
            echo "success";
        }
    } else {
        // No cart items found in the request
        echo "No cart items found in the request.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>