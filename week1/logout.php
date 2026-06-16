<?php
    $servername = "localhost";
    $username = "soolok";
    $password = "Rabbit5354";
    $dbname = "soolok";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }
    ?>