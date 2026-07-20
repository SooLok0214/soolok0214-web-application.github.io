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
$userSql = "SELECT * FROM users WHERE email = ?";
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

$userID = $currentUser["userID"];

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameValue = trim($_POST["username"] ?? "");
    $emailValue = trim($_POST["email"] ?? "");
    $passwordValue = $_POST["password"] ?? "";
    $phoneValue = trim($_POST["phonenumber"] ?? "");
    $genderValue = $_POST["gender"] ?? "";

    if (
        $usernameValue == "" || $emailValue == "" ||
        $phoneValue == "" || $genderValue == ""
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
        $checkStmt->bind_param("sss", $usernameValue, $emailValue, $userID);
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
                          username = ?, email = ?, phonenumber = ?, gender = ?
                          WHERE userID = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param(
                "sssss",
                $usernameValue,
                $emailValue,
                $phoneValue,
                $genderValue,
                $userID
            );
        } else {
            $updateSql = "UPDATE users SET
                          username = ?, email = ?, password = ?, phonenumber = ?, gender = ?
                          WHERE userID = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param(
                "ssssss",
                $usernameValue,
                $emailValue,
                $passwordValue,
                $phoneValue,
                $genderValue,
                $userID
            );
        }

        if ($updateStmt->execute()) {
            $wishName = ucfirst(str_replace("_", "", $usernameValue));
            $wishSql = "UPDATE wishes SET name = ?, gender = ? WHERE userID = ?";
            $wishStmt = $conn->prepare($wishSql);
            $wishStmt->bind_param("sss", $wishName, $genderValue, $userID);
            $wishStmt->execute();
            $wishStmt->close();

            $_SESSION["email"] = $emailValue;

            $message = "Profile updated successfully.";

            $refreshSql = "SELECT * FROM users WHERE userID = ?";
            $refreshStmt = $conn->prepare($refreshSql);
            $refreshStmt->bind_param("s", $userID);
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
    <p><?php echo $message; ?></p>
<?php } ?>

<p>User ID: <?php echo $currentUser["userID"]; ?></p>
<p>Created Time: <?php echo $currentUser["created_time"]; ?></p>

<form method="POST" action="profile.php">
    <label>Username:</label><br>
    <input type="text" name="username" value="<?php echo $currentUser["username"]; ?>" required>
    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo $currentUser["email"]; ?>" required>
    <br><br>

    <label>New Password:</label><br>
    <input type="password" name="password">
    <small>Leave blank if you do not want to change it.</small>
    <br><br>

    <label>Phone Number:</label><br>
    <input type="text" name="phonenumber" value="<?php echo $currentUser["phonenumber"]; ?>" required>
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
