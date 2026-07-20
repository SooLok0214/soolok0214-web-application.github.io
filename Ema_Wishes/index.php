<?php
$servername = "localhost";
$username = "Ema_Wishes";
$password = "123123";
$dbname = "ema_wishes";

if (isset($_POST["email"]) && isset($_POST["password"])) {

    if (empty($_POST["email"])) {
        echo ("Please fill in Email.");
    } else if (empty($_POST["password"])) {
        echo ("Please fill in Password.");
    }

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    session_start();

    $query = "SELECT * FROM users WHERE email='" . $_POST["email"] . "' && password='" . $_POST["password"] . "'";
    $result = $conn->query($query) or die("Couldn't execute query");
    $numrow = mysqli_num_rows($result);

    if ($numrow > 0) {
        $_SESSION["email"] = $_POST["email"];
        header("Location: home.php");
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
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div id="email">
        <form target="_self" method="POST">
            <h2>Enter Your Email:</h2>
            <input type="text" name="email">
            <br>

            <h2>Password:</h2>
            <input type="password" name="password">
            <input type="submit">
        </form>

        <p><a href="register.php">Register New Account</a></p>
    </div>

    <?php require __DIR__ . '/includes/footer.php'; ?>
</body>

</html>