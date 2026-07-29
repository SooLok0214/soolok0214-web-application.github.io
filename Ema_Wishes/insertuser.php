<?php
function registerError($message)
{
    header("Location: register.php?error=" . urlencode($message));
    exit();
}
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: register.php");
    exit();
}
if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["confirm_password"]) || empty($_POST["phonenumber"]) || empty($_POST["gender"])) {
    registerError("Please fill in all fields.");
}
$username = trim($_POST["username"]);
$email = trim($_POST["email"]);
$userpassword = $_POST["password"];
$confirmPassword = $_POST["confirm_password"];
$phonenumber = trim($_POST["phonenumber"]);
$gender = $_POST["gender"];
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    registerError("Email format is incorrect.");
}
if (!preg_match("/^\+?[0-9]+$/", $phonenumber)) {
    registerError("Phone Number can only contain numbers and an optional + at the beginning.");
}
if (strlen($userpassword) < 6) {
    registerError("Password must be at least 6 characters.");
}
if ($userpassword != $confirmPassword) {
    registerError("Passwords do not match.");
}
if ($gender != "male" && $gender != "female") {
    registerError("Please select your gender.");
}
$conn = mysqli_connect("localhost", "Ema_Wishes", "123123", "ema_wishes");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
$username = mysqli_real_escape_string($conn, $username);
$email = mysqli_real_escape_string($conn, $email);
$userpassword = mysqli_real_escape_string($conn, $userpassword);
$phonenumber = mysqli_real_escape_string($conn, $phonenumber);
$gender = mysqli_real_escape_string($conn, $gender);
$checkSql = "SELECT userID FROM users WHERE username = '$username' OR email = '$email'";
$checkResult = mysqli_query($conn, $checkSql);
if (mysqli_num_rows($checkResult) > 0) {
    mysqli_close($conn);
    registerError("Username or Email already exists.");
}
$idResult = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(userID, 2) AS UNSIGNED)) AS largestID FROM users");
$largestID = (int) mysqli_fetch_assoc($idResult)["largestID"];
$newUserID = "U" . max(1001, $largestID + 1);
$sql = "INSERT INTO users (username, email, password, phonenumber, gender, userID, created_time) VALUES ('$username', '$email', '$userpassword', '$phonenumber', '$gender', '$newUserID', NOW())";
if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header("Location: index.php");
    exit();
}
mysqli_close($conn);
registerError("Unable to create account. Please try again.");
