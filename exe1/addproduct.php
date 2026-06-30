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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        table{
            border-collapse: collapse;
        }

        table,
        th,
        td
        {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <button><a class="link" href="products.php">Back</a></button>
    <table width = "600">
        <tr>
            <th>ProductID</th>
            <th>ProductName</th>
            <th>Author</th>
            <th>Description</th>
            <th>Price</th>
        </tr>
        <tr>
            <form action="insertproduct.php" method="POST">
                <td><input type="text" name="ProductID" required></td>
                <td><input type="text" name="ProductName" required></td>
                <td><input type="text" name="author" required></td>
                <td><textarea cols="50" rows="4" name="description" required></textarea></td>
                <td><input type="text" name="Price" required></td>
                <td><input type="submit" value="add"></td>
            </form>
        </tr>
</body>
</html>
