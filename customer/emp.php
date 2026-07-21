<?php
$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$departments = [
    "Administration",
    "Customer Service",
    "Finance",
    "Human Resources",
    "IT",
    "Marketing",
    "Operations",
    "Procurement",
    "R&D",
    "Sales"
];

$department = $_GET['department'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
</head>
<style>
    table {
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
        text-align: center;
    }

    .filter-container {
        width: 1100px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 5px;
    }

    .filter-button {
        padding: 8px 14px;
        border: 1px solid black;
        background-color: #eeeeee;
        color: black;
        text-decoration: none;
        border-radius: 4px;
    }

    .filter-button:hover {
        background-color: #cccccc;
    }

    .filter-button.active {
        background-color: black;
        color: white;
    }
</style>

<body>
    <div class="filter-container">
        <form method="GET">
            <select name="department" onchange="this.form.submit()">
                <option value="" <?= $department == '' ? 'selected' : '' ?>>
                    All Departments
                </option>

                <?php foreach ($departments as $item) { ?>
                    <option value="<?= $item ?>"
                        <?= $department == $item ? 'selected' : '' ?>>
                        <?= $item ?>
                    </option>
                <?php } ?>
            </select>
        </form>
        <button><a href="export.php?department=<?= ($department) ?>">
                Download Table
            </a></button>

    </div>
    <table width="1100">
        <tr>
            <th>ID</th>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Department</th>
        </tr>
        <?php

        if ($department === '') {
            $query = "SELECT * FROM emp_test";
        } else {
            $safeDepartment = mysqli_real_escape_string($conn, $department);

            $query = "SELECT * FROM emp_test
              WHERE DEPARTMENT = '$safeDepartment'";
        }

        $result = mysqli_query($conn, $query);
        $number = 1;
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $number++; ?></td>
                <td><?php echo $row['ID']; ?></td>
                <td><?php echo $row['NAME']; ?></td>
                <td><?php echo $row['DEPARTMENT']; ?></td>
            </tr>
        <?php
        }
        mysqli_close($conn);
        ?>
    </table>

</body>

</html>