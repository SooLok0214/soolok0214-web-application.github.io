<?php
$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die('Connection failed: ' . mysqli_connect_error());
}

if (empty($_POST["ISBN"]) || empty($_POST["title"]) || empty($_POST["author"]) || empty($_POST["description"]) || empty($_POST["price"])) {

  header("Location: addbook.php?error=Please fill in all fields.");
  exit();
} else if (!is_numeric($_POST["price"])) {

  header("Location: addbook.php?error=Price must be a number.");
  exit();
} else if (!is_numeric($_POST["ISBN"])) {

  header("Location: addbook.php?error=ISBN must be a number.");
  exit();
} else if (strlen($_POST["ISBN"]) != 13) {

  header("Location: addbook.php?error=ISBN must be 13 digits.");
  exit();
}

$sql = "INSERT INTO booklist (ISBN, title, author, description, price) VALUES ('" . $_POST["ISBN"] . "', '" . $_POST["title"] . "', '" . $_POST["author"] . "', '" . $_POST["description"] . "', '" . $_POST["price"] . "')";

if ($conn->query($sql) === TRUE) {
  header("Location: booklist.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);
