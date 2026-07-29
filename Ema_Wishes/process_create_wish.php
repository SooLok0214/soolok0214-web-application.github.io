<?php
session_start();

$servername = "localhost";
$username = "Ema_Wishes";
$password = "123123";
$dbname = "ema_wishes";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION["email"];
$categoryID = $_POST["categoryID"] ?? "";
$wishtext = trim($_POST["wishtext"] ?? "");

if ($categoryID == "" || $wishtext == "") {
    echo "Please select a category and enter your wish.";
    echo '<p><a href="create_wish.php">Back</a></p>';
    exit();
}

$userSql = "SELECT userID, username, gender FROM users WHERE email = ?";
$userStmt = mysqli_prepare($conn, $userSql);
mysqli_stmt_bind_param($userStmt, "s", $email);
mysqli_stmt_execute($userStmt);
$userResult = mysqli_stmt_get_result($userStmt);
$user = mysqli_fetch_assoc($userResult);
mysqli_stmt_close($userStmt);

if (!$user) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$userID = $user["userID"];

$categorySql = "SELECT categoryID FROM wishcategories WHERE categoryID = ?";
$categoryStmt = mysqli_prepare($conn, $categorySql);
mysqli_stmt_bind_param($categoryStmt, "s", $categoryID);
mysqli_stmt_execute($categoryStmt);
$categoryResult = mysqli_stmt_get_result($categoryStmt);
$category = mysqli_fetch_assoc($categoryResult);
mysqli_stmt_close($categoryStmt);

if (!$category) {
    echo "Category is invalid.";
    echo '<p><a href="create_wish.php">Back</a></p>';
    exit();
}

$idSql = "SELECT MAX(CAST(SUBSTRING(cardID, 2) AS UNSIGNED)) AS largestID FROM wishes";
$idResult = mysqli_query($conn, $idSql);
$idRow = mysqli_fetch_assoc($idResult);
$nextNumber = (int) $idRow["largestID"] + 1;

if ($nextNumber < 1001) {
    $nextNumber = 1001;
}

$cardID = "W" . $nextNumber;
$name = ucfirst(str_replace("_", "", $user["username"]));
$gender = $user["gender"];

$insertSql = "INSERT INTO wishes
              (userID, categoryID, cardID, wishtext, name, gender, wishdate)
              VALUES (?, ?, ?, ?, ?, ?, NOW())";
$insertStmt = mysqli_prepare($conn, $insertSql);
mysqli_stmt_bind_param(
    $insertStmt,
    "ssssss",
    $userID,
    $categoryID,
    $cardID,
    $wishtext,
    $name,
    $gender
);

if (mysqli_stmt_execute($insertStmt)) {
    $countSql = "UPDATE users
                 SET wishcount = wishcount + 1
                 WHERE userID = ?";
    $countStmt = mysqli_prepare($conn, $countSql);
    mysqli_stmt_bind_param($countStmt, "s", $userID);
    mysqli_stmt_execute($countStmt);
    mysqli_stmt_close($countStmt);

    header("Location: home.php");
    exit();
} else {
    echo "Error adding wish: " . mysqli_error($conn);
    echo '<p><a href="create_wish.php">Back</a></p>';
}

mysqli_stmt_close($insertStmt);
mysqli_close($conn);
?>
