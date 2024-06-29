<?php
session_start();
// Configuration
$db_host = 'localhost';
$db_username = 'postgres';
$db_password = 'stegoceratops745';
$db_name = 'postgres';

// Create a connection to the database
$conn = pg_connect("host=$db_host port=5432 dbname=$db_name user=$db_username password=$db_password");

// Check connection
if (!$conn) {
    die("Connection failed: ". pg_last_error());
}

// Login form submission handler
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query to retrieve user data
    $query = "SELECT * FROM \"User\" WHERE username = '$username' AND \"Password\" = '$password'";
    $result = pg_query($conn, $query);

    // Check if user exists
    if (pg_num_rows($result) > 0) {
        $user_data = pg_fetch_assoc($result);
        // Login successful, redirect to dashboard or whatever
        $_SESSION["userid"] = $user_data["userid"];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!-- Login form in HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
    </form>

    <?php if (isset($error)):?>
        <p style="color: red;"><?php echo $error;?></p>
    <?php endif;?>

    <p>Don't have an account? <a href="register.php">Create one now!</a></p>
</body>
</html>