<?php
    $servername = "localhost";
    $username = "myshop";
    $password = "Shop123";
    $dbname = "myshop";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }
    ?>



