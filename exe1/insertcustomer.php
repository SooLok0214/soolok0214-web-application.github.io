<?php
    $servername = "localhost";
    $username = "Myshop";
    $password = "";
    $dbname = "Myshop";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }


$sql = "INSERT INTO customers (Name, CusID, Email, Password, Phone) VALUES ('" . $_POST["Name"] . "', '" . $_POST["CusID"] . "', '" . $_POST["Email"] . "', '" . $_POST["Password"] . "', '" . $_POST["Phone"] . "')";

if ($conn->query($sql) === TRUE) {
  header("Location: customers.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);
?>
