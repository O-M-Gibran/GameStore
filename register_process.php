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

// Get form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Query to insert user
$query = "INSERT INTO \"User\" (username, email, \"Password\", datejoined) VALUES ('$username', '$email', '$password', NOW())";
pg_query($conn, $query);


// Get user ID
$query = "SELECT userid FROM \"User\" WHERE username = '$username' AND email = '$email' AND password = '$password'";
$result = pg_query($conn, $query);
$row = pg_fetch_assoc($result);
$userid = $row['userid'];

$query = "INSERT INTO \"Library\" (userid) VALUES ('$userid')";
pg_query($conn, $query);
// Set user session
$_SESSION['userid'] = $userid;

// Close database connection
pg_close($conn);

// Redirect to index page
header('Location: index.php');
exit;
?>