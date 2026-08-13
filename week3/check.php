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

$game = $_POST["game"];
$number = $_POST["number"];

$studentID = $_SESSION["studentID"];


// Check student record
$check = "SELECT * FROM game_record
          WHERE studentID = '$studentID'";

$result = mysqli_query($conn, $check);


// Create record if not exist
if (mysqli_num_rows($result) == 0) {

    $sql = "INSERT INTO game_record (studentID)
            VALUES ('$studentID')";

    mysqli_query($conn, $sql);
}


// Get record
$result = mysqli_query($conn, $check);

$row = mysqli_fetch_assoc($result);


// Check update count
if ($game >= 1 && $game <= 3) {

    $count = $row["game" . $game . "_count"];

    if ($count < 2) {

        $sql = "UPDATE game_record
                SET game$game = '$number',
                    game{$game}_count = game{$game}_count + 1
                WHERE studentID = '$studentID'";

        mysqli_query($conn, $sql);

        mysqli_close($conn);

        header("Location: gamelist.php");
        exit();
    } else {

        mysqli_close($conn);

        header("Location: game.php?game=$game&limit=1");
        exit();
    }
}
