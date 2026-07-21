<?php
$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "Myshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to delete a record
$sql = "DELETE FROM products WHERE ProductID='" . $_GET["ProductID"] . "'";

if ($conn->query($sql) === TRUE) {
    header("Location: products.php");
}

$conn->close();
