<?php
session_start();
require_once 'connection.php';
// Now you can use the $conn variable to interact with the database
// Get game ID from URL parameter
if (isset($_GET['gameid'])) {
    $gameid = $_GET['gameid'];
} else {
    echo "Error: Game ID is missing"; 
    exit;
}
// Get user ID from session
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
} else {
    echo "Error: User ID is missing";
    exit;
}

// Check if the user already owns the game
$query = "SELECT * FROM \"Library\" WHERE userid = $userid AND gameid = $gameid";
$result = pg_query($conn, $query);

if (pg_num_rows($result) > 0) {
    echo "You already own this game!";
    pg_close($conn);
    exit;
} 

// Retrieve game price from database
$result = pg_query($conn, "SELECT price FROM game WHERE gameid=$gameid");
$gameprice = pg_fetch_result($result, 0, 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the payment method selection
    $paymentmethod = $_POST["paymentmethod"];
    $amountpaid = $gameprice; // Set amount paid to game price
    // Query to add game to library
    $query = "INSERT INTO \"Transaction\" (userid, gameid, purchasedate, amountpaid, paymentmethod) VALUES ($userid, $gameid, NOW(), $amountpaid, '$paymentmethod')";
    pg_query($conn, $query);
    $query = "INSERT INTO \"Library\" (userid, gameid, purchasedate) VALUES ($userid, $gameid, NOW())";
    pg_query($conn, $query);
    
    // Close database connection
    pg_close($conn);
    header('Location: dashboard.php');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

<div class=" jumbotron full-color bg-dark">
<div class="container bg-dark text-light mt-5">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?gameid=<?php echo $gameid; ?>" method="post">
      <h2>Payment Method</h2>
      <p>Please select a payment method:</p>
      <p>Amount to be paid: $<?php echo number_format($gameprice, 2, '.', ','); ?></p>
      <label>
        <input type="radio" name="paymentmethod" value="Credit Card" checked>
        Credit Card
      </label>
      <br>
      <label>
        <input type="radio" name="paymentmethod" value="PayPal">
        PayPal
      </label>
      <br>
      <label>
        <input type="radio" name="paymentmethod" value="Bank Transfer">
        Bank Transfer
      </label>
      <br>
      <input class="btn btn-danger" type="submit" value="Proceed to Payment">
    </form>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>