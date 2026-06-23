<?php
session_start();

if (empty($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$login_email = $_SESSION["email"];
$new_name = trim($_POST["name"] ?? '');
$new_password = $_POST["Password"] ?? '';
$confirm_password = $_POST["ConfirmPassword"] ?? '';
$new_yearjoin = trim($_POST["yearjoin"] ?? '');

if ($new_password !== $confirm_password) {
    echo "Passwords do not match. <a href=\"editprofile.php\">Go back</a>";
    mysqli_close($conn);
    exit;
}

$login_email = mysqli_real_escape_string($conn, $login_email);
$new_name = mysqli_real_escape_string($conn, $new_name);
$new_yearjoin = mysqli_real_escape_string($conn, $new_yearjoin);
$new_password = mysqli_real_escape_string($conn, $new_password);

$sql = "UPDATE student SET name='$new_name', password='$new_password', yearjoin='$new_yearjoin' WHERE email='$login_email'";

if (mysqli_query($conn, $sql)) {
    header("Location: profile.php");
    exit;
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>