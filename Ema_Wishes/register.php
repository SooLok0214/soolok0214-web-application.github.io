<?php
$servername = "localhost";
$username = "Ema_Wishes";
$password = "123123";
$dbname = "ema_wishes";

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
    <title>Register</title>
    <link rel="stylesheet" href="css/common.css">
</head>

<body>
    <button><a href="index.php">Back</a></button>

    <h2>Register New Account</h2>

    <form action="insertuser.php" method="POST">
        <table>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" required></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" name="email" required></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" required minlength="6"></td>
            </tr>
            <tr>
                <td>Confirm Password</td>
                <td><input type="password" name="confirm_password" required minlength="6"></td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td><input type="text" name="phonenumber" required></td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>
                    <select name="gender" required>
                        <option value="">Please select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Register"></td>
            </tr>
        </table>
    </form>
</body>

</html>
