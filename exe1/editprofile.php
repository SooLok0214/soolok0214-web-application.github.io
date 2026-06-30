<?php
$CusID = $_POST['CusID'];
?>

<!DOCTYPE html>
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
</head>

<body>
    <button><a href="profile.php">Back</a></button>
    <form action="process_edit_profile.php" method="POST">
        <input type="hidden" name="CusID" value="<?php echo $CusID; ?>">
        <table width="600">
            <tr>
                <th>Name</th>
                <th>Password</th>
                <th>Confirm Password</th>
                <th>Phone</th>
            </tr>
            <tr>
                <td><input type="text" name="Name" required></td>
                <td><input type="password" name="Password"></td>
                <td><input type="password" name="ConfirmPassword"></td>
                <td><input type="text" name="Phone" required></td>
                <td><input type="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
</body>
</html>









