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

// Registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    // Check if username already exists
    $query = "SELECT 1 FROM \"User\" WHERE username = $1";
    $result = pg_query_params($conn, $query, array($username));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address. Please enter a valid email address.";
    } 
    else if (pg_num_rows($result) > 0) {
        $error = "Username already exists. Please choose a different username.";
    } else {
        // Check if email already exists
        $query = "SELECT 1 FROM \"User\" WHERE email = $1";
        $result = pg_query_params($conn, $query, array($email));
        if (pg_num_rows($result) > 0) {
            $error = "Email already exists. Please use a different email address.";
        } else {
            // Insert user data into database
            $query = "INSERT INTO \"User\" (username, \"Password\", email) VALUES ($1, $2, $3)";
            $result = pg_query_params($conn, $query, array($username, $password, $email));

            // Check if registration was successful
            if ($result) {
                $success = "Account created successfully!";
            } else {
                $error = "Registration failed";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br><br>
        <input type="submit" value="Register">
    </form>

    <?php if (isset($error)):?>
        <p style="color: red;"><?php echo $error;?></p>
    <?php endif;?>

    <?php if (isset($success)):?>
        <p style="color: green;"><?php echo $success;?></p>
        <p><a href="login.php">Return to login page</a></p>
    <?php endif;?>
</body>
</html>