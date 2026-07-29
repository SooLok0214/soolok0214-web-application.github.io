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
    <?php if (isset($pageCss)) { ?>
        <link rel="stylesheet" href="<?php echo $pageCss; ?>">
    <?php } ?>
</head>

<body>
    <header>
        <h1>Ema Wishes</h1>

        <?php if (isset($_SESSION["email"])) { ?>
            <nav>
                <a href="home.php">Wish List</a> |
                <a href="create_wish.php">Create Your Wish</a> |
                <a href="profile.php">Profile</a> |
                <a href="logout.php">Logout</a>
            </nav>
        <?php } ?>
        <hr>
    </header>

    <main>
