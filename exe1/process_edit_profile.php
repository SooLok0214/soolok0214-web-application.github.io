<?php
session_start();

$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "Myshop";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$CusID = $_POST["CusID"];
$new_name = $_POST["Name"];
$new_password = $_POST["Password"];
$confirm_password = $_POST["ConfirmPassword"];
$new_joinyear = $_POST["JoinYear"];
$new_phone = $_POST["Phone"];

if ($new_password !== $confirm_password) {
    header("Location: editprofile.php?error=Passwords do not match");
    exit;
}

$sql = "UPDATE customers SET Name='$new_name', Password='$new_password', JoinYear='$new_joinyear', Phone='$new_phone' WHERE CusID='$CusID'";

if (mysqli_query($conn, $sql)) {
    header("Location: profile.php");
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
