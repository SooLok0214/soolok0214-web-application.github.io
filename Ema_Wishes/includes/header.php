<?php
$pageTitle = $pageTitle ?? "Ema Wishes";
$currentPage = basename($_SERVER["PHP_SELF"]);
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="css/common.css?v=20260730-9">
    <?php if (isset($pageCss)) { ?>
        <link rel="stylesheet" href="<?php echo $pageCss; ?>">
    <?php } ?>
</head>
<body>
    <header class="site-header">
        <a class="site-brand" href="home.php">
            <span class="site-brand-mark">結</span>
            <span class="site-brand-copy">
                <h1 class="site-brand-title">Ema Wish Shrine</h1>
                <small>Sakura Ema Experience</small>
            </span>
        </a>
        <?php if (isset($_SESSION["email"])) { ?>
            <nav class="site-nav">
                <a
                    class="<?php echo $currentPage == "home.php" ? "active" : ""; ?>"
                    href="home.php"
                >Wish List</a>
                <a
                    class="<?php echo $currentPage == "create_wish.php" ? "active" : ""; ?>"
                    href="create_wish.php"
                >Create Wish</a>
                <a
                    class="<?php echo $currentPage == "profile.php" || $currentPage == "update_profile.php" ? "active" : ""; ?>"
                    href="profile.php"
                >Profile</a>
                <a
                    href="logout.php"
                    onclick="return confirm('Are you sure you want to log out?');"
                >Logout</a>
            </nav>
        <?php } ?>
    </header>
    <main>
