<?php
session_start();
$servername = "localhost";
$username = "myshop";
$password = "Shop123";
$dbname = "myshop";

if (isset($_POST["Email"]) && isset($_POST["Password"])) {
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $query = "SELECT * FROM customers WHERE Email='" . $_POST["Email"] . "' && Password='" . $_POST["Password"] . "'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
      $_SESSION["Email"] = $_POST["Email"];
      header("Location: products.php");
  } else {
      echo "Invalid email or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
  <form action="index.php" method="POST">
    <div id="email">
        <h2>Enter Your Email:</h2>
        <input type="text" name="Email">
    </div>
    <div id="password">
        <h2>Password:</h2>
        <input type="password" name="Password">
    </div>
    <input type="submit" value="Login">
  </form>
</body>
</html>


