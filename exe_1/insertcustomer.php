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

if (empty($_POST["CusID"]) || empty($_POST["Name"]) || empty($_POST["Email"]) || empty($_POST["Password"]) || empty($_POST["JoinYear"]) || empty($_POST["Phone"])) {

  header("Location: addcustomer.php?error=Please fill in all fields.");
  exit();
} else if (!is_numeric($_POST["CusID"])) {

  header("Location: addcustomer.php?error=CusID must be a number.");
  exit();
} else if (!is_numeric($_POST["Password"])) {

  header("Location: addcustomer.php?error=Password must be a number.");
  exit();
} else if (!is_numeric($_POST["Phone"])) {

  header("Location: addcustomer.php?error=Phone must be a number.");
  exit();
} else if (!is_numeric($_POST["JoinYear"])) {

  header("Location: addcustomer.php?error=JoinYear must be a number.");
  exit();
} else if (strlen($_POST["CusID"]) != 4) {

  header("Location: addcustomer.php?error=CusID must be 4 digits.");
  exit();
}

$sql = "INSERT INTO customers (Name, CusID, Email, Password, JoinYear, Phone) VALUES ('" . $_POST["Name"] . "', '" . $_POST["CusID"] . "', '" . $_POST["Email"] . "', '" . $_POST["Password"] . "', '" . $_POST["JoinYear"] . "', '" . $_POST["Phone"] . "')";

if ($conn->query($sql) === TRUE) {
  header("Location: customers.php");
  exit();
} else {
  header("Location: addcustomer.php?error=" . urlencode("Unable to add customer: " . $conn->error));
  exit();
}

mysqli_close($conn);
