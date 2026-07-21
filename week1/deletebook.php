<?php
$ISBN = $_GET["ISBN"] ?? "";

if ($ISBN === "") {
    header("Location: booklist.php");
    exit();
}

$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ISBN = mysqli_real_escape_string($conn, $ISBN);
$sql = "DELETE FROM booklist WHERE ISBN='$ISBN'";

if ($conn->query($sql) === TRUE) {
    header("Location: booklist.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
