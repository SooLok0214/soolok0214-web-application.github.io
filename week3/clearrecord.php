<?php

session_start();

$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$studentID = $_SESSION["studentID"];

$sql = "UPDATE game_record
        SET game1 = NULL,
            game2 = NULL,
            game3 = NULL,
            game1_count = 0,
            game2_count = 0,
            game3_count = 0
        WHERE studentID = '$studentID'";

mysqli_query($conn, $sql);

mysqli_close($conn);

header("Location: record.php");
exit();
