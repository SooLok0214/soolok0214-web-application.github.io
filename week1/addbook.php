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

$error = $_GET["error"] ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
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
    <button><a class="link" href="booklist.php">Back</a></button>
    <?php if ($error !== "") { ?>
        <p style="color: red;"><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></p>
    <?php } ?>
    <table width="600">
        <tr>
            <th>ISBN</th>
            <th>Title</th>
            <th>Author</th>
            <th>Description</th>
            <th>Price</th>
        </tr>
        <tr>
            <form action="insertbook.php" method="POST">
                <td><input type="text" name="ISBN"></td>
                <td><input type="text" name="title"></td>
                <td><input type="text" name="author"></td>
                <td><textarea cols="50" rows="4" name="description"></textarea></td>
                <td><input type="text" name="price"></td>
                <td><input type="submit" value="add"></td>
            </form>
        </tr>
</body>

</html>