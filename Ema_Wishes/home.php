<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}
$conn = new mysqli("localhost", "Ema_Wishes", "123123", "ema_wishes");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
$email = $conn->real_escape_string($_SESSION["email"]);
$currentUser = $conn->query("SELECT userID, username FROM users WHERE email = '$email'")->fetch_assoc();
if (!$currentUser) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$categorySql = "SELECT c.categoryID, c.categoryname, c.categoryicon, COUNT(w.cardID) AS total FROM wishcategories c LEFT JOIN wishes w ON w.categoryID = c.categoryID GROUP BY c.categoryID, c.categoryname, c.categoryicon ORDER BY c.categoryID";
$categoryResult = $conn->query($categorySql) or die("Couldn't execute category query");
$categories = [];
$allWishesTotal = 0;
while ($category = $categoryResult->fetch_assoc()) {
    $categories[] = $category;
    $allWishesTotal += $category["total"];
}
$selectedCategoryID = $conn->real_escape_string($_GET["categoryID"] ?? "");
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
$wishSql = "SELECT w.cardID, w.wishtext, w.hideUser, w.wishdate, CASE WHEN w.hideUser = 1 THEN 'Anonymous' ELSE w.name END AS displayname, CASE WHEN w.hideUser = 1 THEN 'Gender not disclosed' ELSE CONCAT(UPPER(LEFT(w.gender, 1)), SUBSTRING(w.gender, 2)) END AS displaygender, c.categoryID, c.categoryname, c.categoryicon FROM wishes w LEFT JOIN wishcategories c ON w.categoryID = c.categoryID";
if ($selectedCategoryID != "") {
    $wishSql .= " WHERE w.categoryID = '$selectedCategoryID'";
}
$wishSql .= " ORDER BY w.wishdate DESC, w.cardID DESC";
$wishResult = $conn->query($wishSql) or die("Couldn't execute wish query");
$wishes = [];
while ($wish = $wishResult->fetch_assoc()) {
    $wishes[] = $wish;
}
$totalWishes = count($wishes);
$wishRows = $totalWishes > 0 ? array_chunk($wishes, ceil($totalWishes / 2)) : [];
$selectedThemeLabel = $selectedCategory ? $selectedCategory["categoryname"] . " (" . $totalWishes . " wishes)" : "All Themes (" . $allWishesTotal . " wishes)";
$pageTitle = "Wish Wall";
$pageCss = "css/home.css?v=20260730-10";
require "includes/header.php";
?>
<section class="home-hero">
    <p class="home-kicker">SAKURA EMA WALL</p>
    <h2>
        Welcome,
        <?php echo htmlspecialchars($currentUser["username"]); ?>.
    </h2>
    <p>
        Every ema carries a sincere hope. Read a wish,
        share a little kindness, and let it rest in the spring breeze.
    </p>
</section>
<section class="wish-wall">
    <div class="wall-heading">
        <span class="shrine-crest">結</span>
        <div>
            <span class="wall-kicker">SAKURA EMA SHRINE</span>
            <h2>Wish Wall</h2>
            <p>
                <?php echo $totalWishes; ?>
                wishes are hanging in this view.
            </p>
        </div>
    </div>
    <div class="home-theme-select">
        <span class="theme-filter-label">Wish Theme</span>
        <details class="theme-dropdown">
            <summary>
                <span>
                    <?php echo htmlspecialchars($selectedThemeLabel); ?>
                </span>
            </summary>
            <nav
                class="theme-dropdown-menu"
                aria-label="Wish theme options">
                <a
                    class="<?php echo $selectedCategoryID == "" ? "active" : ""; ?>"
                    href="home.php">
                    All Themes
                    (<?php echo $allWishesTotal; ?> wishes)
                </a>
                <?php foreach ($categories as $category) { ?>
                    <a
                        class="<?php
                                echo $selectedCategoryID == $category["categoryID"]
                                    ? "active"
                                    : "";
                                ?>"
                        href="home.php?categoryID=<?php echo $category["categoryID"]; ?>">
                        <?php
                        echo htmlspecialchars($category["categoryicon"]) .
                            " &middot; " .
                            htmlspecialchars($category["categoryname"]) .
                            " (" .
                            $category["total"] .
                            " wishes)";
                        ?>
                    </a>
                <?php } ?>
            </nav>
        </details>
    </div>
    <div class="ema-rack">
        <div class="rack-plaque">
            <strong>EMA KAKE-DOKORO</strong>
            <small>WISHES HUNG WITH HOPE</small>
        </div>
        <div class="wish-grid">
            <?php if ($totalWishes == 0) { ?>
                <div class="empty-wishes">
                    <span>&#10047;</span>
                    <p>
                        No wishes have been added to this theme yet.
                    </p>
                </div>
            <?php } ?>
            <?php foreach ($wishRows as $rowIndex => $wishRow) { ?>
                <section class="wish-row-section">
                    <div
                        class="wish-row"
                        tabindex="0"
                        aria-label="Wish row <?php echo $rowIndex + 1; ?>">
                        <?php foreach ($wishRow as $wish) { ?>
                            <article class="wish-card">
                                <span
                                    class="ema-knot"
                                    aria-hidden="true"></span>
                                <div class="wish-card-top">
                                    <span class="category-stamp">
                                        <?php
                                        echo htmlspecialchars(
                                            $wish["categoryicon"]
                                        ) . " " .
                                            htmlspecialchars(
                                                $wish["categoryname"]
                                            );
                                        ?>
                                    </span>
                                    <time
                                        datetime="<?php echo $wish["wishdate"]; ?>">
                                        <?php
                                        echo date(
                                            "M d",
                                            strtotime($wish["wishdate"])
                                        );
                                        ?>
                                    </time>
                                </div>
                                <p class="wish-text">
                                    &ldquo;<?php
                                            echo htmlspecialchars(
                                                $wish["wishtext"]
                                            );
                                            ?>&rdquo;
                                </p>
                                <div class="wish-person">
                                    <div>
                                        <strong>
                                            <?php
                                            echo htmlspecialchars(
                                                $wish["displayname"]
                                            );
                                            ?>
                                        </strong>
                                        <small>
                                            <?php
                                            echo htmlspecialchars(
                                                $wish["displaygender"]
                                            );
                                            ?>
                                        </small>
                                    </div>
                                    <span>
                                        <?php
                                        echo htmlspecialchars(
                                            $wish["cardID"]
                                        );
                                        ?>
                                    </span>
                                </div>
                            </article>
                        <?php } ?>
                    </div>
                </section>
            <?php } ?>
        </div>
    </div>
</section>
<div class="bottom-wish-action">
    <a class="add-wish-button" href="create_wish.php">
        Add New Wish
    </a>
</div>
<?php
$conn->close();
require "includes/footer.php";
