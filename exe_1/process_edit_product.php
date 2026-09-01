<?php
$servername = "localhost";
$username = "Myshop";
$password = "";
$dbname = "Myshop";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$ProductID = $_POST["ProductID"] ?? "";
$new_title = trim($_POST["ProductName"] ?? "");
$new_price = trim($_POST["Price"] ?? "");
$messages = [];

if ($new_title == "") {
    $messages[] = "Please enter the product name.";
}

if ($new_price == "") {
    $messages[] = "Please enter the product price.";
} else if (!is_numeric($new_price) || $new_price < 0) {
    $messages[] = "Please enter a valid product price.";
}

if (count($messages) > 0) {
    $parameters = [
        "ProductID" => $ProductID,
        "ProductName" => $new_title,
        "Price" => $new_price,
        "error" => $messages
    ];
    header("Location: editproduct.php?" . http_build_query($parameters));
    exit();
}

$new_title = mysqli_real_escape_string($conn, $new_title);
$new_price = mysqli_real_escape_string($conn, $new_price);

$sql = "UPDATE products SET ProductName='$new_title', Price='$new_price' WHERE ProductID='$ProductID'";

if (mysqli_query($conn, $sql)) {
    header("Location: products.php");
    exit;
} else {
    echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
