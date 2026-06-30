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
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
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
    <button><a class="link" href="customers.php">Back</a></button>
    <table width = "600">
        <tr>
            <th>Name</th>
            <th>CusID</th>
            <th>Email</th>
            <th>Password</th>
            <th>Phone</th>
        </tr>
        <tr>
            <form action="insertcustomers.php" method="POST">
                <td><input type="text" name="Name"></td>
                <td><input type="text" name="customersID"></td>
                <td><input type="text" name="Email"></td>
                <td><input type="text" name="Password"></td>
                <td><input type="text" name="Phone"></td>
                <td><input type="submit" value="add"></td>
            </form>
        </tr>
</body>
</html>
