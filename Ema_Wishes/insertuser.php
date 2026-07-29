<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: register.php");
    exit();
}

if (
    empty($_POST["username"]) ||
    empty($_POST["email"]) ||
    empty($_POST["password"]) ||
    empty($_POST["confirm_password"]) ||
    empty($_POST["phonenumber"]) ||
    empty($_POST["gender"])
) {
    header("Location: register.php?error=" . urlencode("Please fill in all fields."));
    exit();
}

$username = $_POST["username"];
$email = $_POST["email"];
$userpassword = $_POST["password"];
$confirmPassword = $_POST["confirm_password"];
$phonenumber = $_POST["phonenumber"];
$gender = $_POST["gender"];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: register.php?error=" . urlencode("Email format is incorrect."));
    exit();
}
if (strlen($userpassword) < 6) {
    header("Location: register.php?error=" . urlencode("Password must be at least 6 characters."));
    exit();
}
if ($userpassword != $confirmPassword) {
    header("Location: register.php?error=" . urlencode("Passwords do not match."));
    exit();
}
if ($gender != "male" && $gender != "female") {
    header("Location: register.php?error=" . urlencode("Please select your gender."));
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

$username = mysqli_real_escape_string($conn, $username);
$email = mysqli_real_escape_string($conn, $email);
$userpassword = mysqli_real_escape_string($conn, $userpassword);
$phonenumber = mysqli_real_escape_string($conn, $phonenumber);
$gender = mysqli_real_escape_string($conn, $gender);

$checkSql = "
    SELECT userID
    FROM users
    WHERE username = '$username'
    OR email = '$email'
";
$checkResult = mysqli_query($conn, $checkSql);
if (mysqli_num_rows($checkResult) > 0) {
    mysqli_close($conn);
    header(
        "Location: register.php?error=" .
            urlencode("Username or Email already exists.")
    );
    exit();
}

$idSql = "
    SELECT MAX(
        CAST(SUBSTRING(userID, 2) AS UNSIGNED)
    ) AS largestID
    FROM users
";
$idResult = mysqli_query($conn, $idSql);
$idRow = mysqli_fetch_assoc($idResult);
$nextNumber = (int) $idRow["largestID"] + 1;

if ($nextNumber < 1001) {
    $nextNumber = 1001;
}
$newUserID = "U" . $nextNumber;

$sql = "
    INSERT INTO users
    (
        username,
        email,
        password,
        phonenumber,
        gender,
        userID,
        created_time
    )
    VALUES
    (
        '$username',
        '$email',
        '$userpassword',
        '$phonenumber',
        '$gender',
        '$newUserID',
        NOW()
    )
";
if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header("Location: index.php");
    exit();
} else {
    mysqli_close($conn);
    header(
        "Location: register.php?error=" .
            urlencode("Unable to create account. Please try again.")
    );
    exit();
}
