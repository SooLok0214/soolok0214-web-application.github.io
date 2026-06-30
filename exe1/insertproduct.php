<?php
    $servername = "localhost";
    $username = "myshop";
    $password = "Shop123";
    $dbname = "myshop";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

$sql = "INSERT INTO products (ProductName, ProductID, Price) VALUES ('" . $_POST["ProductName"] . "', '" . $_POST["ProductID"] . "', '" . $_POST["Price"] . "')";

if ($conn->query($sql) === TRUE) {
  header("Location: products.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);
?>


