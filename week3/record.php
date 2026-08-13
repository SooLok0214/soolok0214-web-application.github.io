<?php

session_start();

$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get current student ID
$studentID = $_SESSION["studentID"];

// Only get current student's record
$sql = "SELECT game_record.*, student.name
        FROM game_record
        INNER JOIN student
        ON game_record.studentID = student.studentID
        WHERE game_record.studentID = '$studentID'";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Game Record</title>

    <style>
        table {
            border-collapse: collapse;
            width: 800px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
    </style>

</head>

<body>

    <h2>Game Record</h2>

    <table>

        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Game 1</th>
            <th>Game 2</th>
            <th>Game 3</th>
        </tr>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>

            <tr>

                <td><?php echo $row["studentID"]; ?></td>

                <td><?php echo $row["name"]; ?></td>

                <td><?php echo $row["game1"]; ?></td>

                <td><?php echo $row["game2"]; ?></td>

                <td><?php echo $row["game3"]; ?></td>

            </tr>

        <?php
        }
        ?>

    </table>

    <br>

    <button onclick="window.location.href='gamelist.php'">
        Back
    </button>

</body>

</html>

<?php

mysqli_close($conn);

?>