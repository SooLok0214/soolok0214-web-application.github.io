<?php
$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "myshop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST["OrderID"])) {
    header("Location: orders.php");
    exit();
}

$OrderID = $_POST["OrderID"];
$sql = "DELETE FROM orders WHERE OrderID='$OrderID'";

if ($conn->query($sql) === TRUE) {
    header("Location: orders.php");
    exit();
}

echo "Error deleting order: " . $conn->error;
$conn->close();
?>
