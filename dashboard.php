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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="jumbotron vertical-center bg-dark">
    <div class="container d-flex justify-content-center ">
      <div class="d-inline-flex  bg-secondary text-light p-3 rounded-4">
        <div class="row">
          <div class="col-12">
            <h1>My Library</h1>
            <a href="storepage.php" class="btn btn-primary">STORE</a>
          </div>
        </div>
        <table class="table table-striped table-borderless table-dark">
          <tr>
            <th>Game Title</th>
            <th>Username</th>
            <th>Purchase Date</th>
          </tr>
          <?php while ($row = pg_fetch_assoc($result)) { ?>
          <tr>
            <td><?= $row['title'] ?></td>
            <td><?= $row['username'] ?></td>
            <td><?= $row['purchasedate'] ?></td>
          </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Close the database connection
pg_close($conn);
?>