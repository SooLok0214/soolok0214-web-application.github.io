<?php
$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";
$conn = new mysqli($servername, $username, $password, $dbname);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
</head>
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

<body>
    <table width="1100">
        <tr>
            <th width="300">Name</th>
            <th width="200">Email</th>
            <th>Age</th>
            <th>Student ID</th>
        </tr>
        <?php

        $query = "SELECT * FROM student";

        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['age']; ?></td>
                <td><?php echo $row['studentID']; ?></td>
                <td>
                    <button><a href="deleteuser.php?studentID=<?php echo ($row['studentID']); ?>"
                            onclick="return confirmdelete()">
                            Delete
                        </a></button>
                    <script>
                        function confirmdelete() {
                            return confirm('do you want to delete this user(<?php echo $row['studentID']; ?>)?');
                        }
                    </script>
                </td>
            </tr>
        <?php
        }
        mysqli_close($conn);
        ?>

        <a href="addstudent.php"><input type="submit" value="add student"></a>
    </table>
</body>

</html>