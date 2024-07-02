<?php
session_start();
if (isset($_SESSION["userid"])) {
    unset($error); // Unset the $error variable if user is already logged in
}

require_once 'connection.php';

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
        if ($username == 'admin' && $password == '12345') {
            // Admin login, redirect to admin.php
            $_SESSION["userid"] = $user_data["userid"];
            header("Location: admin.php");
            exit;
        } else {
            // Regular user login, redirect to dashboard.php
            $_SESSION["userid"] = $user_data["userid"];
            header("Location: dashboard.php");
            exit;
        }
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!-- Login form in HTML -->
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="jumbotron vertical-center bg-dark">
        <div class="container d-flex justify-content-center ">
            <div class="d-inline-flex  bg-secondary text-light p-3 rounded-4">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <h1>Login</h1>
                <!-- <div class="col-6"> -->
                <label for="username" class="form-label" >Username:</label>
                <input type="text" class="form-control" id="username" name="username"><br><br>
                <!-- </div> -->
                <!-- <div class="col-6"> -->
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password"><br><br>
                <input class="btn btn-danger" type="submit" value="Login">
                <!-- </div> -->
                <?php if (isset($error)):?>
                <p style="color: red;"><?php echo $error;?></p>
                <?php endif;?>

                <p>Don't have an account? <a class="btn btn-danger" href="register.php">Create one now!</a></p>
            </form>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>