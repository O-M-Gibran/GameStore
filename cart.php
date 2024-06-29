<?php
// Configuration
$db_host = 'localhost';
$db_username = 'postgres';
$db_password = 'stegoceratops745';
$db_name = 'postgres';

// Connect to database
$conn = pg_connect("host=$db_host port=5432 dbname=$db_name user=$db_username password=$db_password");

// Check connection
if (!$conn) {
    echo "Error: Unable to connect to database";
    exit;
}

// Get user ID from session (assuming user is logged in)
$userid = $_SESSION['userid'];

// Query to retrieve user's library
$query = "SELECT * FROM library WHERE userid = $userid";
$result = pg_query($conn, $query);

// Display cart
if (pg_num_rows($result) > 0) {
    echo "<h1>Cart</h1>";
    echo "<ul>";
    while ($row = pg_fetch_assoc($result)) {
        echo "<li>";
        echo $row['gameid'] . " - " . $row['purchasedate'];
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "Your cart is empty";
}

// Close database connection
pg_close($conn);
?>