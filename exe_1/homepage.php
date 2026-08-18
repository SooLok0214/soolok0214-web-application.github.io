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

$loginEmail = mysqli_real_escape_string($conn, $_SESSION["Email"]);
$customerResult = mysqli_query($conn, "SELECT Name, CusID, Email, JoinYear FROM customers WHERE Email='$loginEmail'");
$customer = mysqli_fetch_assoc($customerResult);

if (!$customer) {
    header("Location: index.php");
    exit();
}

$recordResult = mysqli_query($conn, "SELECT
    (SELECT COUNT(*) FROM orders) AS TotalOrders,
    (SELECT COUNT(*) FROM products p WHERE NOT EXISTS (SELECT 1 FROM orders o WHERE o.ProductID=p.ProductID)) AS ProductsNotSold,
    (SELECT COUNT(*) FROM customers c WHERE NOT EXISTS (SELECT 1 FROM orders o WHERE o.CusID=c.CusID)) AS CustomersWithoutOrders");
$record = mysqli_fetch_assoc($recordResult);

$topProducts = mysqli_query($conn, "SELECT ProductID, ProductName, SUM(Quantity) AS SoldQuantity, SUM(TotalPrice) AS SalesTotal FROM orders GROUP BY ProductID, ProductName ORDER BY SoldQuantity DESC, ProductID ASC LIMIT 3");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyShop Home</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; }
        body { min-width: 480px; max-width: 1600px; margin: 0 auto; padding: 36px 40px 60px 260px; background: #fff0f6; color: #2b2026; }
        .sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: 220px; padding: 24px 16px; background: #111111; box-shadow: 8px 0 22px rgba(0, 0, 0, 0.24); }
        .brand { margin-bottom: 24px; padding: 16px 10px; color: #ff7ab8; font-size: 28px; font-weight: bold; text-align: center; border-bottom: 1px solid #3a3a3a; }
        .sidebar a { display: block; margin: 8px 0; padding: 11px 12px; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .sidebar a:hover, .sidebar .active { background: #ff4f9a; }
        .sidebar span { display: inline-block; width: 26px; height: 26px; margin-right: 10px; border-radius: 5px; background: #ff7ab8; color: #111111; text-align: center; line-height: 26px; }
        .welcome { width: 98%; max-width: 1280px; margin: 20px auto 28px; }
        .welcome h1 { margin: 0 0 8px; color: #d9367d; font-size: 34px; }
        .welcome p { margin: 0; color: #6f5360; }
        .records { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; width: 98%; max-width: 1280px; margin: 0 auto 28px; }
        .record { min-height: 120px; padding: 22px; background: #ffffff; border: 1px solid #ffc1dc; border-top: 6px solid #ff4f9a; border-radius: 8px; box-shadow: 0 8px 20px rgba(255, 79, 154, 0.13); }
        .record-title { margin-bottom: 14px; color: #6f5360; font-weight: bold; }
        .record-value { color: #241018; font-size: 28px; font-weight: bold; }
        .top-products { width: 98%; max-width: 1280px; margin: 0 auto; padding: 24px; background: #ffffff; border: 1px solid #ffc1dc; border-radius: 8px; box-shadow: 0 8px 20px rgba(255, 79, 154, 0.13); }
        .top-products h2 { margin: 0 0 18px; color: #d9367d; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #ffb3d2; color: #241018; }
        th, td { padding: 13px; border: 1px solid #ffc1dc; text-align: left; }
        tr:hover { background: #ffe8f2; }
        .rank { width: 70px; text-align: center; font-weight: bold; }
        .empty { text-align: center; color: #6f5360; }
        @media (max-width: 900px) {
            .records { grid-template-columns: 1fr; }
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
        <a class="active" href="homepage.php"><span>&#127968;</span>Home</a>
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

    <div class="welcome">
        <h1>Welcome, <?php echo htmlspecialchars($customer["Name"]); ?></h1>
        <p>Customer ID: <?php echo htmlspecialchars($customer["CusID"]); ?> | Member since <?php echo htmlspecialchars($customer["JoinYear"]); ?></p>
    </div>

    <div class="records">
        <div class="record">
            <div class="record-title">Total Orders</div>
            <div class="record-value"><?php echo $record["TotalOrders"]; ?></div>
        </div>
        <div class="record">
            <div class="record-title">Products Not Sold</div>
            <div class="record-value"><?php echo $record["ProductsNotSold"]; ?></div>
        </div>
        <div class="record">
            <div class="record-title">Customers Without Orders</div>
            <div class="record-value"><?php echo $record["CustomersWithoutOrders"]; ?></div>
        </div>
    </div>

    <div class="top-products">
        <h2>Top 3 Best-Selling Products</h2>
        <table>
            <tr>
                <th class="rank">Rank</th>
                <th>ProductID</th>
                <th>ProductName</th>
                <th>Quantity Sold</th>
                <th>Total Sales</th>
            </tr>
            <?php $rank = 1; ?>
            <?php if (mysqli_num_rows($topProducts) == 0) { ?>
                <tr><td class="empty" colspan="5">No sales records found.</td></tr>
            <?php } ?>
            <?php while ($product = mysqli_fetch_assoc($topProducts)) { ?>
                <tr>
                    <td class="rank"><?php echo $rank; ?></td>
                    <td><?php echo htmlspecialchars($product["ProductID"]); ?></td>
                    <td><?php echo htmlspecialchars($product["ProductName"]); ?></td>
                    <td><?php echo $product["SoldQuantity"]; ?></td>
                    <td>RM <?php echo number_format($product["SalesTotal"], 2); ?></td>
                </tr>
                <?php $rank++; ?>
            <?php } ?>
        </table>
    </div>
</body>
</html>
