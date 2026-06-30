<?php
$ProductID = $_POST['ProductID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        table { border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
    </style>
</head>
<body>
    <button><a href="products.php">Back</a></button>
    <form action="process_edit_product.php" method="POST">
        <input type="hidden" name="ProductID" value="<?php echo $ProductID; ?>">
        <table width="600">
            <tr>
                <th>ProductName</th>
                <th>Price</th>
            </tr>
            <tr>
                <td><input type="text" name="ProductName" required></td>
                <td><input type="text" name="Price" required></td>
                <td><input type="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
</body>
</html>



