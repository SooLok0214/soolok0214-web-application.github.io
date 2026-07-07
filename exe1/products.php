<?php
    $servername = "localhost";
    $username = "Myshop";
    $password = "";
    $dbname = "Myshop";
$conn = new mysqli($servername, $username, $password, $dbname);

session_start();

if(!isset($_SESSION["email"])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-width: 480px;
            max-width: 1280px;
            margin: 0 auto;
            padding: 40px 35px 40px 270px;
            background: #f7f0ff;
            color: #2f2140;
            position: relative;
        }

        body::before {
            content: "MyShop";
            position: fixed;
            top: 0;
            left: 0;
            width: 230px;
            bottom: 0;
            padding-top: 55px;
            background: #3a2456;
            color: #ffffff;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            box-shadow: 8px 0 24px rgba(68, 43, 98, 0.22);
        }

        body > a,
        table > a,
        body > button {
            position: fixed;
            left: 30px;
            width: 170px;
            display: block;
            margin: 0;
            z-index: 10;
        }

        body > a:nth-of-type(1),
        table > a:nth-of-type(1),
        body > button:nth-of-type(1) { top: 135px; }

        body > a:nth-of-type(2),
        table > a:nth-of-type(2),
        body > button:nth-of-type(2) { top: 185px; }

        body > a:nth-of-type(3),
        table > a:nth-of-type(3),
        body > button:nth-of-type(3) { top: 235px; }

        body > a:nth-of-type(4),
        table > a:nth-of-type(4),
        body > button:nth-of-type(4) { top: 285px; }

        body > a:nth-of-type(5),
        table > a:nth-of-type(5),
        body > button:nth-of-type(5) { top: 335px; }

        body > a input[type="submit"],
        table > a input[type="submit"],
        body > button {
            width: 170px;
            background: transparent;
            color: #f5edff;
            border: none;
            border-radius: 8px;
            padding: 12px 14px;
            text-align: left;
            font-size: 17px;
            font-weight: bold;
            box-shadow: none;
        }

        body > a input[type="submit"]:hover,
        table > a input[type="submit"]:hover,
        body > button:hover {
            background: #6f4aa0;
            color: #ffffff;
        }

        table {
            width: 92%;
            max-width: 980px;
            margin: 40px auto;
            border-collapse: collapse;
            background: #ffffff;
            border: 1px solid #d9c4f2;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(93, 62, 130, 0.12);
        }

        th {
            background: #d8bff0;
            color: #2f2140;
            font-weight: bold;
        }

        th,
        td {
            border: 1px solid #d9c4f2;
            padding: 12px 14px;
            text-align: left;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background: #fbf7ff;
        }

        input,
        textarea {
            border: 1px solid #c7a8e8;
            border-radius: 5px;
            padding: 8px;
            color: #2f2140;
        }

        input[type="submit"],
        button {
            background: #9b70cf;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 9px 14px;
            margin: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        button:hover {
            background: #8258b8;
        }

        a {
            color: #6f43a8;
            text-decoration: none;
        }

        button a {
            color: #ffffff;
        }

        h2 {
            color: #4b2f6f;
        }
    </style>

<body>
    <table width="800">
        <tr>
            <th>ProductID</th>
            <th width="300">ProductName</th>
            <th>Price</th>
        </tr>
        <?php

        $query = "SELECT * FROM products";

        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $row['ProductID']; ?></td>
                <td><?php echo $row['ProductName']; ?></td>
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
        <!-- <a href="customers.php"><input type="submit" value="All Customers"></a> -->
        <a href=""><input type="submit" value="Logout"></a>
    </table>

</body>
</html>










