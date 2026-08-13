<?php
$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "myshop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$OrderID = $_POST["OrderID"] ?? "";
$CusID = $_POST["CusID"] ?? "";
$ProductID = $_POST["ProductID"] ?? "";
$Quantity = $_POST["Quantity"] ?? "";

if ($OrderID == "" || $CusID == "" || $ProductID == "" || $Quantity == "" || !is_numeric($Quantity) || $Quantity < 1) {
    header("Location: editorder.php?OrderID=" . urlencode($OrderID) . "&error=" . urlencode("Please complete all order details."));
    exit();
}

$customerResult = mysqli_query($conn, "SELECT Name FROM customers WHERE CusID='$CusID'");
$customer = mysqli_fetch_assoc($customerResult);
$productResult = mysqli_query($conn, "SELECT ProductName, Price FROM products WHERE ProductID='$ProductID'");
$product = mysqli_fetch_assoc($productResult);

if (!$customer || !$product) {
    header("Location: editorder.php?OrderID=" . urlencode($OrderID) . "&error=" . urlencode("Customer or product was not found."));
    exit();
}

$CustomerName = mysqli_real_escape_string($conn, $customer["Name"]);
$ProductName = mysqli_real_escape_string($conn, $product["ProductName"]);
$UnitPrice = $product["Price"];
$TotalPrice = $UnitPrice * $Quantity;

$query = "UPDATE orders SET CusID='$CusID', CustomerName='$CustomerName', ProductID='$ProductID', ProductName='$ProductName', Quantity='$Quantity', UnitPrice='$UnitPrice', TotalPrice='$TotalPrice' WHERE OrderID='$OrderID'";

if (mysqli_query($conn, $query)) {
    header("Location: orders.php");
    exit();
}

header("Location: editorder.php?OrderID=" . urlencode($OrderID) . "&error=" . urlencode("Unable to update this order."));
exit();
