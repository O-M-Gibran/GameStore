<?php
session_start();
// Configuration
$db_host = 'localhost';
$db_username = 'postgres';
$db_password = 'stegoceratops745';
$db_name = 'postgres';
// Connect to the database
$conn = pg_connect("host=$db_host port=5432 dbname=$db_name user=$db_username password=$db_password");
$query = "SELECT * FROM game";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Games List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
      .hasil-tabel:hover{
        cursor: pointer;
        transform: scale(1.05);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        transition: 0.1s ease-in-out;
      }
    </style>
</head>
<body>
  <div class="jumbotron vertical-center bg-dark">
    <div class="container d-flex justify-content-center ">
      <div class="d-inline-flex  bg-secondary text-light p-3 rounded-4">
        <table class="table table-striped table-borderless table-dark">
          <thead>
            <tr>
              <th>Title</th>
              <th>Description</th>
              <th>Developer</th>
              <th>Price</th>
              <th>Rating</th>
            </tr>
          </thead>
          <?php while ($row = pg_fetch_assoc($result)) { ?>
          <tr class="hasil-tabel" data-href="game.php?gameid=<?php echo $row['gameid']; ?>">
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['developer']; ?></td>
            <td><?php echo number_format($row['price'], 2, '.', ','); ?></td>
            <td><?php echo $row['rating']; ?></td>
          </tr>
          <?php } ?>
        </table>
        <button type="button" class="btn btn-primary"><a href="dashboard.php">BUY</a></button>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>
</html>