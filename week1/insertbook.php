<?php
    $servername = "localhost";
    $username = "soolok";
    $password = "Rabbit5354";
    $dbname = "soolok";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }


$sql = "INSERT INTO booklist (ISBN, title, author, description, price) VALUES ('" . $_POST["ISBN"] . "', '" . $_POST["title"] . "', '" . $_POST["author"] . "', '" . $_POST["description"] . "', '" . $_POST["price"] . "')";

if ($conn->query($sql) === TRUE) {
  header("Location: booklist.php");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);
?>