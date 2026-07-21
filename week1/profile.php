<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

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

$login_email = $_SESSION["email"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
    <table width="800">
        <tr>
            <th>Name</th>
            <th>StudentID</th>
            <th>Email</th>
            <th>YearJoin</th>
        </tr>
        <?php

        $safe_login_email = mysqli_real_escape_string($conn, $login_email);
        $query = "SELECT name, studentID, email, yearjoin FROM student WHERE email='$safe_login_email'";
        $result = mysqli_query($conn, $query) or die("Couldn't execute query");
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <form action="editprofile.php" method="POST">
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['studentID'] ?></td>
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
        mysqli_free_result($result);
        mysqli_close($conn);
        ?>
        <a href="booklist.php">Back</a>
    </table>
</body>

</html>