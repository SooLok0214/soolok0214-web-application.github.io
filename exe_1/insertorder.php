<?php
$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "myshop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

require_once "generatecode.php";

$CusID = $_POST["CusID"] ?? "";
$ProductIDs = $_POST["ProductID"] ?? [];
$Quantities = $_POST["Quantity"] ?? [];

if (!is_array($ProductIDs)) {
    $ProductIDs = [$ProductIDs];
}

if (!is_array($Quantities)) {
    $Quantities = [$Quantities];
}

if (empty($CusID) || count($ProductIDs) == 0 || count($ProductIDs) != count($Quantities)) {
    header("Location: createorder.php?error=" . urlencode("Please fill in all fields."));
    exit();
}

$customerResult = mysqli_query($conn, "SELECT Name FROM customers WHERE CusID='$CusID'");
$customer = mysqli_fetch_assoc($customerResult);

if (!$customer) {
    header("Location: createorder.php?error=" . urlencode("Customer was not found."));
    exit();
}

$CustomerName = mysqli_real_escape_string($conn, $customer["Name"]);
$conn->begin_transaction();

for ($i = 0; $i < count($ProductIDs); $i++) {
    $ProductID = $ProductIDs[$i];
    $Quantity = $Quantities[$i];

    if (empty($ProductID) || empty($Quantity) || !is_numeric($Quantity) || $Quantity < 1) {
        $conn->rollback();
        header("Location: createorder.php?error=" . urlencode("Please select a product and enter its quantity."));
        exit();
    }

    $productResult = mysqli_query($conn, "SELECT ProductName, Price FROM products WHERE ProductID='$ProductID'");
    $product = mysqli_fetch_assoc($productResult);

    if (!$product) {
        $conn->rollback();
        header("Location: createorder.php?error=" . urlencode("Product was not found."));
        exit();
    }

    $ProductName = mysqli_real_escape_string($conn, $product["ProductName"]);
    $UnitPrice = $product["Price"];
    $TotalPrice = $UnitPrice * $Quantity;
    $OrderID = generateUniqueCode();

    $sql = "INSERT INTO orders (OrderID, CusID, CustomerName, ProductID, ProductName, Quantity, UnitPrice, TotalPrice)
            VALUES ('$OrderID', '$CusID', '$CustomerName', '$ProductID', '$ProductName', '$Quantity', '$UnitPrice', '$TotalPrice')";

    if ($conn->query($sql) !== TRUE) {
        $conn->rollback();
        header("Location: createorder.php?error=" . urlencode("Unable to create order: " . $conn->error));
        exit();
    }
}

$conn->commit();
header("Location: orders.php");
exit();
