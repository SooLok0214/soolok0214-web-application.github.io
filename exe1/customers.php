<?php
    $servername = "localhost";
    $username = "Myshop";
    $password = "";
    $dbname = "Myshop";

    // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Customers</title>
  <style>
        table{
            border-collapse: collapse;
        }
        table,
        th,
        td{
            border: 1px solid black;
        }   
      </style>
</head>
<body>
    <table width="800">
        <tr>
            <th>Name</th>
            <th>CusID</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
        <?php

        $query = "SELECT * FROM customers ";        
        $result = mysqli_query($conn, $query) or die("Couldn't execute query");
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <form action="editprofile.php" method="POST">
                <td><?php echo $row['Name'] ?></td>
                <td><?php echo $row['CusID'] ?></td>
                <td><?php echo $row['Email'] ?></td>
                <td><?php echo $row['Phone'] ?></td>
                <td>
                    <input type="hidden" name="CusID" value="<?php echo $row['CusID']; ?>">
                    <input type="submit" value="Edit">
                </td>
            </form>
        </tr>
    <?php 
}
mysqli_close($conn);
?>
<a href="products.php"><input type="submit" value="Back"></a>
<a href="addcustomer.php"><input type="submit" value="Add Customer"></a>
    </table>
</body>
</html>



