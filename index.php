<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_ordering_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch food items from the database
$sql = "SELECT * FROM food_items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Food Ordering System</title>
</head>
<body>
    <h1>Menu</h1>
    <form action="order.php" method="post">
        <?php while($row = $result->fetch_assoc()): ?>
            <div>
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <p>Price: $<?php echo $row['price']; ?></p>
                <input type="number" name="quantity[<?php echo $row['id']; ?>]" value="0" min="0">
            </div>
        <?php endwhile; ?>
        <input type="submit" value="Place Order">
    </form>
</body>
</html>

<?php
$conn->close();
?>
