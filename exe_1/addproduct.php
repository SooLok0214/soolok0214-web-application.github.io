<?php
$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "Myshop";

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
    <title>Add Product</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-width: 480px;
            max-width: 1280px;
            margin: 0 auto;
            padding: 36px 36px 36px 250px;
            background: #fff0f6;
            color: #2b2026;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 220px;
            padding: 24px 16px;
            background: #111111;
            box-shadow: 8px 0 22px rgba(0, 0, 0, 0.24);
        }

        .brand {
            margin-bottom: 24px;
            padding: 16px 10px;
            color: #ff7ab8;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #3a3a3a;
        }

        .sidebar a {
            display: block;
            margin: 8px 0;
            padding: 11px 12px;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .sidebar a:hover {
            background: #ff4f9a;
        }

        .sidebar span {
            display: inline-block;
            width: 26px;
            height: 26px;
            margin-right: 10px;
            border-radius: 5px;
            background: #ff7ab8;
            color: #111111;
            text-align: center;
            line-height: 26px;
        }

        table {
            width: 94%;
            max-width: 980px;
            margin: 28px auto;
            border-collapse: collapse;
            background: #ffffff;
            border: 1px solid #ffc1dc;
            box-shadow: 0 8px 20px rgba(255, 79, 154, 0.13);
        }

        th {
            background: #ffb3d2;
            color: #241018;
        }

        th,
        td {
            border: 1px solid #ffc1dc;
            padding: 12px;
            text-align: left;
            vertical-align: middle;
        }

        tr:hover {
            background: #ffe8f2;
        }

        form {
            margin: 0;
        }

        input,
        textarea {
            width: 100%;
            max-width: 100%;
            padding: 8px;
            border: 1px solid #ffaad0;
            border-radius: 5px;
            background: #ffffff;
            color: #2b2026;
        }

        input[type="submit"],
        button {
            width: auto;
            margin: 4px;
            padding: 9px 14px;
            border: 0;
            border-radius: 5px;
            background: #ff4f9a;
            color: #ffffff;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover,
        button:hover {
            background: #111111;
        }

        a {
            color: #d9367d;
            text-decoration: none;
        }

        button a {
            color: #ffffff;
        }

        .warning {
            width: 94%;
            max-width: 980px;
            margin: -14px auto 28px;
            padding: 12px 14px;
            border: 1px solid #ff8fbe;
            border-radius: 5px;
            background: #ffe3ef;
            color: #a31655;
            text-align: center;
            font-weight: bold;
        }
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
    <form action="products.php" method="GET">
        <button type="submit">Back</button>
    </form>
    <table width="600">
        <tr>
            <th>ProductID</th>
            <th>ProductName</th>
            <th>Price</th>
        </tr>
        <tr>
            <form action="insertproduct.php" method="POST">
                <td><input type="text" name="ProductID"></td>
                <td><input type="text" name="ProductName"></td>
                <td><input type="text" name="Price"></td>
                <td><input type="submit" value="add"></td>
            </form>
        </tr>
    </table>

    <?php if (isset($_GET["error"])) { ?>
        <div class="warning"><?php echo htmlspecialchars($_GET["error"]); ?></div>
    <?php } ?>
</body>

</html>
