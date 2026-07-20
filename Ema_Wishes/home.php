<?php
session_start();

$servername = "localhost";
$username = "Ema_Wishes";
$password = "123123";
$dbname = "ema_wishes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

if (!isset($_SESSION["userID"])) {
    header("Location: index.php");
    exit();
}

$userSql = "SELECT * FROM users WHERE userID = ?";
$userStmt = $conn->prepare($userSql);
$userStmt->bind_param("s", $_SESSION["userID"]);
$userStmt->execute();
$currentUser = $userStmt->get_result()->fetch_assoc();
$userStmt->close();

if (!$currentUser) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$sql = "SELECT w.cardID, w.wishtext, w.name, w.gender, w.wishdate,
               c.categoryname, c.categoryicon
        FROM wishes w
        LEFT JOIN wishcategories c ON w.categoryID = c.categoryID
        ORDER BY w.wishdate DESC";
$result = $conn->query($sql);

$pageTitle = "Wish List";
require __DIR__ . "/includes/header.php";
?>

<h2>Wish List</h2>
<p>
    Welcome,
    <?php echo htmlspecialchars($currentUser["first_name"] . " " . $currentUser["last_name"]); ?>.
</p>

<p><a href="create_wish.php">Add New Wish</a></p>

<table border="1" cellpadding="8">
    <tr>
        <th>Card ID</th>
        <th>Category</th>
        <th>Wish</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Date</th>
    </tr>

    <?php if ($result && $result->num_rows > 0) { ?>
        <?php while ($wish = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($wish["cardID"]); ?></td>
                <td>
                    <?php echo htmlspecialchars(($wish["categoryicon"] ?? "") . " " . ($wish["categoryname"] ?? "")); ?>
                </td>
                <td><?php echo htmlspecialchars($wish["wishtext"]); ?></td>
                <td><?php echo htmlspecialchars($wish["name"]); ?></td>
                <td><?php echo htmlspecialchars($wish["gender"]); ?></td>
                <td><?php echo htmlspecialchars($wish["wishdate"]); ?></td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="6">No wishes found.</td>
        </tr>
    <?php } ?>
</table>

<?php require __DIR__ . "/includes/footer.php"; ?>
