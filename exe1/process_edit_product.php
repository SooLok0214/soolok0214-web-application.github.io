<?php
$servername = "localhost";
$username = "myshop";
$password = "Shop123";
$dbname = "myshop";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$ProductID = $_POST["ProductID"];
$new_title = $_POST["ProductName"];
$new_author = $_POST["author"];
$new_description = $_POST["description"];
$new_price = $_POST["Price"];

$sql = "UPDATE products SET ProductName='$new_title', author='$new_author', description='$new_description', Price='$new_price' WHERE ProductID='$ProductID'";

if (mysqli_query($conn, $sql)) {
    header("Location: products.php");
    exit;
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
