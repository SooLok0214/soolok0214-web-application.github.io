<?php
session_start();

$servername = "localhost";
$username = "Ema_Wishes";
$password = "123123";
$dbname = "ema_wishes";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

if (!isset($_SESSION["userID"])) {
    header("Location: index.php");
    exit();
}

$userID = $_SESSION["userID"];
$userSql = "SELECT first_name, last_name, gender FROM users WHERE userID = ?";
$userStmt = mysqli_prepare($conn, $userSql);
mysqli_stmt_bind_param($userStmt, "s", $userID);
mysqli_stmt_execute($userStmt);
$userResult = mysqli_stmt_get_result($userStmt);
$currentUser = mysqli_fetch_assoc($userResult);
mysqli_stmt_close($userStmt);

if (!$currentUser) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$categorySql = "SELECT categoryID, categoryname, categoryicon, description
                FROM wishcategories
                ORDER BY categoryID";
$categoryResult = mysqli_query($conn, $categorySql);

$pageTitle = "Add Wish";
require __DIR__ . "/includes/header.php";
?>

<h2>Add New Wish</h2>

<p><a href="home.php">Back</a></p>

<form action="process_create_wish.php" method="POST">
    <table border="1" cellpadding="8">
        <tr>
            <th>Name</th>
            <th>Gender</th>
            <th>Category</th>
            <th>Wish Text</th>
            <th>Action</th>
        </tr>
        <tr>
            <td>
                <?php
                echo htmlspecialchars(
                    $currentUser["first_name"] . " " . $currentUser["last_name"]
                );
                ?>
            </td>
            <td>
                <?php echo htmlspecialchars($currentUser["gender"]); ?>
            </td>
            <td>
                <select name="categoryID" required>
                    <option value="">Please select</option>

                    <?php while ($category = mysqli_fetch_assoc($categoryResult)) { ?>
                        <option value="<?php echo htmlspecialchars($category["categoryID"]); ?>">
                            <?php
                            echo htmlspecialchars(
                                $category["categoryicon"] . " " .
                                $category["categoryname"] . " - " .
                                $category["description"]
                            );
                            ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
            <td>
                <textarea name="wishtext" rows="5" cols="40" required></textarea>
            </td>
            <td>
                <input type="submit" value="Add">
            </td>
        </tr>
    </table>
</form>

<?php
mysqli_close($conn);
require __DIR__ . "/includes/footer.php";
?>
