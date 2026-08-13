<?php
$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "myshop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
if (!isset($_SESSION["Email"])) {
    header("Location: index.php");
    exit();
}

$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY OrderID DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; }
        body { min-width: 480px; max-width: 1280px; margin: 0 auto; padding: 36px 36px 36px 250px; background: #fff0f6; color: #2b2026; }
        .sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: 220px; padding: 24px 16px; background: #111111; box-shadow: 8px 0 22px rgba(0, 0, 0, 0.24); }
        .brand { margin-bottom: 24px; padding: 16px 10px; color: #ff7ab8; font-size: 28px; font-weight: bold; text-align: center; border-bottom: 1px solid #3a3a3a; }
        .sidebar a { display: block; margin: 8px 0; padding: 11px 12px; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .sidebar a:hover { background: #ff4f9a; }
        .sidebar span { display: inline-block; width: 26px; height: 26px; margin-right: 10px; border-radius: 5px; background: #ff7ab8; color: #111111; text-align: center; line-height: 26px; }
        h1 { width: 96%; max-width: 1050px; margin: 20px auto 0; color: #d9367d; }
        .create-button { display: block; width: max-content; margin: 14px auto; padding: 10px 16px; border-radius: 5px; background: #ff4f9a; color: #ffffff; text-decoration: none; font-weight: bold; }
        .create-button:hover { background: #111111; }
        table { width: 96%; max-width: 1050px; margin: 18px auto; border-collapse: collapse; background: #ffffff; border: 1px solid #ffc1dc; box-shadow: 0 8px 20px rgba(255, 79, 154, 0.13); }
        th { background: #ffb3d2; color: #241018; }
        th, td { border: 1px solid #ffc1dc; padding: 10px; text-align: left; vertical-align: middle; }
        tr:hover { background: #ffe8f2; }
        form { margin: 0; }
        button { padding: 9px 14px; border: 0; border-radius: 5px; background: #ff4f9a; color: #ffffff; cursor: pointer; font-weight: bold; }
        button:hover { background: #111111; }
        .empty { text-align: center; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand">MyShop</div>
        <a href="products.php"><span>&#128722;</span>Products</a>
        <a href="addproduct.php"><span>&#43;</span>Add Product</a>
        <a href="customers.php"><span>&#128101;</span>Customers</a>
        <a href="addcustomer.php"><span>&#43;</span>Add Customer</a>
        <a href="orders.php"><span>&#128203;</span>Order List</a>
        <a href="createorder.php"><span>&#43;</span>Create Order</a>
        <a href="profile.php"><span>&#128100;</span>Profile</a>
        <a href="logout.php"><span>&#9211;</span>Logout</a>
    </div>

    <h1>Order List</h1>
    <a class="create-button" href="createorder.php">Create New Order</a>

    <table>
        <tr>
            <th>OrderID</th>
            <th>Customer</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
            <th>Order Date</th>
            <th></th>
            <th></th>
        </tr>
        <?php if (mysqli_num_rows($orders) == 0) { ?>
            <tr><td class="empty" colspan="9">No orders found.</td></tr>
        <?php } ?>
        <?php while ($order = mysqli_fetch_assoc($orders)) { ?>
            <tr>
                <td><?php echo $order["OrderID"]; ?></td>
                <td><?php echo htmlspecialchars($order["CusID"] . " - " . $order["CustomerName"]); ?></td>
                <td><?php echo htmlspecialchars($order["ProductID"] . " - " . $order["ProductName"]); ?></td>
                <td><?php echo $order["Quantity"]; ?></td>
                <td>RM <?php echo number_format($order["UnitPrice"], 2); ?></td>
                <td>RM <?php echo number_format($order["TotalPrice"], 2); ?></td>
                <td><?php echo $order["OrderDate"]; ?></td>
                <td>
                    <form action="editorder.php" method="POST">
                        <input type="hidden" name="OrderID" value="<?php echo $order['OrderID']; ?>">
                        <button type="submit">Edit</button>
                    </form>
                </td>
                <td>
                    <form action="deleteorder.php" method="POST" onsubmit="return confirm('Do you want to delete order <?php echo $order['OrderID']; ?>?');">
                        <input type="hidden" name="OrderID" value="<?php echo $order['OrderID']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
