<?php
session_start();
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? "";
    $loginPassword = $_POST["password"] ?? "";
    if ($email == "") {
        $message = "Please fill in Email.";
    } elseif ($loginPassword == "") {
        $message = "Please fill in Password.";
    } else {
        $conn = new mysqli(
            "localhost",
            "Ema_Wishes",
            "123123",
            "ema_wishes"
        );
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
        $email = $conn->real_escape_string($email);
        $loginPassword = $conn->real_escape_string($loginPassword);
        $query = "
            SELECT *
            FROM users
            WHERE email = '$email'
            AND password = '$loginPassword'
        ";
        $result = $conn->query($query)
            or die("Couldn't execute query");
        if ($result->num_rows > 0) {
            $_SESSION["email"] = $email;
            $conn->close();
            header("Location: home.php");
            exit();
        } else {
            $message = "No Found User";
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link
        rel="stylesheet"
        href="css/common.css?v=20260730-9">
    <link
        rel="stylesheet"
        href="css/index.css?v=20260730-4">
</head>

<body>
    <header class="site-header">
        <a class="site-brand" href="index.php">
            <span class="site-brand-mark">結</span>
            <span class="site-brand-copy">
                <h1 class="site-brand-title">
                    Ema Wish Shrine
                </h1>
                <small>Sakura Ema Experience</small>
            </span>
        </a>
    </header>
    <main class="login-page">
        <section class="login-intro">
            <div class="torii" aria-hidden="true">
                <span class="torii-top"></span>
                <span class="torii-beam"></span>
                <span class="torii-leg torii-leg-left"></span>
                <span class="torii-leg torii-leg-right"></span>
            </div>
            <p class="intro-label">
                ONLINE EMA EXPERIENCE
            </p>
            <h1>
                Let Your Wish<br>
                <span class="intro-highlight">
                    In The Spring Breeze
                </span>
            </h1>
        </section>
        <div id="email">
            <form method="POST">
                <h2>Enter Your Email:</h2>
                <input
                    type="text"
                    name="email"
                    value="<?php echo htmlspecialchars($_POST["email"] ?? ""); ?>">
                <br>
                <h2>Password:</h2>
                <input
                    type="password"
                    name="password">
                <?php if ($message != "") { ?>
                    <p class="login-message">
                        <?php echo $message; ?>
                    </p>
                <?php } ?>
                <input
                    type="submit"
                    value="Login">
            </form>
            <p>
                <a href="register.php">
                    Register New Account
                </a>
            </p>
        </div>
        <?php require "includes/footer.php";
