<?php
$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "myshop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (empty($_POST["CusID"]) || empty($_POST["ProductID"]) || empty($_POST["Quantity"])) {
    header("Location: createorder.php?error=" . urlencode("Please fill in all fields."));
    exit();
}

$CusID = $_POST["CusID"];
$ProductID = $_POST["ProductID"];
$Quantity = $_POST["Quantity"];

if (!is_numeric($CusID) || !is_numeric($ProductID) || !is_numeric($Quantity) || $Quantity < 1) {
    header("Location: createorder.php?error=" . urlencode("Please select valid order details."));
    exit();
}

$customerResult = mysqli_query($conn, "SELECT Name FROM customers WHERE CusID='$CusID'");
$productResult = mysqli_query($conn, "SELECT ProductName, Price FROM products WHERE ProductID='$ProductID'");
$customer = mysqli_fetch_assoc($customerResult);
$product = mysqli_fetch_assoc($productResult);

if (!$customer || !$product) {
    header("Location: createorder.php?error=" . urlencode("Customer or product was not found."));
    exit();
}

$CustomerName = mysqli_real_escape_string($conn, $customer["Name"]);
$ProductName = mysqli_real_escape_string($conn, $product["ProductName"]);
$UnitPrice = $product["Price"];
$TotalPrice = $UnitPrice * $Quantity;

$sql = "INSERT INTO orders (CusID, CustomerName, ProductID, ProductName, Quantity, UnitPrice, TotalPrice)
        VALUES ('$CusID', '$CustomerName', '$ProductID', '$ProductName', '$Quantity', '$UnitPrice', '$TotalPrice')";

if ($conn->query($sql) === TRUE) {
    header("Location: orders.php");
    exit();
}

header("Location: createorder.php?error=" . urlencode("Unable to create order: " . $conn->error));
exit();
