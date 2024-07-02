<?php
session_start();
require_once 'connection.php';
// Now you can use the $conn variable to interact with the database

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
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top">
    <div class="container">
      <a class="navbar-brand">(-_-)</a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard.php">Library</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="storepage.php">Store</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="transaction.php">Transactions</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

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
            <a class="btn btn-danger" href="buy.php?gameid=<?php echo $row['gameid'];?>">BUY</a>
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