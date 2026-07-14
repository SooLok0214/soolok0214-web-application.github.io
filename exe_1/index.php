  <?php
  $servername = "localhost";
  $username = "Myshop";
  $password = "";
  $dbname = "Myshop";

if (isset($_POST["Email"]) && isset($_POST["Password"])) {

  if (empty($_POST["Email"])){
    echo("Please fill in Email.");
  } else if (empty($_POST["Password"])){
    echo("Please fill in Password.");
  }

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
      <title>MyShop Login</title>
      <style>
    * {
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        min-width: 480px;
        max-width: 1280px;
        margin: 0 auto;
        padding: 80px 40px;
        background: #fff0f6;
        color: #2b2026;
        text-align: center;
    }

    #email {
        width: 420px;
        max-width: 100%;
        margin: 80px auto;
        padding: 32px;
        background: #ffffff;
        border: 1px solid #ffc1dc;
        border-top: 8px solid #111111;
        border-radius: 10px;
        box-shadow: 0 10px 24px rgba(255, 79, 154, 0.14);
        text-align: left;
    }

    h2 {
        margin: 14px 0 8px;
        color: #d9367d;
        font-size: 20px;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ffaad0;
        border-radius: 5px;
    }

    input[type="submit"] {
        margin-top: 18px;
        border: 0;
        background: #ff4f9a;
        color: #ffffff;
        cursor: pointer;
        font-weight: bold;
    }

    input[type="submit"]:hover {
        background: #111111;
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