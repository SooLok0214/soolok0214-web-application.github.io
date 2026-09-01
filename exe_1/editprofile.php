<!DOCTYPE html>
<?php
$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "Myshop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$targetEmail = $_POST["Email"] ?? $_GET["Email"] ?? "";
if ($targetEmail == "") {
    die("Customer not found");
}

$escapedEmail = mysqli_real_escape_string($conn, $targetEmail);
$result = mysqli_query($conn, "SELECT * FROM customers WHERE Email='$escapedEmail'");
$customer = mysqli_fetch_assoc($result);

if (!$customer) {
    die("Customer not found");
}

$messages = $_GET["error"] ?? [];
if (!is_array($messages)) {
    $messages = [$messages];
}

$NameValue = isset($_GET["Name"]) ? $_GET["Name"] : $customer["Name"];
$JoinYearValue = isset($_GET["JoinYear"]) ? $_GET["JoinYear"] : $customer["JoinYear"];
$PhoneValue = isset($_GET["Phone"]) ? $_GET["Phone"] : $customer["Phone"];
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
    <form action="profile.php" method="GET">
        <button type="submit">Back</button>
    </form>

    <?php if (count($messages) > 0) { ?>
        <div class="warning-list">
            <?php foreach ($messages as $message) { ?>
                <div class="warning">* <?php echo htmlspecialchars($message); ?></div>
            <?php } ?>
        </div>
    <?php } ?>

    <form action="process_edit_profile.php" method="POST" novalidate>
        <table>
            <tr>
                <th>Name</th>
                <th>Password</th>
                <th>Confirm Password</th>
                <th>JoinYear</th>
                <th>Phone</th>
            </tr>
            <tr>
                <td>
                    <input type="hidden" name="Email" value="<?php echo htmlspecialchars($targetEmail); ?>">
                    <input type="text" name="Name" value="<?php echo htmlspecialchars($NameValue); ?>">
                </td>
                <td><input type="password" name="Password" minlength="6"></td>
                <td><input type="password" name="ConfirmPassword" minlength="6"></td>
                <td><input type="number" min="1900" max="<?php echo date("Y"); ?>" step="1" name="JoinYear" value="<?php echo htmlspecialchars($JoinYearValue); ?>"></td>
                <td><input type="text" name="Phone" value="<?php echo htmlspecialchars($PhoneValue); ?>"></td>
                <td><input type="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
</body>

</html>
