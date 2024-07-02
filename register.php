<?php
session_start();
require_once 'connection.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="jumbotron vertical-center bg-dark">
        <div class="container d-flex justify-content-center ">
            <div class="d-inline-flex  bg-secondary text-light p-3 rounded-4">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                    <h1>Register</h1>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username"><br><br>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password"><br><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email"><br><br>
                    <input class="btn btn-danger" type="submit" value="Register">
                </form>

                <?php if (isset($error)):?>
                    <p style="color: red;"><?php echo $error;?></p>
                <?php endif;?>

                <?php if (isset($success)):?>
                    <p style="color: white;"><?php echo $success;?></p>
                    <p><a class="btn btn-danger" href="login.php">Return to login page</a></p>
                <?php endif;?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>