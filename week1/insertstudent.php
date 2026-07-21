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

if (empty($_POST["name"]) || empty($_POST["studentID"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["yearjoin"])) {

  header("Location: addstudent.php?error=Please fill in all fields.");
  exit();
} else if (!is_numeric($_POST["yearjoin"])) {

  header("Location: addstudent.php?error=Year of join must be a number.");
  exit();
}

$sql = "INSERT INTO student (name, studentID, email, password, yearjoin) VALUES ('" . $_POST["name"] . "', '" . $_POST["studentID"] . "', '" . $_POST["email"] . "', '" . $_POST["password"] . "', '" . $_POST["yearjoin"] . "')";

if ($conn->query($sql) === TRUE) {
  header("Location: student.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);
