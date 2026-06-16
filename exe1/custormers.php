<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exercise_1";

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
    <link rel="stylesheet" href="profile-style.css">
</head>
<body>
    <div class="container">
        <h2>Customer Profiles</h2>
        
        <div class="table-card">
            <table>
                <tr>
                    <th>UserName</th>
                    <th>Email</th>
                    <th>Customer ID</th>
                    <th>Phone Number</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
                
                <?php
                $query = "SELECT * FROM customers";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row['UserName'] ?></td>
                    <td><?php echo $row['Email'] ?></td>
                    <td><?php echo $row['CusID'] ?></td>
                    <td><?php echo $row['Phone'] ?></td>
                    <td><?php echo $row['Gender'] ?></td>
                    <td><input type="button" value="Edit" class="btn-edit"></td>
                </tr>
                <?php 
                }
                mysqli_close($conn);
                ?>
            </table>
        </div>

        <div class="action-bar">
            <a href="login.php"><input type="submit" value="Back" class="btn-back"></a>
        </div>
    </div>
</body>
</html>