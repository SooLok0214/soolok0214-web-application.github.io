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

$categorySql = "SELECT c.categoryID, c.categoryname, c.categoryicon,
                       COUNT(w.cardID) AS total
                FROM wishcategories c
                LEFT JOIN wishes w ON w.categoryID = c.categoryID
                GROUP BY c.categoryID, c.categoryname, c.categoryicon
                ORDER BY c.categoryID";
$categoryResult = $conn->query($categorySql)
    or die("Couldn't execute category query");

$categories = [];
$allWishesTotal = 0;

while ($category = $categoryResult->fetch_assoc()) {
    $categories[] = $category;
    $allWishesTotal += (int) $category["total"];
}

$selectedCategoryID = $_GET["categoryID"] ?? "";
$selectedCategory = null;

foreach ($categories as $category) {
    if ($category["categoryID"] == $selectedCategoryID) {
        $selectedCategory = $category;
        break;
    }
}

if (!$selectedCategory) {
    $selectedCategoryID = "";
}

$wishSql = "SELECT w.cardID, w.wishtext, w.name, w.gender, w.wishdate,
                   c.categoryID, c.categoryname, c.categoryicon
            FROM wishes w
            LEFT JOIN wishcategories c ON w.categoryID = c.categoryID";

if ($selectedCategoryID != "") {
    $wishSql .= " WHERE w.categoryID = ?";
}

$wishSql .= " ORDER BY w.wishdate DESC, w.cardID DESC";

if ($selectedCategoryID != "") {
    $wishStmt = $conn->prepare($wishSql);
    $wishStmt->bind_param("s", $selectedCategoryID);
    $wishStmt->execute();
    $wishResult = $wishStmt->get_result();
} else {
    $wishResult = $conn->query($wishSql)
        or die("Couldn't execute wish query");
}

$wishes = [];

while ($wish = $wishResult->fetch_assoc()) {
    $wishes[] = $wish;
}

$totalWishes = count($wishes);
$wishRows = [];

if ($totalWishes > 0) {
    $itemsPerRow = (int) ceil($totalWishes / 2);
    $wishRows = array_chunk($wishes, $itemsPerRow);
}

$selectedThemeLabel = $selectedCategory
    ? $selectedCategory["categoryname"] . " (" . $totalWishes . " wishes)"
    : "All Themes (" . $allWishesTotal . " wishes)";

$pageTitle = "Wish Wall";
$pageCss = "css/home.css?v=20260729-8";
require __DIR__ . "/includes/header.php";
?>

<section class="home-hero">
    <p class="home-kicker">SAKURA EMA WALL</p>
    <h2>Welcome, <?php echo $currentUser["username"]; ?>.</h2>
    <p>Every ema carries a sincere hope. Read a wish, share a little kindness, and let it rest in the spring breeze.</p>
    <a class="add-wish-button" href="create_wish.php">Add New Wish</a>
</section>

<section class="wish-wall">
    <div class="wall-heading">
        <div>
            <span>EVERYONE'S WISHES</span>
            <h2>Wish Wall</h2>
        </div>
        <p><?php echo $totalWishes; ?> wishes</p>
    </div>

    <div class="home-theme-select">
        <span class="theme-filter-label">Wish Theme</span>

        <details class="theme-dropdown">
            <summary>
                <span><?php echo $selectedThemeLabel; ?></span>
            </summary>

            <nav class="theme-dropdown-menu" aria-label="Wish theme options">
                <a
                    class="<?php echo $selectedCategoryID == "" ? "active" : ""; ?>"
                    href="home.php"
                >
                    All Themes (<?php echo $allWishesTotal; ?> wishes)
                </a>

                <?php foreach ($categories as $category) { ?>
                    <a
                        class="<?php echo $selectedCategoryID == $category["categoryID"] ? "active" : ""; ?>"
                        href="home.php?categoryID=<?php echo $category["categoryID"]; ?>"
                    >
                        <?php
                        echo $category["categoryicon"] . " · " .
                            $category["categoryname"] . " (" .
                            $category["total"] . " wishes)";
                        ?>
                    </a>
                <?php } ?>
            </nav>
        </details>
    </div>

    <div class="wish-grid">
        <?php if ($totalWishes == 0) { ?>
            <div class="empty-wishes">
                <span>✿</span>
                <p>No wishes have been added to this theme yet.</p>
            </div>
        <?php } ?>

        <?php foreach ($wishRows as $rowIndex => $wishRow) { ?>
            <section class="wish-row-section">
                <div
                    class="wish-row"
                    tabindex="0"
                    aria-label="Wish row <?php echo $rowIndex + 1; ?>"
                >
                    <?php foreach ($wishRow as $wish) { ?>
                        <article class="wish-card">
                            <span class="ema-knot" aria-hidden="true"></span>

                            <div class="wish-card-top">
                                <span class="category-stamp">
                                    <?php echo $wish["categoryicon"] . " " . $wish["categoryname"]; ?>
                                </span>
                                <time datetime="<?php echo $wish["wishdate"]; ?>">
                                    <?php echo date("M d", strtotime($wish["wishdate"])); ?>
                                </time>
                            </div>

                            <p class="wish-text">“<?php echo $wish["wishtext"]; ?>”</p>

                            <div class="wish-person">
                                <div>
                                    <strong><?php echo $wish["name"]; ?></strong>
                                    <small><?php echo ucfirst($wish["gender"]); ?></small>
                                </div>
                                <span><?php echo $wish["cardID"]; ?></span>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            </section>
        <?php } ?>
    </div>
</section>

<?php
if (isset($wishStmt)) {
    $wishStmt->close();
}

$conn->close();
require __DIR__ . "/includes/footer.php";
?>
