<?php
session_start();
// Configuration
$db_host = 'localhost';
$db_username = 'postgres';
$db_password = 'stegoceratops745';
$db_name = 'postgres';
// Connect to the database
$conn = pg_connect("host=$db_host port=5432 dbname=$db_name user=$db_username password=$db_password");

// Check connection
if (!$conn) {
  echo "An error occurred.\n";
  exit;
}



// Get the current user's ID
$current_user_id = $_SESSION["userid"];
echo $current_user_id;

// Query to retrieve the user's library
$query = "SELECT l.libraryid, g.title, u.username, l.purchasedate
           FROM \"Library\" l
           JOIN game g ON l.gameid = g.gameid
           JOIN \"User\" u ON l.userid = u.userid
           WHERE l.userid = $current_user_id";

// Execute the query
$result = pg_query($conn, $query);

// Check if the query was successful
if (!$result) {
  echo "An error occurred.\n";
  exit;
}

// Display the user's library
echo "<h1>My Library</h1>";
echo "<table>";
echo "<tr><th>Game Title</th><th>Username</th><th>Purchase Date</th></tr>";

while ($row = pg_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>". $row['title']. "</td>";
  echo "<td>". $row['username']. "</td>";
  echo "<td>". $row['purchasedate']. "</td>";
  echo "</tr>";
}

echo "</table>";

// Close the database connection
pg_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <button type="button"><a href="storepage.php">STORE</a></button>
</head>
<body>
    
</body>
</html>