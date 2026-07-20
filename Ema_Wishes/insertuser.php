<?php
$servername = "localhost";
$dbusername = "Ema_Wishes";
$dbpassword = "123123";
$dbname = "ema_wishes";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: register.php");
    exit();
}

$username = $_POST["username"];
$email = $_POST["email"];
$userpassword = $_POST["password"];
$confirmPassword = $_POST["confirm_password"];
$phonenumber = ($_POST["phonenumber"]);
$gender = $_POST["gender"];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email format is incorrect. <a href='register.php'>Back</a>");
}

if ($userpassword != $confirmPassword) {
    die("Passwords do not match. <a href='register.php'>Back</a>");
}

if ($gender != "male" && $gender != "female") {
    die("Please select your gender. <a href='register.php'>Back</a>");
}

$checkSql = "SELECT userID FROM users WHERE username = ? OR email = ?";
$checkStmt = mysqli_prepare($conn, $checkSql);
mysqli_stmt_bind_param($checkStmt, "ss", $username, $email);
mysqli_stmt_execute($checkStmt);
mysqli_stmt_store_result($checkStmt);

if (mysqli_stmt_num_rows($checkStmt) > 0) {
    mysqli_stmt_close($checkStmt);
    mysqli_close($conn);
    die("Username or Email already exists. <a href='register.php'>Back</a>");
}

mysqli_stmt_close($checkStmt);

$idSql = "SELECT MAX(CAST(SUBSTRING(userID, 2) AS UNSIGNED)) AS largestID FROM users";
$idResult = mysqli_query($conn, $idSql);
$idRow = mysqli_fetch_assoc($idResult);
$nextNumber = (int) $idRow["largestID"] + 1;

if ($nextNumber < 1001) {
    $nextNumber = 1001;
}

$newUserID = "U" . $nextNumber;

$sql = "INSERT INTO users
        (username, email, password, phonenumber, gender, userID, created_time)
        VALUES (?, ?, ?, ?, ?, ?, NOW())";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param(
    $stmt,
    "ssssss",
    $username,
    $email,
    $userpassword,
    $phonenumber,
    $gender,
    $newUserID
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
