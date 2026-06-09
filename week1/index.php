<?php
$servername = "localhost";
$username = "soolok";
$password = "Rabbit5354";
$dbname = "soolok";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected Gay";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
      *{font-size: 20px;}

      body{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }
    </style>
</head>
<body>
  <div id="email">
    <form target="_self" method="POST">
    <h2>Enter Your Email:</h2>
    <input type="text" name="email">
    <br/>
    <h2>Password:</h2>
    <input type="password" name="password">
    <input type="submit">
    </form>
  </div>
</body>
</html>