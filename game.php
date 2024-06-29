<?php
session_start();
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

// Get game ID from URL parameter
$gameid = $_GET['gameid'];

// Query to retrieve game details
$query = "SELECT * FROM game WHERE gameid = $gameid";
$result = pg_query($conn, $query);

// Display game details
if (pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);
    echo "<h1>" . $row['title'] . "</h1>";
    echo "<p>Description: " . $row['description'] . "</p>";
    echo "<p>Release Date: " . $row['releasedate'] . "</p>";
    echo "<p>Developer: " . $row['developer'] . "</p>";
    echo "<p>Publisher: " . $row['publisher'] . "</p>";
    echo "<p>Platform: " . $row['platform'] . "</p>";
    echo "<p>Price: $" . $row['price'] . "</p>";
    echo "<p>Rating: " . $row['rating'] . "/10</p>";
    echo "<p>Review: " . $row['review'] . "</p>";
} else {
    echo "Game not found";
}

// Close database connection
pg_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>