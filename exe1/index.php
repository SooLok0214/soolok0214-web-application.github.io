  <?php
  $servername = "localhost";
  $username = "Myshop";
  $password = "";
  $dbname = "Myshop";
  $message = "";

if (isset($_POST["Email"]) && isset($_POST["Password"])) {

  if (empty($_POST["Email"])){
    $message = "Please fill in Email.";
  } else if (empty($_POST["Password"])){
    $message = "Please fill in Password.";
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
      $message = "No Found User";
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
            margin: 80px auto;
            padding: 32px;
            background: #ffffff;
            border: 1px solid #ffc1dc;
            border-radius: 12px;
            box-shadow: 0 10px 24px rgba(255, 79, 154, 0.14);
            text-align: left;
            border-top: 8px solid #111111;
        }

        h2 {
            color: #d9367d;
            margin: 14px 0 8px;
            font-size: 20px;
        }

        input {
            width: 100%;
            border: 1px solid #ffaad0;
            border-radius: 6px;
            padding: 10px;
            color: #2b2026;
            outline: none;
        }

        input:focus {
            border-color: #111111;
            box-shadow: 0 0 0 3px rgba(255, 79, 154, 0.18);
        }

        .error {
            color: #d9367d;
            text-align: center;
            margin: 16px 0 0;
            font-weight: bold;
        }

        input[type="submit"] {
            background: #ff4f9a;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 10px 14px;
            margin-top: 18px;
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
        <?php if ($message != "") { ?>
          <div class="error"><?php echo $message; ?></div>
        <?php } ?>
        <input type="submit">
      </form>
    </div>
  </body>
  </html>






