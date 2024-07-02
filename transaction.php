<?php
session_start();
require_once 'connection.php';

// Get the current user's ID
$current_user_id = $_SESSION["userid"];

// Query to retrieve the user's transactions
$query = "SELECT t.transactionid, g.title, u.username, t.purchasedate, t.amountpaid, t.paymentmethod
           FROM \"Transaction\" t
           JOIN game g ON t.gameid = g.gameid
           JOIN \"User\" u ON t.userid = u.userid
           WHERE t.userid = $current_user_id";

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
    <title>My Transactions</title>
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
<body class="bg-dark">
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
            <a class="nav-link" href="transaction.php">Transactions</a>
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
  <div class="jumbotron bg-dark mt-5">
  <div class="container"><h1 class="text-light">My Transactions</h1></div>
  </div>
    <div class="container d-flex justify-content-left">
      <div class="d-inline-flex  bg-secondary text-light p-3 rounded-4">
        <table class="table table-striped table-borderless table-dark">
          <tr>
            <th>Game Title</th>
            <th>Purchase Date</th>
            <th>Amount Paid</th>
            <th>Payment Method</th>
          </tr>
          <?php while ($row = pg_fetch_assoc($result)) {?>
          <tr>
            <td><?= $row['title']?></td>
            <td><?= $row['purchasedate']?></td>
            <td><?= $row['amountpaid']?></td>
            <td><?= $row['paymentmethod']?></td>
          </tr>
          <?php }?>
        </table>
      </div>
    </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>
</html>

<?php
// Close the database connection
pg_close($conn);
?>