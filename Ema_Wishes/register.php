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

if (isset($_SESSION["userID"])) {
    header("Location: home.php");
    exit();
}

$message = "";
$usernameValue = "";
$emailValue = "";
$firstNameValue = "";
$lastNameValue = "";
$phoneValue = "";
$genderValue = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameValue = trim($_POST["username"] ?? "");
    $emailValue = trim($_POST["email"] ?? "");
    $passwordValue = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";
    $firstNameValue = trim($_POST["first_name"] ?? "");
    $lastNameValue = trim($_POST["last_name"] ?? "");
    $phoneValue = trim($_POST["phonenumber"] ?? "");
    $genderValue = $_POST["gender"] ?? "";

    if (
        $usernameValue == "" || $emailValue == "" || $passwordValue == "" ||
        $firstNameValue == "" || $lastNameValue == "" || $phoneValue == "" || $genderValue == ""
    ) {
        $message = "Please fill in all fields.";
    } else if (!filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
        $message = "Email format is incorrect.";
    } else if ($passwordValue != $confirmPassword) {
        $message = "Passwords do not match.";
    } else if ($genderValue != "male" && $genderValue != "female") {
        $message = "Please select a valid gender.";
    } else {
        $checkSql = "SELECT userID FROM users WHERE username = ? OR email = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("ss", $usernameValue, $emailValue);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $message = "Username or Email already exists.";
        } else {
            $idResult = $conn->query(
                "SELECT MAX(CAST(SUBSTRING(userID, 2) AS UNSIGNED)) AS largestID FROM users"
            );
            $idRow = $idResult->fetch_assoc();
            $nextNumber = (int) $idRow["largestID"] + 1;

            if ($nextNumber < 1001) {
                $nextNumber = 1001;
            }

            $newUserID = "U" . $nextNumber;

            $insertSql = "INSERT INTO users
                (username, email, password, first_name, last_name, phonenumber, gender, userID, created_time)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param(
                "ssssssss",
                $usernameValue,
                $emailValue,
                $passwordValue,
                $firstNameValue,
                $lastNameValue,
                $phoneValue,
                $genderValue,
                $newUserID
            );

            if ($insertStmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                $message = "Registration failed: " . $conn->error;
            }

            $insertStmt->close();
        }

        $checkStmt->close();
    }
}

$pageTitle = "Register";
require __DIR__ . "/includes/header.php";
?>

<h2>Register</h2>

<?php if ($message != "") { ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php } ?>

<form method="POST" action="register.php">
    <label>Username:</label><br>
    <input type="text" name="username" value="<?php echo htmlspecialchars($usernameValue); ?>" required>
    <br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($emailValue); ?>" required>
    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required>
    <br><br>

    <label>Confirm Password:</label><br>
    <input type="password" name="confirm_password" required>
    <br><br>

    <label>First Name:</label><br>
    <input type="text" name="first_name" value="<?php echo htmlspecialchars($firstNameValue); ?>" required>
    <br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" value="<?php echo htmlspecialchars($lastNameValue); ?>" required>
    <br><br>

    <label>Phone Number:</label><br>
    <input type="text" name="phonenumber" value="<?php echo htmlspecialchars($phoneValue); ?>" required>
    <br><br>

    <label>Gender:</label><br>
    <select name="gender" required>
        <option value="">Please select</option>
        <option value="male" <?php if ($genderValue == "male") echo "selected"; ?>>Male</option>
        <option value="female" <?php if ($genderValue == "female") echo "selected"; ?>>Female</option>
    </select>
    <br><br>

    <input type="submit" value="Register">
</form>

<p>Already have an account? <a href="index.php">Login</a></p>

<?php require __DIR__ . "/includes/footer.php"; ?>
