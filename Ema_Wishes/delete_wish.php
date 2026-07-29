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

$conn = new mysqli(
    "localhost",
    "Ema_Wishes",
    "123123",
    "ema_wishes"
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");


$email = $conn->real_escape_string($_SESSION["email"]);
$cardID = $conn->real_escape_string($_POST["cardID"]);
$userSql = "
    SELECT userID
    FROM users
    WHERE email = '$email'
";
$userResult = $conn->query($userSql);
$user = $userResult->fetch_assoc();
if (!$user) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$userID = $conn->real_escape_string($user["userID"]);
$deleteSql = "
    DELETE FROM wishes
    WHERE cardID = '$cardID'
    AND userID = '$userID'
";
$conn->query($deleteSql);
$wishDeleted = $conn->affected_rows == 1;
if ($wishDeleted) {
    $updateSql = "
        UPDATE users
        SET wishcount = (
            SELECT COUNT(*)
            FROM wishes
            WHERE wishes.userID = '$userID'
        )
        WHERE userID = '$userID'
    ";
    $conn->query($updateSql);
}
$conn->close();
if ($wishDeleted) {
    header("Location: profile.php?deleted=1");
} else {
    header("Location: profile.php?deleteError=1");
}
exit();
?>