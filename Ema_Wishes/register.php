<?php
$error = $_GET["error"] ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link
        rel="stylesheet"
        href="css/common.css?v=20260730-9">
    <link
        rel="stylesheet"
        href="css/register.css?v=20260730-4">
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
    <main class="register-page">
        <section class="register-intro">
            <p>CREATE YOUR EMA ACCOUNT</p>
            <h1>Begin Your Wish Journey</h1>
            <span>
                Create an account before placing your first wish on the wall.
            </span>
        </section>
        <section class="register-card">
            <?php if ($error != "") { ?>
                <p class="register-error" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </p>
            <?php } ?>
            <form
                class="register-form"
                action="insertuser.php"
                method="POST">
                <label>
                    <span>Username</span>
                    <input
                        type="text"
                        name="username"
                        autocomplete="username">
                </label>
                <label>
                    <span>Email</span>
                    <input
                        type="email"
                        name="email"
                        autocomplete="email">
                </label>
                <label>
                    <span>Password</span>
                    <input
                        type="password"
                        name="password"
                        autocomplete="new-password">
                    <small>Use at least 6 characters.</small>
                </label>
                <label>
                    <span>Confirm Password</span>
                    <input
                        type="password"
                        name="confirm_password"
                        autocomplete="new-password">
                </label>
                <label>
                    <span>Phone Number</span>
                    <input
                        type="text"
                        name="phonenumber"
                        autocomplete="tel"
                        placeholder="+60">
                </label>
                <fieldset class="gender-field">
                    <legend>Gender</legend>
                    <div class="gender-options">
                        <label class="gender-option">
                            <input
                                type="radio"
                                name="gender"
                                value="male">
                            <span>Male</span>
                        </label>
                        <label class="gender-option">
                            <input
                                type="radio"
                                name="gender"
                                value="female">
                            <span>Female</span>
                        </label>
                    </div>
                </fieldset>
                <input
                    class="register-button"
                    type="submit"
                    value="Create Account">
            </form>
            <p class="login-link">
                Already have an account?
                <a href="index.php">Login</a>
            </p>
        </section>
    </main>
    <?php require "includes/footer.php"; ?>
</body>

</html>