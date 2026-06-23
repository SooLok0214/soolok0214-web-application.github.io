<?php
$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$original_ISBN = trim($_POST["original_ISBN"] ?? '');
$new_ISBN = trim($_POST["ISBN"] ?? '');
$new_title = trim($_POST["title"] ?? '');
$new_author = trim($_POST["author"] ?? '');
$new_description = trim($_POST["description"] ?? '');
$new_price = trim($_POST["price"] ?? '');
    
$new_ISBN = mysqli_real_escape_string($conn, $new_ISBN);
$new_title = mysqli_real_escape_string($conn, $new_title);
$new_author = mysqli_real_escape_string($conn, $new_author);
$new_description = mysqli_real_escape_string($conn, $new_description);
$new_price = mysqli_real_escape_string($conn, $new_price);

$sql = "UPDATE booklist SET ISBN='$new_ISBN', title='$new_title', author='$new_author', description='$new_description', price='$new_price' WHERE ISBN='$original_ISBN'";

if (mysqli_query($conn, $sql)) {
    header("Location: booklist.php");
    exit;
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>