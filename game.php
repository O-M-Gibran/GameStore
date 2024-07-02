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
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title><?php echo $row['title']; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class=" jumbotron vertical-center bg-dark">
        <div class="container bg-dark">
            <h1 class="text-center text-light"><?php echo $row['title']; ?></h1>
            <table class="table table-striped">
                <tr>
                    <th>Description</th>
                    <td><?php echo $row['description']; ?></td>
                </tr>
                <tr>
                    <th>Release Date</th>
                    <td><?php echo $row['releasedate']; ?></td>
                </tr>
                <tr>
                    <th>Developer</th>
                    <td><?php echo $row['developer']; ?></td>
                </tr>
                <tr>
                    <th>Publisher</th>
                    <td><?php echo $row['publisher']; ?></td>
                </tr>
                <tr>
                    <th>Platform</th>
                    <td><?php echo $row['platform']; ?></td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>$<?php echo $row['price']; ?></td>
                </tr>
                <tr>
                    <th>Rating</th>
                    <td><?php echo $row['rating']; ?>/10</td>
                </tr>
                <tr>
                    <th>Review</th>
                    <td><?php echo $row['review']; ?></td>
                </tr>
            </table>
            <button type="button" class="btn btn-primary text-light"><a href="buy.php?gameid=<?php echo $row['gameid'];?>">BUY</a></button>
        </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    </body>
    </html>
    <?php
} else {
    echo "Game not found";
}

// Close database connection
pg_close($conn);
?>