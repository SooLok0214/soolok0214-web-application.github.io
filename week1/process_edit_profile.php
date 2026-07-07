<?php
session_start();

$login_email = $_SESSION["email"];

$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$new_name = $_POST["name"];
$new_password = $_POST["Password"];
$confirm_password = $_POST["ConfirmPassword"];
$new_yearjoin = $_POST["yearjoin"];

if ($new_password !== $confirm_password) {
    header("Location: editprofile.php?error=password_nomatch");
}

$sql = "UPDATE student SET name='$new_name', password='$new_password', yearjoin='$new_yearjoin' WHERE email='$login_email'";

if (mysqli_query($conn, $sql)) {
    header("Location: profile.php");
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>