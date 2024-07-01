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
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the payment method selection
    $paymentmethod = $_POST["paymentmethod"];
    $result = pg_query($conn, "SELECT price FROM game WHERE gameid=$gameid");
    $amountpaid = pg_fetch_result($result, 0, 0);
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
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?gameid=<?php echo $gameid; ?>" method="post">
      <h2>Payment Method</h2>
      <p>Please select a payment method:</p>
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
      <input type="submit" value="Proceed to Payment">
    </form>
</body>
</html>
