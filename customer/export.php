<?php
$conn = new mysqli("localhost", "soolok", "Rabbit5354", "soolok");

$department = $_GET['department'] ?? '';

if ($department == '') {
    $query = "SELECT * FROM emp_test";
} else {
    $department = mysqli_real_escape_string($conn, $department);
    $query = "SELECT * FROM emp_test WHERE DEPARTMENT = '$department'";
}

$result = mysqli_query($conn, $query);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=employee_list.csv");

$file = fopen("php://output", "w");

fputcsv($file, ["ID", "EmpID", "Name", "Department"]);

$id = 1;

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($file, [
        $id++,
        $row['ID'],
        $row['NAME'],
        $row['DEPARTMENT']
    ]);
}

fclose($file);
mysqli_close($conn);
