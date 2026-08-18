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

$customers = mysqli_query($conn, "SELECT CusID, Name FROM customers ORDER BY CusID");
$products = mysqli_query($conn, "SELECT ProductID, ProductName, Price FROM products ORDER BY ProductID");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
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

        .order-box {
            width: 94%;
            max-width: 760px;
            margin: 28px auto;
            padding: 24px;
            background: #ffffff;
            border: 1px solid #ffc1dc;
            box-shadow: 0 8px 20px rgba(255, 79, 154, 0.13);
        }

        h1 {
            margin-top: 0;
            color: #d9367d;
        }

        label {
            display: block;
            margin: 16px 0 6px;
            font-weight: bold;
        }

        select,
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ffaad0;
            border-radius: 5px;
            background: #ffffff;
        }

        button {
            margin-top: 20px;
            padding: 10px 18px;
            border: 0;
            border-radius: 5px;
            background: #ff4f9a;
            color: #ffffff;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #111111;
        }

        .warning {
            margin: 16px 0 0;
            padding: 12px;
            border: 1px solid #ff8fbe;
            border-radius: 5px;
            background: #ffe3ef;
            color: #a31655;
            text-align: center;
            font-weight: bold;
        }
    </style>
    <style>
        .sidebar details { margin: 4px 0; }
        .sidebar summary { position: relative; display: block; padding: 11px 12px; border-radius: 6px; color: #ffffff; cursor: pointer; font-weight: bold; list-style: none; }
        .sidebar summary::-webkit-details-marker { display: none; }
        .sidebar summary:hover { background: #ff4f9a; }
        .sidebar summary::after { content: "\25BE"; position: absolute; top: 16px; right: 12px; color: #ffffff; }
        .sidebar details[open] summary::after { transform: rotate(180deg); }
        .sidebar .submenu { margin: 2px 0 8px 38px; padding-left: 8px; border-left: 2px solid #ff7ab8; }
        .sidebar .submenu a { margin: 2px 0; padding: 8px 10px; font-size: 14px; font-weight: normal; }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="brand">MyShop</div>
        <a href="homepage.php"><span>&#127968;</span>Home</a>
        <details>
            <summary><span>&#128722;</span>Products</summary>
            <div class="submenu">
                <a href="products.php">Product List</a>
                <a href="addproduct.php">Add Product</a>
            </div>
        </details>
        <details>
            <summary><span>&#128101;</span>Customers</summary>
            <div class="submenu">
                <a href="customers.php">Customer List</a>
                <a href="addcustomer.php">Add Customer</a>
            </div>
        </details>
        <details open>
            <summary><span>&#128203;</span>Orders</summary>
            <div class="submenu">
                <a href="orders.php">Order List</a>
                <a href="createorder.php">Create Order</a>
            </div>
        </details>
        <a href="profile.php"><span>&#128100;</span>Profile</a>
        <a href="logout.php"><span>&#9211;</span>Logout</a>
    </div>

    <div class="order-box">
        <h1>Create Order</h1>
        <form action="insertorder.php" method="POST" novalidate>
            <label for="CusID">Customer</label>
            <select id="CusID" name="CusID" required>
                <option value="">Select Customer</option>
                <?php while ($customer = mysqli_fetch_assoc($customers)) { ?>
                    <option value="<?php echo $customer['CusID']; ?>">
                        <?php echo htmlspecialchars($customer['CusID'] . " - " . $customer['Name']); ?>
                    </option>
                <?php } ?>
            </select>

            <label for="ProductID">Product</label>
            <select id="ProductID" name="ProductID" required>
                <option value="">Select Product</option>
                <?php while ($product = mysqli_fetch_assoc($products)) { ?>
                    <option value="<?php echo $product['ProductID']; ?>">
                        <?php echo htmlspecialchars($product['ProductID'] . " - " . $product['ProductName'] . " (RM " . $product['Price'] . ")"); ?>
                    </option>
                <?php } ?>
            </select>

            <label for="Quantity">Quantity</label>
            <input id="Quantity" type="number" name="Quantity" min="1" required>

            <?php if (isset($_GET["error"])) { ?>
                <div class="warning"><?php echo htmlspecialchars($_GET["error"]); ?></div>
            <?php } ?>

            <button type="submit">Submit Order</button>
        </form>
    </div>
</body>

</html>
