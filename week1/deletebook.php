<?php
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

// SQL to delete a record
$sql = "DELETE FROM booklist WHERE ISBN='" . $_GET["ISBN"] . "'";

if ($conn->query($sql) === TRUE) {
    header("Location: booklist.php");
}

$conn->close();
