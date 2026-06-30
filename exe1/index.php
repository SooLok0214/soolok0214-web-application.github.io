  <?php
  $servername = "localhost";
  $username = "Myshop";
  $password = "";
  $dbname = "Myshop";
  $message = "";

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
            background: #f7f0ff;
            color: #2f2140;
            text-align: center;
        }

        #email {
            width: 420px;
            margin: 80px auto;
            padding: 30px;
            background: #ffffff;
            border: 1px solid #d9c4f2;
            border-radius: 10px;
            box-shadow: 0 10px 24px rgba(93, 62, 130, 0.12);
            text-align: left;
        }

        h2 {
            color: #4b2f6f;
            margin: 14px 0 8px;
            font-size: 20px;
        }

        input {
            width: 100%;
            border: 1px solid #c7a8e8;
            border-radius: 5px;
            padding: 10px;
            color: #2f2140;
        }

        .error {
            color: #7a3fb0;
            text-align: center;
            margin: 16px 0 0;
            font-weight: bold;
        }

        input[type="submit"] {
            background: #9b70cf;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 10px 14px;
            margin-top: 18px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background: #8258b8;
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

