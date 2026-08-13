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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <button><a class="link" href="student.php">Back</a></button>
    <table width="600">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>age</th>
        </tr>
        <tr>
            <form action="insertuser.php" method="POST">
                <td><input type="text" name="name"></td>
                <td><input type="text" name="email"></td>
                <td><input type="text" name="password"></td>
                <td><input type="text" name="age"></td>
                <td><input type="submit" value="add"></td>
            </form>
        </tr>
</body>

</html>