<?php
$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "Myshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ProductID = $_POST['ProductID'] ?? $_GET['ProductID'] ?? "";
if ($ProductID == "") {
    header("Location: products.php");
    exit();
}

$query = "SELECT * FROM products WHERE ProductID='$ProductID'";
$result = mysqli_query($conn, $query) or die("Couldn't execute query");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found");
}

$messages = $_GET["error"] ?? [];
if (!is_array($messages)) {
    $messages = [$messages];
}

$ProductNameValue = isset($_GET["ProductName"]) ? $_GET["ProductName"] : $product["ProductName"];
$PriceValue = isset($_GET["Price"]) ? $_GET["Price"] : $product["Price"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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

        input[readonly] {
            background: #fff7fb;
            color: #5b4550;
            cursor: default;
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

        .warning-list {
            width: 94%;
            max-width: 980px;
            margin: 16px auto 0;
        }

        .warning {
            margin: 10px 0;
            padding: 12px;
            border-radius: 5px;
            background: #ef4b52;
            color: #ffffff;
            text-align: left;
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
        <details open>
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
        <details>
            <summary><span>&#128203;</span>Orders</summary>
            <div class="submenu">
                <a href="orders.php">Order List</a>
                <a href="createorder.php">Create Order</a>
            </div>
        </details>
        <a href="profile.php"><span>&#128100;</span>Profile</a>
        <a href="logout.php"><span>&#9211;</span>Logout</a>
    </div>
    <form action="products.php" method="GET">
        <button type="submit">Back</button>
    </form>
    <?php if (count($messages) > 0) { ?>
        <div class="warning-list">
            <?php foreach ($messages as $message) { ?>
                <div class="warning">* <?php echo htmlspecialchars($message); ?></div>
            <?php } ?>
        </div>
    <?php } ?>
    <form action="process_edit_product.php" method="POST" novalidate>
        <table width="600">
            <tr>
                <th>ProductID</th>
                <th>ProductName</th>
                <th>Price(RM)</th>
            </tr>
            <tr>
                <td><input type="text" name="ProductID" value="<?php echo htmlspecialchars($product['ProductID']); ?>" readonly></td>
                <td><input type="text" name="ProductName" value="<?php echo htmlspecialchars($ProductNameValue); ?>"></td>
                <td><input type="text" name="Price" value="<?php echo htmlspecialchars($PriceValue); ?>"></td>
                <td><input type="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
</body>

</html>
