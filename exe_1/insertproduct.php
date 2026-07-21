<?php
$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "Myshop";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die('Connection failed: ' . mysqli_connect_error());
}

if (empty($_POST["ProductID"]) || empty($_POST["ProductName"]) || empty($_POST["Price"])) {

  header("Location: addproduct.php?error=Please fill in all fields.");
  exit();
} else if (!is_numeric($_POST["Price"])) {

  header("Location: addproduct.php?error=Price must be a number.");
  exit();
} else if (!is_numeric($_POST["ProductID"])) {

  header("Location: addproduct.php?error=ProductID must be a number.");
  exit();
} else if (strlen($_POST["ProductID"]) != 4) {

  header("Location: addproduct.php?error=ProductID must be 4 digits.");
  exit();
}


$sql = "INSERT INTO products (ProductID, ProductName, Price) VALUES ('" . $_POST["ProductID"] . "', '" . $_POST["ProductName"] . "', '" . $_POST["Price"] . "')";

if ($conn->query($sql) === TRUE) {
  header("Location: products.php");
  exit();
} else {
  header("Location: addproduct.php?error=" . urlencode("Unable to add product: " . $conn->error));
  exit();
}

mysqli_close($conn);
