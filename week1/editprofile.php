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
        <table width="600">
            <tr>
                <th>Name</th>
                <th>Password</th>
                <th>Confirm Password</th>
                <th>Year Joined</th>
            </tr>
            <tr>
                <td><input type="text" name="name" required></td>
                <td><input type="password" name="Password"></td>
                <td><input type="password" name="ConfirmPassword"></td>
                <td><input type="text" name="yearjoin" required></td>
                <td><input type="submit" value="Submit"></td>
            </tr>
        </table>
            <?php
                if (isset($_GET['error']) == 'password_nomatch') {
                echo '<p style="color:red;
                                margin: 5px 0;">Passwords do not match.</p>';
                }
            ?>
    </form>
</body>
</html>

