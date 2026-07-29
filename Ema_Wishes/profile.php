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
$currentUser = $conn->query("SELECT * FROM users WHERE email = '$email'")->fetch_assoc();
if (!$currentUser) {
    session_destroy();
    header("Location: index.php");
    exit();
}
$userID = $conn->real_escape_string($currentUser["userID"]);
$message = "";
if (isset($_GET["deleted"])) {
    $message = "Wish deleted successfully.";
} elseif (isset($_GET["deleteError"])) {
    $message = "Unable to delete this wish.";
}
$avatarFileName = $currentUser["profileimage"] ?? "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameValue = trim($_POST["username"] ?? "");
    $emailValue = trim($_POST["email"] ?? "");
    $passwordValue = $_POST["password"] ?? "";
    $confirmPasswordValue = $_POST["confirm_password"] ?? "";
    $phoneValue = trim($_POST["phonenumber"] ?? "");
    $genderValue = $_POST["gender"] ?? "";
    $pendingAvatar = null;
    $uploadedAvatarPath = "";
    if ($usernameValue == "" || $emailValue == "" || $phoneValue == "" || $genderValue == "") {
        $message = "Please fill in all fields.";
    } elseif (!filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
        $message = "Email format is incorrect.";
    } elseif (!preg_match("/^\+?[0-9]+$/", $phoneValue)) {
        $message = "Phone Number can only contain numbers and an optional + at the beginning.";
    } elseif ($passwordValue != "" && strlen($passwordValue) < 6) {
        $message = "New Password must contain at least 6 characters.";
    } elseif ($passwordValue != $confirmPasswordValue) {
        $message = "Password and Confirm Password do not match.";
    } elseif ($genderValue != "male" && $genderValue != "female") {
        $message = "Please select a valid gender.";
    }
    if ($message == "") {
        $safeUsername = $conn->real_escape_string($usernameValue);
        $safeEmail = $conn->real_escape_string($emailValue);
        $duplicateUser = $conn->query("SELECT userID FROM users WHERE (username = '$safeUsername' OR email = '$safeEmail') AND userID != '$userID'")->fetch_assoc();
        if ($duplicateUser) {
            $message = "Username or Email already exists.";
        }
    }
    if ($message == "" && isset($_FILES["profileimage"]) && $_FILES["profileimage"]["error"] != UPLOAD_ERR_NO_FILE) {
        if ($_FILES["profileimage"]["error"] != UPLOAD_ERR_OK) {
            $message = "Profile image upload failed. Please select the image again.";
        } elseif ($_FILES["profileimage"]["size"] > 2 * 1024 * 1024) {
            $message = "Profile image must not exceed 2MB.";
        } else {
            $fileInfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $fileInfo->file($_FILES["profileimage"]["tmp_name"]);
            $allowedImageTypes = [
                "image/jpeg" => "jpg",
                "image/png" => "png",
                "image/webp" => "webp"
            ];
            if (!isset($allowedImageTypes[$mimeType])) {
                $message = "Only JPG, PNG or WEBP images are accepted.";
            } else {
                $pendingAvatar = [
                    "temporaryPath" => $_FILES["profileimage"]["tmp_name"],
                    "extension" => $allowedImageTypes[$mimeType]
                ];
            }
        }
    }
    if ($message == "" && $pendingAvatar) {
        $uploadDirectory = __DIR__ . "/uploads";
        if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true)) {
            $message = "Unable to create the profile image folder.";
        } else {
            $safeUserID = preg_replace("/[^A-Za-z0-9]/", "", $userID);
            $newAvatarFileName = "avatar_" . $safeUserID . "_" . bin2hex(random_bytes(8)) . "." . $pendingAvatar["extension"];
            $uploadedAvatarPath = $uploadDirectory . "/" . $newAvatarFileName;
            if (!move_uploaded_file($pendingAvatar["temporaryPath"], $uploadedAvatarPath)) {
                $message = "Unable to save the profile image.";
                $uploadedAvatarPath = "";
            } else {
                $avatarFileName = $newAvatarFileName;
            }
        }
    }
    if ($message == "") {
        $safeUsername = $conn->real_escape_string($usernameValue);
        $safeEmail = $conn->real_escape_string($emailValue);
        $safePhone = $conn->real_escape_string($phoneValue);
        $safeGender = $conn->real_escape_string($genderValue);
        $safeAvatar = $conn->real_escape_string($avatarFileName);
        $passwordSql = "";
        if ($passwordValue != "") {
            $safePassword = $conn->real_escape_string($passwordValue);
            $passwordSql = ", password = '$safePassword'";
        }
        $updateSql = "UPDATE users SET username = '$safeUsername', email = '$safeEmail', phonenumber = '$safePhone', gender = '$safeGender', profileimage = '$safeAvatar'$passwordSql WHERE userID = '$userID'";
        if ($conn->query($updateSql)) {
            $wishName = ucfirst(str_replace("_", "", $usernameValue));
            $safeWishName = $conn->real_escape_string($wishName);
            $conn->query("UPDATE wishes SET name = '$safeWishName', gender = '$safeGender' WHERE userID = '$userID'");
            $_SESSION["email"] = $emailValue;
            $message = "Profile updated successfully.";
            $oldAvatarFileName = $currentUser["profileimage"] ?? "";
            if ($avatarFileName != $oldAvatarFileName && $oldAvatarFileName != "" && basename($oldAvatarFileName) == $oldAvatarFileName) {
                $oldAvatarPath = __DIR__ . "/uploads/" . $oldAvatarFileName;
                if (is_file($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }
            $currentUser = $conn->query("SELECT * FROM users WHERE userID = '$userID'")->fetch_assoc();
        } else {
            $message = "Unable to update profile: " . $conn->error;
            if ($uploadedAvatarPath != "" && is_file($uploadedAvatarPath)) {
                unlink($uploadedAvatarPath);
            }
        }
    }
}
$avatarSource = "images/sakura.svg";
$savedAvatar = $currentUser["profileimage"] ?? "";
if ($savedAvatar != "" && basename($savedAvatar) == $savedAvatar && is_file(__DIR__ . "/uploads/" . $savedAvatar)) {
    $avatarSource = "uploads/" . rawurlencode($savedAvatar);
}
$statsSql = "SELECT COUNT(cardID) AS totalWishes, COUNT(DISTINCT categoryID) AS totalThemes, MIN(wishdate) AS firstWishDate FROM wishes WHERE userID = '$userID'";
$wishStats = $conn->query($statsSql)->fetch_assoc();
$historySql = "SELECT w.cardID, w.wishtext, w.wishdate, c.categoryicon, c.categoryname FROM wishes w LEFT JOIN wishcategories c ON w.categoryID = c.categoryID WHERE w.userID = '$userID' ORDER BY w.wishdate DESC, w.cardID DESC";
$historyResult = $conn->query($historySql);
$wishHistory = [];
while ($wish = $historyResult->fetch_assoc()) {
    $wishHistory[] = $wish;
}
$categorySql = "SELECT c.categoryID, c.categoryicon, c.categoryname, COUNT(w.cardID) AS total FROM wishcategories c LEFT JOIN wishes w ON c.categoryID = w.categoryID AND w.userID = '$userID' GROUP BY c.categoryID, c.categoryicon, c.categoryname ORDER BY c.categoryID";
$categoryResult = $conn->query($categorySql);
$categoryRecords = [];
while ($category = $categoryResult->fetch_assoc()) {
    $categoryRecords[] = $category;
}
$joinedDate = date("F Y", strtotime($currentUser["created_time"]));
if ($wishStats["firstWishDate"]) {
    $firstWishDate = date("M d, Y", strtotime($wishStats["firstWishDate"]));
} else {
    $firstWishDate = "—";
}
$pageTitle = "Profile";
$pageCss = "css/profile.css?v=20260730-23";
require "includes/header.php";
?>
<section class="profile-page">
    <section class="profile-overview">
        <div class="profile-avatar">
            <img
                src="<?php echo $avatarSource; ?>"
                alt="<?php echo $currentUser["username"]; ?> profile image">
            <a
                class="avatar-badge"
                href="update_profile.php"
                aria-label="Update profile">
                <span aria-hidden="true">&#9881;</span>
            </a>
        </div>
        <p class="profile-kicker">MY EMA RECORD</p>
        <h2>
            <?php echo $currentUser["username"]; ?>'s Wish Record
        </h2>
        <p class="profile-joined">
            @<?php echo $currentUser["username"]; ?>
            · Joined <?php echo $joinedDate; ?>
        </p>
        <div class="profile-stats">
            <article>
                <span>願</span>
                <div>
                    <strong>
                        <?php echo $wishStats["totalWishes"]; ?>
                    </strong>
                    <small>Total Wishes</small>
                </div>
            </article>
            <article>
                <span>籤</span>
                <div>
                    <strong>
                        <?php echo $wishStats["totalThemes"]; ?>
                    </strong>
                    <small>Wish Themes</small>
                </div>
            </article>
            <article>
                <span>日</span>
                <div>
                    <strong>
                        <?php echo $firstWishDate; ?>
                    </strong>
                    <small>First Wish</small>
                </div>
            </article>
        </div>
    </section>
    <?php if ($message != "") { ?>
        <p class="profile-message">
            <?php echo $message; ?>
        </p>
    <?php } ?>
    <section class="profile-history">
        <div class="profile-section-heading">
            <p>WISH HISTORY</p>
            <h3>Wishes You Have Hung</h3>
            <span>
                <?php echo count($wishHistory); ?>
                <?php
                echo count($wishHistory) == 1
                    ? "wish"
                    : "wishes";
                ?>
                recorded at the shrine.
            </span>
        </div>
        <?php if (count($wishHistory) == 0) { ?>
            <div class="profile-empty-history">
                <strong>EMA</strong>
                <h4>No Wishes Yet</h4>
                <p>
                    Write your first wish and let it rest gently
                    on the wish wall.
                </p>
                <a href="create_wish.php">
                    Make Your First Wish →
                </a>
            </div>
        <?php } else { ?>
            <div class="profile-wish-list">
                <details class="profile-wish-folder">
                    <summary>
                        <span>Wish Archive</span>
                        <small>
                            <?php echo count($wishHistory); ?>
                            <?php
                            echo count($wishHistory) == 1
                                ? "wish"
                                : "wishes";
                            ?>
                        </small>
                    </summary>
                    <div class="profile-folder-contents">
                        <?php foreach ($wishHistory as $wish) { ?>
                            <article>
                                <div>
                                    <span>
                                        <?php
                                        echo $wish["categoryicon"] .
                                            " " .
                                            $wish["categoryname"];
                                        ?>
                                    </span>
                                    <div class="profile-wish-actions">
                                        <small>
                                            <time datetime="<?php echo $wish["wishdate"]; ?>">
                                                <?php
                                                echo date(
                                                    "M d, Y",
                                                    strtotime($wish["wishdate"])
                                                );
                                                ?>
                                            </time>
                                            &middot;
                                            <?php echo $wish["cardID"]; ?>
                                        </small>
                                        <form
                                            method="POST"
                                            action="delete_wish.php"
                                            onsubmit="return confirm('Delete this wish?');">
                                            <input
                                                type="hidden"
                                                name="cardID"
                                                value="<?php echo $wish["cardID"]; ?>">
                                            <button type="submit">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <p>
                                    &ldquo;<?php echo $wish["wishtext"]; ?>&rdquo;
                                </p>
                            </article>
                        <?php } ?>
                    </div>
                </details>
            </div>
        <?php } ?>
    </section>
    <section class="category-records">
        <h3>Wish Theme Records</h3>
        <div>
            <?php foreach ($categoryRecords as $category) { ?>
                <p>
                    <span>
                        <?php
                        echo $category["categoryicon"] .
                            " " .
                            $category["categoryname"];
                        ?>
                    </span>
                    <strong>
                        <?php echo $category["total"]; ?>
                        wishes
                    </strong>
                </p>
            <?php } ?>
        </div>
    </section>
    <a
        class="profile-edit-launch profile-bottom-edit"
        href="update_profile.php">
        Update Profile
    </a>
    <form
        class="delete-account-form"
        action="delete_account.php"
        method="POST"
        onsubmit="return confirm('Delete your account permanently? This will also delete all of your wishes and cannot be undone.');">
        <p>Delete your account and all wishes permanently.</p>
        <button type="submit">Delete Account</button>
    </form>
</section>
<?php
$conn->close();
require "includes/footer.php";
?>
