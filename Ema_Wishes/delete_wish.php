```php
<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] != "POST" || empty($_POST["cardID"])) {
    header("Location: profile.php?deleteError=1");
    exit();
}
$conn = new mysqli("localhost", "Ema_Wishes", "123123", "ema_wishes");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
$email = $conn->real_escape_string($_SESSION["email"]);
$cardID = $conn->real_escape_string($_POST["cardID"]);
$userResult = $conn->query("SELECT userID FROM users WHERE email = '$email'");
$user = $userResult->fetch_assoc();
if (!$user) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$userID = $conn->real_escape_string($user["userID"]);
$conn->query("DELETE FROM wishes WHERE cardID = '$cardID' AND userID = '$userID'");
$wishDeleted = $conn->affected_rows == 1;
if ($wishDeleted) {
    $conn->query("UPDATE users SET wishcount = (SELECT COUNT(*) FROM wishes WHERE wishes.userID = '$userID') WHERE userID = '$userID'");
}
$conn->close();
header("Location: profile.php?" . ($wishDeleted ? "deleted=1" : "deleteError=1"));
exit();
