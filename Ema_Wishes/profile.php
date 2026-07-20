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

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameValue = trim($_POST["username"] ?? "");
    $emailValue = trim($_POST["email"] ?? "");
    $passwordValue = $_POST["password"] ?? "";
    $firstNameValue = trim($_POST["first_name"] ?? "");
    $lastNameValue = trim($_POST["last_name"] ?? "");
    $phoneValue = trim($_POST["phonenumber"] ?? "");
    $genderValue = $_POST["gender"] ?? "";

    if (
        $usernameValue == "" || $emailValue == "" || $firstNameValue == "" ||
        $lastNameValue == "" || $phoneValue == "" || $genderValue == ""
    ) {
        $message = "Please fill in all fields.";
    } else if (!filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
        $message = "Email format is incorrect.";
    } else if ($genderValue != "male" && $genderValue != "female") {
        $message = "Please select a valid gender.";
    } else {
        $checkSql = "SELECT userID FROM users
                     WHERE (username = ? OR email = ?) AND userID != ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("sss", $usernameValue, $emailValue, $_SESSION["userID"]);
        $checkStmt->execute();
        $duplicateUser = $checkStmt->get_result()->fetch_assoc();
        $checkStmt->close();

        if ($duplicateUser) {
            $message = "Username or Email already exists.";
        }
    }

    if ($message == "") {
        if ($passwordValue == "") {
            $updateSql = "UPDATE users SET
                          username = ?, email = ?, first_name = ?, last_name = ?,
                          phonenumber = ?, gender = ?
                          WHERE userID = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param(
                "sssssss",
                $usernameValue,
                $emailValue,
                $firstNameValue,
                $lastNameValue,
                $phoneValue,
                $genderValue,
                $_SESSION["userID"]
            );
        } else {
            $updateSql = "UPDATE users SET
                          username = ?, email = ?, password = ?, first_name = ?, last_name = ?,
                          phonenumber = ?, gender = ?
                          WHERE userID = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param(
                "ssssssss",
                $usernameValue,
                $emailValue,
                $passwordValue,
                $firstNameValue,
                $lastNameValue,
                $phoneValue,
                $genderValue,
                $_SESSION["userID"]
            );
        }

        if ($updateStmt->execute()) {
            $wishName = ucfirst(str_replace("_", "", $usernameValue));
            $wishSql = "UPDATE wishes SET name = ?, gender = ? WHERE userID = ?";
            $wishStmt = $conn->prepare($wishSql);
            $wishStmt->bind_param("sss", $wishName, $genderValue, $_SESSION["userID"]);
            $wishStmt->execute();
            $wishStmt->close();

            $message = "Profile updated successfully.";

            $refreshSql = "SELECT * FROM users WHERE userID = ?";
            $refreshStmt = $conn->prepare($refreshSql);
            $refreshStmt->bind_param("s", $_SESSION["userID"]);
            $refreshStmt->execute();
            $currentUser = $refreshStmt->get_result()->fetch_assoc();
            $refreshStmt->close();
        } else {
            $message = "Unable to update profile: " . $conn->error;
        }

        $updateStmt->close();
    }
}

$pageTitle = "Profile";
require __DIR__ . "/includes/header.php";
?>

<h2>Profile</h2>

<?php if ($message != "") { ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php } ?>

<p>User ID: <?php echo htmlspecialchars($currentUser["userID"]); ?></p>
<p>Created Time: <?php echo htmlspecialchars($currentUser["created_time"]); ?></p>

<form method="POST" action="profile.php">
    <label>Username:</label><br>
    <input type="text" name="username" value="<?php echo htmlspecialchars($currentUser["username"]); ?>" required>
    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($currentUser["email"]); ?>" required>
    <br><br>

    <label>New Password:</label><br>
    <input type="password" name="password">
    <small>Leave blank if you do not want to change it.</small>
    <br><br>

    <label>First Name:</label><br>
    <input type="text" name="first_name" value="<?php echo htmlspecialchars($currentUser["first_name"]); ?>" required>
    <br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" value="<?php echo htmlspecialchars($currentUser["last_name"]); ?>" required>
    <br><br>

    <label>Phone Number:</label><br>
    <input type="text" name="phonenumber" value="<?php echo htmlspecialchars($currentUser["phonenumber"]); ?>" required>
    <br><br>

    <label>Gender:</label><br>
    <select name="gender" required>
        <option value="male" <?php if ($currentUser["gender"] == "male") echo "selected"; ?>>Male</option>
        <option value="female" <?php if ($currentUser["gender"] == "female") echo "selected"; ?>>Female</option>
    </select>
    <br><br>

    <input type="submit" value="Update Profile">
</form>

<?php require __DIR__ . "/includes/footer.php"; ?>
