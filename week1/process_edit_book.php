<?php
$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$ISBN = $_POST["ISBN"];
$new_title = $_POST["title"];
$new_author = $_POST["author"];
$new_description = $_POST["description"];
$new_price = $_POST["price"];

$sql = "UPDATE booklist SET title='$new_title', author='$new_author', description='$new_description', price='$new_price' WHERE ISBN='$ISBN'";

if (mysqli_query($conn, $sql)) {
    header("Location: booklist.php");
    exit;
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>