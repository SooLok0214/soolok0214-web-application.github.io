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
    <title>Add Customer</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-width: 480px;
            max-width: 1280px;
            margin: 0 auto;
            padding: 38px 38px 38px 260px;
            background: #fff0f6;
            color: #2b2026;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 220px;
            padding: 26px 16px;
            background: #111111;
            box-shadow: 8px 0 24px rgba(0, 0, 0, 0.28);
        }

                .brand {
            margin-bottom: 26px;
            padding: 16px 10px;
            color: #ff7ab8;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #3a3a3a;
        }
.sidebar a {
            display: block;
            margin: 10px 0;
            padding: 12px 12px;
            color: #f7f7f7;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        .sidebar a:hover {
            background: #ff4f9a;
            color: #ffffff;
        }

        .sidebar span {
            display: inline-block;
            width: 26px;
            height: 26px;
            margin-right: 10px;
            border-radius: 6px;
            background: #ff7ab8;
            color: #111111;
            text-align: center;
            line-height: 26px;
            font-size: 14px;
            font-weight: bold;
        }
table {
            width: 94%;
            max-width: 980px;
            margin: 26px auto;
            border-collapse: collapse;
            background: #ffffff;
            border: 1px solid #ffc1dc;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(255, 79, 154, 0.14);
        }

        th {
            background: #ffb3d2;
            color: #241018;
            font-weight: bold;
        }

        th,
        td {
            border: 1px solid #ffc1dc;
            padding: 12px 14px;
            text-align: left;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background: #fff7fb;
        }

        tr:hover {
            background: #ffe3ef;
        }

        input,
        textarea {
            border: 1px solid #ffaad0;
            border-radius: 6px;
            padding: 9px;
            color: #2b2026;
            outline: none;
            background: #ffffff;
        }

        input:focus,
        textarea:focus {
            border-color: #111111;
            box-shadow: 0 0 0 3px rgba(255, 79, 154, 0.18);
        }

        input[type="submit"],
        button {
            background: #ff4f9a;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 9px 15px;
            margin: 4px;
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

        h2 {
            color: #d9367d;
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
        <a href="profile.php"><span>&#128100;</span>Profile</a>
        <a href="logout.php"><span>&#9211;</span>Logout</a>
    </div>

    <table width = "600">
        <tr>
            <th>Name</th>
            <th>CusID</th>
            <th>Email</th>
            <th>Password</th>
            <th>Join Year</th>
            <th>Phone</th>
        </tr>
        <tr>
            <form action="insertcustomer.php" method="POST">
                <td><input type="text" name="Name"></td>
                <td><input type="text" name="CusID"></td>
                <td><input type="text" name="Email"></td>
                <td><input type="text" name="Password"></td>
                <td><input type="number" min="1900" max="<?php echo date("Y"); ?>" step="1" name="JoinYear" required maxlength="4"></td>
                <td><input type="text" name="Phone"></td>
                <td><input type="submit" value="add"></td>
            </form>
        </tr>
</body>
</html>

























