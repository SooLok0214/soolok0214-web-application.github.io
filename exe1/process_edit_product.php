<?php
$servername = "localhost";
$username = "myshop";
$password = "Shop123";
$dbname = "myshop";

$conn = new mysqli($servername, $username, $password, $dbname);

$ProductID = $_POST["ProductID"];
$new_ProductName = $_POST["ProductName"];
$new_Price = $_POST["Price"];

$sql = "UPDATE products SET ProductName='$new_ProductName', Price='$new_Price' WHERE ProductID='$ProductID'";

if ($conn->query($sql) === TRUE) {
    header("Location: products.php");
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>


