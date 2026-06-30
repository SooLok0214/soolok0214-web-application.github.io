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
            margin: 0;
            min-height: 100vh;
            background: #f6f0ff;
            color: #34264a;
            padding: 36px 36px 36px 220px;
        }

        body::before {
            content: "MyShop";
            position: fixed;
            top: 30px;
            left: 28px;
            width: 150px;
            color: #ffffff;
            background: #7f56b3;
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            box-shadow: 0 8px 20px rgba(82, 49, 126, 0.18);
        }

        body > a,
        table > a,
        body > button {
            position: fixed;
            left: 28px;
            width: 150px;
            display: block;
            margin: 0;
            z-index: 10;
        }

        body > a:nth-of-type(1),
        table > a:nth-of-type(1),
        body > button:nth-of-type(1) {
            top: 110px;
        }

        body > a:nth-of-type(2),
        table > a:nth-of-type(2),
        body > button:nth-of-type(2) {
            top: 160px;
        }

        body > a:nth-of-type(3),
        table > a:nth-of-type(3),
        body > button:nth-of-type(3) {
            top: 210px;
        }

        body > a:nth-of-type(4),
        table > a:nth-of-type(4),
        body > button:nth-of-type(4) {
            top: 260px;
        }

        body > a:nth-of-type(5),
        table > a:nth-of-type(5),
        body > button:nth-of-type(5) {
            top: 310px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 1100px;
            margin: 24px auto;
            background: #ffffff;
            border: 1px solid #d8c6f0;
            box-shadow: 0 8px 24px rgba(108, 76, 150, 0.12);
        }

        th {
            background: #d9c2f2;
            color: #2f1e46;
            font-weight: bold;
        }

        th,
        td {
            border: 1px solid #d8c6f0;
            padding: 12px;
            text-align: left;
        }

        tr:nth-child(even) {
            background: #fbf8ff;
        }

        input,
        textarea {
            border: 1px solid #c8addf;
            border-radius: 6px;
            padding: 8px 10px;
            background: #fff;
            color: #34264a;
        }

        input[type="submit"],
        button {
            border: none;
            border-radius: 6px;
            background: #9b72cf;
            color: #ffffff;
            padding: 10px 14px;
            cursor: pointer;
            margin: 4px;
        }

        body > a input[type="submit"],
        table > a input[type="submit"],
        body > button {
            width: 150px;
            text-align: left;
            font-weight: bold;
            box-shadow: 0 6px 16px rgba(108, 76, 150, 0.16);
        }

        input[type="submit"]:hover,
        button:hover {
            background: #825ab8;
        }

        a {
            color: #6f43aa;
            text-decoration: none;
        }

        button a {
            color: #ffffff;
        }

        h2 {
            color: #4a2f6b;
            margin-bottom: 8px;
        }

        @media (max-width: 760px) {
            body {
                padding: 190px 18px 24px;
            }

            body::before {
                top: 18px;
                left: 18px;
                width: calc(100% - 36px);
            }

            body > a,
            table > a,
            body > button {
                position: absolute;
                left: 18px;
                width: calc(100% - 36px);
            }

            body > a:nth-of-type(1),
            table > a:nth-of-type(1),
            body > button:nth-of-type(1) { top: 82px; }
            body > a:nth-of-type(2),
            table > a:nth-of-type(2),
            body > button:nth-of-type(2) { top: 126px; }
            body > a:nth-of-type(3),
            table > a:nth-of-type(3),
            body > button:nth-of-type(3) { top: 170px; }
            body > a:nth-of-type(4),
            table > a:nth-of-type(4),
            body > button:nth-of-type(4) { top: 214px; }
            body > a:nth-of-type(5),
            table > a:nth-of-type(5),
            body > button:nth-of-type(5) { top: 258px; }
        }
    </style>
</head>

<body>
    <button><a href="profile.php">Back</a></button>
    <form action="process_edit_profile.php" method="POST">
        <table width="600">
            <tr>
                <th>Name</th>
                <th>Password</th>
                <th>Confirm Password</th>
                <th>Year Joined</th>
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





