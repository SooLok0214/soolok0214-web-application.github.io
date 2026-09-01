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

require_once "generatecode.php";
$ProductID = $_POST["ProductID"] ?? generateUniqueCode();

if (!preg_match('/^\d{14}_[A-Z1-9]{6}$/', $ProductID)) {
  $ProductID = generateUniqueCode();
}

if (empty($_POST["ProductName"]) || empty($_POST["Price"])) {

  header("Location: addproduct.php?error=Please fill in all fields.");
  exit();
} else if (!is_numeric($_POST["Price"])) {

  header("Location: addproduct.php?error=Price must be a number.");
  exit();
}


$sql = "INSERT INTO products (ProductID, ProductName, Price) VALUES ('" . $ProductID . "', '" . $_POST["ProductName"] . "', '" . $_POST["Price"] . "')";

if ($conn->query($sql) === TRUE) {
  header("Location: products.php");
  exit();
} else {
  header("Location: addproduct.php?error=" . urlencode("Unable to add product: " . $conn->error));
  exit();
}

mysqli_close($conn);
