<?php
session_start();

$login_email = $_SESSION["Email"];

$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "Myshop";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$new_name = $_POST["Name"];
$new_password = $_POST["Password"];
$confirm_password = $_POST["ConfirmPassword"];
$new_JoinYear = $_POST["JoinYear"];
$new_phone = $_POST["Phone"];

if ($new_password !== $confirm_password) {
    header("Location: editprofile.php?error=Passwords do not match");
    exit;
}

$sql = "UPDATE customers SET Name='$new_name', Password='$new_password', JoinYear='$new_JoinYear', Phone='$new_phone' WHERE Email='$login_email'";

if (mysqli_query($conn, $sql)) {
    header("Location: profile.php");
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>