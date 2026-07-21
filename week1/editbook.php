<?php
$ISBN = $_POST["ISBN"] ?? "";

if ($ISBN === "") {
    header("Location: booklist.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
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
    <button><a href="booklist.php">Back</a></button>
    <form action="process_edit_book.php" method="POST">
        <input type="hidden" name="ISBN" value="<?php echo $ISBN; ?>">
        <table width="600">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
            <tr>
                <td><input type="text" name="title" required></td>
                <td><input type="text" name="author" required></td>
                <td><input type="text" name="description" required></td>
                <td><input type="text" name="price" required></td>
                <td><input type="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
</body>
</html>

