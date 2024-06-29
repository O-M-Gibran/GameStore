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

<html>
  <head>
    <title>Games List</title>
    <style>
      table {
        border-collapse: collapse;
        width: 100%;
      }
      th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
      }
    </style>
    
  </head>
  <body>
    <h1>INI TOKO GAME</h1>
    <table>
        <thead>
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Release Date</th>
        <th>Developer</th>
        <th>Publisher</th>
        <th>Platform</th>
        <th>Price</th>
        <th>Rating</th>
        <th>Review</th>
      </tr>
      </thead>
      <?php while ($row = pg_fetch_assoc($result)) { ?>
        <div class="table-clickable">
      <tr  data-href="game.php?gameid=<?php echo $row['gameid']; ?>">
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['releasedate']; ?></td>
            <td><?php echo $row['developer']; ?></td>
            <td><?php echo $row['publisher']; ?></td>
            <td><?php echo $row['platform']; ?></td>
            <td><?php echo number_format($row['price'], 2, '.', ','); ?></td>
            <td><?php echo $row['rating']; ?></td>
            <td><?php echo $row['review']; ?></td>
      </tr>
      </div>
      <?php } ?>
    </table>
    <button type="button"><a href="dashboard.php">BUY   </a></button>
    <script src="script.js"></script>
  </body>

</html>