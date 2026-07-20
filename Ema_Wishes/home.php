<?php
session_start();

$servername = "localhost";
$username = "Ema_Wishes";
$password = "123123";
$dbname = "ema_wishes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION["email"];
$userSql = "SELECT userID, username FROM users WHERE email = ?";
$userStmt = $conn->prepare($userSql);
$userStmt->bind_param("s", $email);
$userStmt->execute();
$currentUser = $userStmt->get_result()->fetch_assoc();
$userStmt->close();

if (!$currentUser) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$wishSql = "SELECT w.cardID, w.wishtext, w.name, w.gender, w.wishdate,
                   c.categoryname, c.categoryicon
            FROM wishes w
            LEFT JOIN wishcategories c
            ON w.categoryID = c.categoryID
            ORDER BY w.wishdate DESC";

$wishResult = mysqli_query($conn, $wishSql)
    or die("Couldn't execute query");

$totalWishes = mysqli_num_rows($wishResult);

$pageTitle = "Wish List";
require __DIR__ . "/includes/header.php";
?>

<h2>大家的祈願繪馬</h2>

<p>Welcome, <?php echo $currentUser["username"]; ?>.</p>
<p>共 <?php echo $totalWishes; ?> 份心願</p>

<a href="create_wish.php">Add New Wish</a>

<br><br>

<table width="1000" border="1" cellpadding="8">
    <tr>
        <th>Card ID</th>
        <th>Category</th>
        <th>Wish Text</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Date</th>
    </tr>

    <?php while ($wish = $wishResult->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $wish["cardID"]; ?></td>
            <td>
                <?php
                echo ($wish["categoryicon"] ?? "") . " " .
                    ($wish["categoryname"] ?? "");
                ?>
            </td>
            <td><?php echo $wish["wishtext"]; ?></td>
            <td><?php echo $wish["name"]; ?></td>
            <td><?php echo $wish["gender"]; ?></td>
            <td><?php echo $wish["wishdate"]; ?></td>
        </tr>
    <?php } ?>
</table
