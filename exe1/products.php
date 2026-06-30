<?php
    $servername = "localhost";
    $username = "myshop";
    $password = "";
    $dbname = "myshop";
$conn = new mysqli($servername, $username, $password, $dbname);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<style>
    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }
</style>

<body>
    <table width="1100">
        <tr>
            <th>ProductID</th>
            <th width="300">ProductName</th>
            <th width="200">Author</th>
            <th>Description</th>
            <th>Price(RM)</th>
        </tr>
        <?php

        $query = "SELECT * FROM products";

        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['ProductID']; ?></td>
                <td><?php echo $row['ProductName']; ?></td>
                <td><?php echo $row['author']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['Price']; ?></td>
                <td>
                    <form action="editproduct.php" method="post">
                        <input type="hidden" name="ProductID" value="<?php echo $row['ProductID']; ?>">
                        <input type="submit" value="Edit">
                    </form>
                </td>
                <td><a href="deleteproduct.php? ProductID=<?php echo $row['ProductID']; ?>"><button>Delete</button></a></td>
            </tr>
        <?php
        }
        mysqli_close($conn);
        ?>

        <a href="profile.php"><input type="submit" value="Profile"></a>
        <a href="addproduct.php"><input type="submit" value="Add Product"></a>
        <a href="customers.php"><input type="submit" value="All Customers"></a>
        <a href=""><input type="submit" value="Logout"></a>
    </table>

</body>
</html>
