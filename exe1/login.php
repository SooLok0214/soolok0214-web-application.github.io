<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exercise_1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$error_msg = "";

if (isset($_POST["Email"]) && isset($_POST["Password"])) {
  $query = "SELECT * FROM customers WHERE Email='" . $_POST["Email"] . "' && password='" . $_POST["Password"] . "'";
  $result = mysqli_query($conn, $query) or die("Couldn't execute query");
  $numrow = mysqli_num_rows($result);

  if ($numrow > 0) {
      header("Location: custormers.php");
      exit();
    } else {
      $error_msg = "No Found User"; 
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="Email">
    
    <?php if (!empty($error_msg)): ?>
        <div class="error-alert"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <form target="_self" method="POST">
      <h2>Enter Your Email:</h2>
      <input type="text" name="Email">
      <br/>
      <h2>Password:</h2>
      <input type="Password" name="Password">
      <input type="submit">
    </form>
  </div>
</body>
</html>