  <?php
  $servername = "localhost";
  $username = "myshop";
  $password = "";
  $dbname = "myshop";

if (isset($_POST["Email"]) && isset($_POST["Password"])) {

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();

  $query = "SELECT * FROM customers WHERE Email='" . $_POST["Email"] . "' && Password='" . $_POST["Password"] . "'";
  $result = mysqli_query($conn, $query) or die("Couldn't execute query");
  $numrow = mysqli_num_rows($result);

  if ($numrow > 0) {
      $_SESSION["Email"] = $_POST["Email"];
      header("Location: products.php");
      exit();
    } else {
      echo "No Found User";
    }
  }
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
        <input type="text" name="Email">
        <br/>
        <h2>Password:</h2>
        <input type="password" name="Password">
        <input type="submit">
      </form>
    </div>
  </body>
  </html>
