<?php
$CusID = $_POST['CusID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <button><a href="profile.php">Back</a></button>
    <form action="process_edit_profile.php" method="POST">
        <input type="hidden" name="CusID" value="<?php echo $CusID; ?>">
        <table width="600">
            <tr>
                <th>Name</th>
                <th>Password</th>
                <th>Confirm Password</th>
                <th>Phone</th>
            </tr>
            <tr>
                <td><input type="text" name="Name" required></td>
                <td><input type="password" name="Password"></td>
                <td><input type="password" name="ConfirmPassword"></td>
                <td><input type="text" name="Phone" required></td>
                <td><input type="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
</body>
</html>
