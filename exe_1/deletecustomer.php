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

if (!isset($_POST["CusID"])) {
    header("Location: customers.php");
    exit();
}

$CusID = $_POST["CusID"];

// SQL to delete the selected record
$sql = "DELETE FROM customers WHERE CusID='" . $CusID . "'";

if ($conn->query($sql) === TRUE) {
    header("Location: customers.php");
    exit();
} else {
    echo "Error deleting customer: " . $conn->error;
}

$conn->close();
?>
