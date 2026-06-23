<?php
    $servername = "localhost";
    $username = "soolok";
    $password = "Rabbit5354";
    $dbname = "soolok";

    // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
    session_start();

    $login_email = $_SESSION["email"];
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

        $query = "SELECT * FROM student WHERE email = '$login_email'";
        $result = mysqli_query($conn, $query) or die("Couldn't execute query");
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <form action="editprofile.php" method="POST">
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['yearjoin'] ?></td>
                <td>
                    <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
                    <input type="submit" value="Edit">
                </td>
            </form>
        </tr>
    <?php 
}
mysqli_close($conn);
?>
<a href="booklist.php"><input type="submit" value="Back"></a>
    </table>
</body>
</html>