<?php

session_start();

date_default_timezone_set('Asia/Kuala_Lumpur');

$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];
$age = $_POST["age"];

// Generate Student ID
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
$code = '';

for ($i = 0; $i < 6; $i++) {
    $code .= $characters[random_int(0, strlen($characters) - 1)];
}

$studentID = date('YmdHis') . "_" . $code;

$yearjoin = date("Y");

$sql = "INSERT INTO student
        (name, studentID, email, password, yearjoin, age)
        VALUES
        ('$name', '$studentID', '$email', '$password', '$yearjoin', '$age')";

if (mysqli_query($conn, $sql)) {

    $_SESSION["studentID"] = $studentID;
    $_SESSION["name"] = $name;

    header("Location: gamelist.php");
    exit();
}

mysqli_close($conn);
