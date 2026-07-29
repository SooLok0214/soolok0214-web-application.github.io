<?php
$servername = "localhost";
$username = "Ema_Wishes";
$password = "123123";
$dbname = "ema_wishes";
$message = "";

if (isset($_POST["email"]) && isset($_POST["password"])) {

    if (empty($_POST["email"])) {
        $message = "Please fill in Email.";
    } else if (empty($_POST["password"])) {
        $message = "Please fill in Password.";
    }
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    $conn->set_charset("utf8mb4");

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
        $message = "No Found User";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/common.css?v=20260729">
    <link rel="stylesheet" href="css/index.css?v=20260729-4">
</head>

<body>
    <header class="index-brand">
        <div class="brand-content">
            <div class="brand-mark" aria-hidden="true">結</div>
            <div class="brand-text">
                <p class="brand-title">EMA WISH SHRINE</p>
                <p class="brand-subtitle">SAKURA EMA EXPERIENCE</p>
            </div>
        </div>
    </header>

    <main class="login-page">
        <section class="login-intro">
            <div class="torii" aria-hidden="true">
                <span class="torii-top"></span>
                <span class="torii-beam"></span>
                <span class="torii-leg torii-leg-left"></span>
                <span class="torii-leg torii-leg-right"></span>
            </div>

            <p class="intro-label">ONLINE EMA EXPERIENCE</p>
            <h1>Let Your Wish<br><span class="intro-highlight">In The Spring Breeze</span></h1>
        </section>

        <div id="email">
            <form target="_self" method="POST">
                <h2>Enter Your Email:</h2>
                <input type="text" name="email">
                <br>

                <h2>Password:</h2>
                <input type="password" name="password">

                <?php if ($message != "") { ?>
                    <p class="login-message"><?php echo $message; ?></p>
                <?php } ?>

                <input type="submit" value="Login">
            </form>

            <p><a href="register.php">Register New Account</a></p>
        </div>
    </main>
    <?php
    require __DIR__ . "/includes/footer.php";
    ?>
</body>

</html>
