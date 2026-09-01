<?php
session_start();

$target_email = $_POST["Email"] ?? $_SESSION["Email"];

$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "Myshop";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$new_name = trim($_POST["Name"] ?? "");
$new_password = trim($_POST["Password"] ?? "");
$confirm_password = trim($_POST["ConfirmPassword"] ?? "");
$new_JoinYear = trim($_POST["JoinYear"] ?? "");
$new_phone = trim($_POST["Phone"] ?? "");
$messages = [];

if ($new_name == "") {
    $messages[] = "Please enter the customer name.";
}

if ($new_password == "") {
    $messages[] = "Please enter the password.";
} else if (strlen($new_password) < 6) {
    $messages[] = "Password must contain at least 6 characters.";
}

if ($confirm_password == "") {
    $messages[] = "Please confirm the password.";
} else if ($new_password != "" && $new_password !== $confirm_password) {
    $messages[] = "Passwords do not match.";
}

if ($new_JoinYear == "") {
    $messages[] = "Please enter the join year.";
} else if (!is_numeric($new_JoinYear) || $new_JoinYear < 1900 || $new_JoinYear > date("Y")) {
    $messages[] = "Please enter a valid join year.";
}

if ($new_phone == "") {
    $messages[] = "Please enter the phone number.";
}

if (count($messages) > 0) {
    $parameters = [
        "Email" => $target_email,
        "Name" => $new_name,
        "JoinYear" => $new_JoinYear,
        "Phone" => $new_phone,
        "error" => $messages
    ];
    header("Location: editprofile.php?" . http_build_query($parameters));
    exit();
}

$target_email = mysqli_real_escape_string($conn, $target_email);
$new_name = mysqli_real_escape_string($conn, $new_name);
$new_password = mysqli_real_escape_string($conn, $new_password);
$new_JoinYear = mysqli_real_escape_string($conn, $new_JoinYear);
$new_phone = mysqli_real_escape_string($conn, $new_phone);

$sql = "UPDATE customers SET Name='$new_name', Password='$new_password', JoinYear='$new_JoinYear', Phone='$new_phone' WHERE Email='$target_email'";

if (mysqli_query($conn, $sql)) {
    header("Location: profile.php");
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
