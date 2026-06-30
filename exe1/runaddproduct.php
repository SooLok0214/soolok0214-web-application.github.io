<?php
    $servername = "localhost";
    $username = "Myshop";
    $password = "";
    $dbname = "Myshop";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    $ProductID = $_POST["ProductID"];
    $title = $_POST["ProductName"];
    $price = $_POST["Price"];

    $sql = "INSERT INTO products (ProductID, ProductName, Price) VALUES ('$ProductID', '$title', '$price')";

    if (mysqli_query($conn, $sql)) {
        header("Location: products.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
