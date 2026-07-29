<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$conn = mysqli_connect(
    "localhost",
    "Ema_Wishes",
    "123123",
    "ema_wishes"
);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");

$email = $_SESSION["email"];
$categoryID = $_POST["categoryID"] ?? "";
$wishtext = trim($_POST["wishtext"] ?? "");
$hideUser = isset($_POST["hideUser"]) ? 1 : 0;

if ($categoryID == "" || $wishtext == "") {
    echo "Please select a category and enter your wish.";
    echo '<p><a href="create_wish.php">Back</a></p>';
    exit();
}

$email = mysqli_real_escape_string($conn, $email);
$categoryID = mysqli_real_escape_string($conn, $categoryID);
$wishtext = mysqli_real_escape_string($conn, $wishtext);

$userSql = "
    SELECT userID, username, gender
    FROM users
    WHERE email = '$email'
";
$userResult = mysqli_query($conn, $userSql);
$user = mysqli_fetch_assoc($userResult);

if (!$user) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$userID = mysqli_real_escape_string($conn, $user["userID"]);

$categorySql = "
    SELECT categoryID
    FROM wishcategories
    WHERE categoryID = '$categoryID'
";
$categoryResult = mysqli_query($conn, $categorySql);
$category = mysqli_fetch_assoc($categoryResult);

if (!$category) {
    echo "Category is invalid.";
    echo '<p><a href="create_wish.php">Back</a></p>';
    exit();
}
$idSql = "
    SELECT MAX(
        CAST(SUBSTRING(cardID, 2) AS UNSIGNED)
    ) AS largestID
    FROM wishes
";

$idResult = mysqli_query($conn, $idSql);
$idRow = mysqli_fetch_assoc($idResult);
$nextNumber = (int) $idRow["largestID"] + 1;
if ($nextNumber < 1001) {
    $nextNumber = 1001;
}
$cardID = "W" . $nextNumber;

$name = ucfirst(str_replace("_", "", $user["username"]));
$gender = $user["gender"];
$name = mysqli_real_escape_string($conn, $name);
$gender = mysqli_real_escape_string($conn, $gender);

$insertSql = "
    INSERT INTO wishes
    (
        userID,
        categoryID,
        cardID,
        wishtext,
        name,
        gender,
        hideUser,
        wishdate
    )
    VALUES
    (
        '$userID',
        '$categoryID',
        '$cardID',
        '$wishtext',
        '$name',
        '$gender',
        '$hideUser',
        NOW()
    )
";
if (mysqli_query($conn, $insertSql)) {

    $countSql = "
        UPDATE users
        SET wishcount = wishcount + 1
        WHERE userID = '$userID'
    ";
    mysqli_query($conn, $countSql);
    mysqli_close($conn);
    header("Location: home.php");
    exit();
} else {
    echo "Error adding wish: " . mysqli_error($conn);
    echo '<p><a href="create_wish.php">Back</a></p>';
}
mysqli_close($conn);
