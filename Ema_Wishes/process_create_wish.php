<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}
function wishError($message)
{
    echo $message;
    echo '<p><a href="create_wish.php">Back</a></p>';
    exit();
}
$conn = mysqli_connect("localhost", "Ema_Wishes", "123123", "ema_wishes");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
$email = mysqli_real_escape_string($conn, $_SESSION["email"]);
$categoryID = $_POST["categoryID"] ?? "";
$wishtext = trim($_POST["wishtext"] ?? "");
$hideUser = isset($_POST["hideUser"]) ? 1 : 0;
if ($categoryID == "" || $wishtext == "") {
    wishError("Please select a category and enter your wish.");
}
if (mb_strlen($wishtext, "UTF-8") > 150) {
    wishError("Wish Text must not exceed 150 characters.");
}
$categoryID = mysqli_real_escape_string($conn, $categoryID);
$wishtext = mysqli_real_escape_string($conn, $wishtext);
$userResult = mysqli_query($conn, "SELECT userID, username, gender FROM users WHERE email = '$email'");
$user = mysqli_fetch_assoc($userResult);
if (!$user) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$userID = mysqli_real_escape_string($conn, $user["userID"]);
$categoryResult = mysqli_query($conn, "SELECT categoryID FROM wishcategories WHERE categoryID = '$categoryID'");
$category = mysqli_fetch_assoc($categoryResult);
if (!$category) {
    wishError("Category is invalid.");
}
$idResult = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(cardID, 2) AS UNSIGNED)) AS largestID FROM wishes");
$largestID = (int) mysqli_fetch_assoc($idResult)["largestID"];
$cardID = "W" . max(1001, $largestID + 1);
$name = mysqli_real_escape_string($conn, ucfirst(str_replace("_", "", $user["username"])));
$gender = mysqli_real_escape_string($conn, $user["gender"]);
$insertSql = "INSERT INTO wishes (userID, categoryID, cardID, wishtext, name, gender, hideUser, wishdate) VALUES ('$userID', '$categoryID', '$cardID', '$wishtext', '$name', '$gender', '$hideUser', NOW())";
if (mysqli_query($conn, $insertSql)) {
    mysqli_query($conn, "UPDATE users SET wishcount = wishcount + 1 WHERE userID = '$userID'");
    mysqli_close($conn);
    header("Location: home.php");
    exit();
}
$error = mysqli_error($conn);
mysqli_close($conn);
wishError("Error adding wish: " . $error);
