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
    <title>Profile</title>
  <style>
        table{
            border-collapse: collapse;
        }
        table,
        th,
        td{
            border: 1px solid black;
        }   
      </style>
</head>
<body>
    <table width="800">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>YearJoin</th>
        </tr>
        <?php

        $query = "SELECT * FROM student";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['email'] ?></td>
            <td><?php echo $row['yearjoin'] ?></td>
            <td><input type="button" value="Edit"></td>
        </tr>
    <?php 
}
mysqli_close($conn);
?>
<a href="booklist.php"><input type="submit" value="Back"></a>
    </table>
</body>
</html>