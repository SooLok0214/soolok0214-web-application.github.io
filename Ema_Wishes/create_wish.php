<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}
$conn = mysqli_connect("localhost", "Ema_Wishes", "123123", "ema_wishes");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8mb4");
$email = mysqli_real_escape_string($conn, $_SESSION["email"]);
$userResult = mysqli_query($conn, "SELECT userID, username, gender FROM users WHERE email = '$email'");
$currentUser = mysqli_fetch_assoc($userResult);
if (!$currentUser) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$categoryResult = mysqli_query($conn, "SELECT categoryID, categoryname, categoryicon, description FROM wishcategories ORDER BY categoryID");
$error = $_GET["error"] ?? "";
$pageTitle = "Add Wish";
$pageCss = "css/create_wish.css?v=20260901-2";
require "includes/header.php";
?>
<section class="create-page">
    <div class="create-intro">
        <p>WRITE YOUR EMA</p>
        <h2>Make a New Wish</h2>
        <span>Choose a theme and leave a sincere wish on the wall.</span>
    </div>
    <?php if ($error != "") { ?>
        <p class="create-wish-error">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php } ?>
    <form class="create-wish-form"
        action="process_create_wish.php"
        method="POST"
        novalidate>
        <fieldset class="identity-field">
            <legend class="form-step-heading">
                <span class="form-step-number">01</span>
                <span class="form-step-heading-copy">
                    <strong>Your information</strong>
                    <small>
                        Review your details and choose whether to show them.
                    </small>
                </span>
            </legend>
            <div class="wish-user-card">
                <div>
                    <small>Name</small>
                    <strong>
                        <?php echo htmlspecialchars($currentUser["username"]); ?>
                    </strong>
                </div>
                <div>
                    <small>Gender</small>
                    <strong>
                        <?php echo ucfirst(
                            htmlspecialchars($currentUser["gender"])
                        ); ?>
                    </strong>
                </div>
            </div>
            <fieldset class="privacy-field">
                <legend>Hide personal information?</legend>
                <p>
                    Use one privacy setting to hide both your name and gender.
                </p>
                <div class="privacy-choices">
                    <label class="privacy-choice">
                        <input
                            type="checkbox"
                            name="hideUser"
                            value="1"
                            checked>
                        <span class="privacy-choice-panel">
                            <span class="privacy-switch" aria-hidden="true">
                                <span></span>
                            </span>
                            <span class="privacy-copy privacy-copy-on">
                                <strong>Privacy ON</strong>
                                <b>Post anonymously</b>
                                <small>Your name and gender are hidden.</small>
                            </span>
                            <span class="privacy-copy privacy-copy-off">
                                <strong>Privacy OFF</strong>
                                <b>Show my information</b>
                                <small>Your name and gender will appear.</small>
                            </span>
                        </span>
                    </label>
                </div>
            </fieldset>
        </fieldset>
        <fieldset class="wish-theme-field">
            <legend class="form-step-heading">
                <span class="form-step-number">02</span>
                <span class="form-step-heading-copy">
                    <strong>What are you wishing for?</strong>
                    <small>
                        Choose the wish theme closest to your heart.
                    </small>
                </span>
            </legend>
            <div class="wish-theme-grid">
                <?php while ($category = mysqli_fetch_assoc($categoryResult)) { ?>
                    <label class="wish-theme-card">
                        <input
                            type="radio"
                            name="categoryID"
                            value="<?php echo $category["categoryID"]; ?>">
                        <span class="wish-theme-card-content">
                            <strong class="wish-theme-icon">
                                <?php echo htmlspecialchars(
                                    $category["categoryicon"]
                                ); ?>
                            </strong>
                            <span class="wish-theme-name">
                                <?php echo htmlspecialchars(
                                    $category["categoryname"]
                                ); ?>
                            </span>
                            <small>
                                <?php echo htmlspecialchars(
                                    $category["description"]
                                ); ?>
                            </small>
                        </span>
                    </label>
                <?php } ?>
            </div>
        </fieldset>
        <fieldset class="wish-text-field">
            <legend class="form-step-heading">
                <span class="form-step-number">03</span>
                <span class="form-step-heading-copy">
                    <strong>Write your wish</strong>
                    <small>
                        Share the sincere wish you want to leave on the wall.
                    </small>
                </span>
            </legend>
            <label class="form-field">
                <span>Wish Text</span>
                <textarea
                    name="wishtext"
                    rows="6"
                    maxlength="150"
                    placeholder="Write your wish here..."></textarea>
                <small>
                    Write a sincere wish in English or Chinese. Maximum 150 characters.
                </small>
            </label>
        </fieldset>
        <input
            class="create-wish-button"
            type="submit"
            value="Add My Wish">
    </form>
    <p class="back-wall-link">
        <a href="home.php">Return to Wish Wall</a>
    </p>
</section>
<?php
mysqli_close($conn);
require "includes/footer.php";
?>
