<?php
session_start();
require_once 'connection.php';
$query = "SELECT * FROM game";
$result = pg_query($conn, $query);

// Display all games in a table
echo "<table border='1'>";
echo "<tr><th>Title</th><th>Description</th><th>Release Date</th><th>Developer</th><th>Publisher</th><th>Platform</th><th>Price</th><th>Rating</th><th>Review</th></tr>";
while ($row = pg_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>" . $row['title'] . "</td>";
  echo "<td>" . $row['description'] . "</td>";
  echo "<td>" . $row['releasedate'] . "</td>";
  echo "<td>" . $row['developer'] . "</td>";
  echo "<td>" . $row['publisher'] . "</td>";
  echo "<td>" . $row['platform'] . "</td>";
  echo "<td>" . number_format($row['price'], 2, '.', ',') . "</td>"; // Format price with commas
  echo "<td>" . $row['rating'] . "</td>";
  echo "<td>" . $row['review'] . "</td>";
  echo "</tr>";
}
echo "</table>";

if($_SERVER['REQUEST_METHOD']== "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $releasedate = $_POST["releasedate"];
    $developer = $_POST["developer"];
    $publisher = $_POST["publisher"];
    $platform = $_POST["platform"];
    $price = $_POST["price"];
    $rating = $_POST["rating"];
    $review = $_POST["review"];
    
    $query = "INSERT INTO game (title, description, releasedate, developer, publisher, platform, price, rating, review) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9)";
    $result = pg_query_params($conn, $query, array($title, $description, $releasedate, $developer, $publisher, $platform, $price, $rating, $review));
    if ($result) {
        $success = "Account created successfully!";
        header("Location: logout.php"); // Redirect to logout.php
        exit;
    } else {
        $error = "Registration failed";
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <label for="title">title:</label>
        <input type="text" id="title" name="title"><br><br>
        <label for="descrtiption">description:</label>
        <input type="text" id="description" name="description"><br><br>
        <label for="releasedate">releasedate:</label>
        <input type="date" id="releasedate" name="releasedate"><br><br>
        <label for="developer">developer:</label>
        <input type="text" id="developer" name="developer"><br><br>
        <label for="publisher">publisher:</label>
        <input type="text" id="publisher" name="publisher"><br><br>    
        <label for="platform">platform:</label>
        <input type="text" id="platform" name="platform"><br><br>
        <label for="price">price:</label>
        <input type="number" id="price" name="price"><br><br>
        <label for="rating">rating:</label>
        <input type="number" id="rating" name="rating"><br><br>
        <label for="review">review:</label>
        <input type="text" id="review" name="review"><br><br>
        <input type="submit" value="Submit">
    </form>
</head>
<body>
    
</body>
</html>