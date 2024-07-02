<?php



// Connect to database
$conn = pg_connect("host=$db_host port=5432 dbname=$db_name user=$db_username password=$db_password");

// Check connection
if (!$conn) {
    echo "Error: Unable to connect to database";
    exit;
}

// Query to retrieve all games
$query = "SELECT * FROM game";
$result = pg_query($conn, $query);

// Display games
if (pg_num_rows($result) > 0) {
    echo "<h1>Game Store</h1>";
    echo "<ul>";
    while ($row = pg_fetch_assoc($result)) {
        echo "<li>";
        echo "<a href='game.php?gameid=" . $row['gameid'] . "'>" . $row['title'] . "</a>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "No games found";
}

// Close database connection
pg_close($conn);
?>