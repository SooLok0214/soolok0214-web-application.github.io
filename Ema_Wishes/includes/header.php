<?php
$pageTitle = $pageTitle ?? "Ema Wishes";
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
    <header>
        <h1>Ema Wishes</h1>

        <?php if (isset($_SESSION["email"])) { ?>
            <nav>
                <a href="home.php">願望列表</a> |
                <a href="create_wish.php">新增願望</a> |
                <a href="profile.php">個人資料</a> |
                <a href="logout.php">登出</a>
            </nav>
        <?php } ?>
        <hr>
    </header>

    <main>
