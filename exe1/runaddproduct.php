<?php
    $servername = "localhost";
    $username = "myshop";
    $password = "Shop123";
    $dbname = "myshop";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    $ProductName = $_POST["ProductName"];
    $ProductID = $_POST["ProductID"];
    $Price = $_POST["Price"];

    $sql = "INSERT INTO products (ProductName, ProductID, Price) VALUES ('$ProductName', '$ProductID', '$Price')";

    if (mysqli_query($conn, $sql)) {
        header("Location: products.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>


