<?php
session_start();
if (!isset($_SESSION["email"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit();
}
$conn = new mysqli("localhost", "Ema_Wishes", "123123", "ema_wishes");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
$email = $conn->real_escape_string($_SESSION["email"]);
$user = $conn->query("SELECT userID, profileimage FROM users WHERE email = '$email'")->fetch_assoc();
if (!$user) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$userID = $conn->real_escape_string($user["userID"]);
$conn->begin_transaction();
try {
    $conn->query("DELETE FROM wishes WHERE userID = '$userID'");
    $conn->query("DELETE FROM users WHERE userID = '$userID'");
    if ($conn->affected_rows != 1) {
        throw new Exception("Account was not deleted.");
    }
    $conn->commit();
} catch (Throwable $error) {
    $conn->rollback();
    $conn->close();
    header("Location: update_profile.php?deleteError=1");
    exit();
}
$profileImage = $user["profileimage"] ?? "";
if ($profileImage != "" && basename($profileImage) == $profileImage) {
    $profileImagePath = __DIR__ . "/uploads/" . $profileImage;
    if (is_file($profileImagePath)) {
        unlink($profileImagePath);
    }
}
$conn->close();
session_unset();
session_destroy();
header("Location: index.php?accountDeleted=1");
exit();
