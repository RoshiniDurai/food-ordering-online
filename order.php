<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_ordering_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Customer details (for simplicity, these are hardcoded)
$customer_name = "John Doe";
$customer_email = "john@example.com";
$customer_phone = "1234567890";

// Calculate total amount and insert order
$total_amount = 0;

foreach ($_POST['quantity'] as $food_item_id => $quantity) {
    if ($quantity > 0) {
        $sql = "SELECT price FROM food_items WHERE id=$food_item_id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $price = $row['price'];
        $total_amount += $price * $quantity;
    }
}

$sql = "INSERT INTO orders (customer_name, customer_email, customer_phone, total_amount) VALUES ('$customer_name', '$customer_email', '$customer_phone', $total_amount)";
$conn->query($sql);

$order_id = $conn->insert_id;

foreach ($_POST['quantity'] as $food_item_id => $quantity) {
    if ($quantity > 0) {
        $sql = "SELECT price FROM food_items WHERE id=$food_item_id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $price = $row['price'];
        $sql = "INSERT INTO order_items (order_id, food_item_id, quantity, price) VALUES ($order_id, $food_item_id, $quantity, $price)";
        $conn->query($sql);
    }
}

echo "Order placed successfully!";

$conn->close();
?>
