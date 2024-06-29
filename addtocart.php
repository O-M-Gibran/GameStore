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

// Get user ID from session
$userid = $_SESSION['userid'];

// Query to add game to library
$query = "INSERT INTO library (userid, gameid, purchasedate) VALUES ($userid, $gameid, NOW())";
pg_query($conn, $query);

// Close database connection
pg_close($conn);

exit;
?>