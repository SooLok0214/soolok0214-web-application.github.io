<?php
    $servername = "localhost";
    $username = "myshop";
    $password = "";
    $dbname = "myshop";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    $ProductID = $_POST["ProductID"];
    $title = $_POST["ProductName"];
    $author = $_POST["author"];
    $description = $_POST["description"];
    $price = $_POST["Price"];

    $sql = "INSERT INTO products (ProductID, ProductName, author, description, Price) VALUES ('$ProductID', '$title', '$author', '$description', '$price')";

    if (mysqli_query($conn, $sql)) {
        header("Location: products.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
?>
