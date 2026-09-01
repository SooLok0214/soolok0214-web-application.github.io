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
$avatarSource = "images/sakura.svg";
$savedAvatar = $currentUser["profileimage"] ?? "";
if ($savedAvatar != "" && basename($savedAvatar) == $savedAvatar && is_file(__DIR__ . "/uploads/" . $savedAvatar)) {
    $avatarSource = "uploads/" . rawurlencode($savedAvatar);
}
$pageTitle = "Update Profile";
$pageCss = "css/profile.css?v=20260730-24";
require "includes/header.php";
?>
<section class="profile-page update-profile-page">
    <section class="profile-edit-card">
        <div class="profile-section-heading">
            <p>EDIT PROFILE</p>
            <h3>Update Personal Details</h3>
            <span>
                Update your shrine profile and save your changes.
            </span>
        </div>
        <label
            class="profile-icon-row profile-avatar-upload"
            for="profileimage">
            <img
                id="profile-image-preview"
                src="<?php echo htmlspecialchars($avatarSource); ?>"
                alt="Current profile image">
            <div>
                <strong>Update Profile Image</strong>
                <small>
                    JPG, PNG or WEBP &middot; Maximum 2MB
                </small>
            </div>
        </label>
        <form
            id="profile-update-form"
            class="profile-form"
            method="POST"
            action="profile.php"
            enctype="multipart/form-data"
            novalidate>
            <input
                class="profile-file-input"
                id="profileimage"
                type="file"
                name="profileimage"
                accept="image/jpeg,image/png,image/webp">
            <label>
                <span>Username</span>
                <input
                    type="text"
                    name="username"
                    value="<?php echo htmlspecialchars($currentUser["username"]); ?>">
            </label>
            <label>
                <span>Email</span>
                <input
                    type="email"
                    name="email"
                    value="<?php echo htmlspecialchars($currentUser["email"]); ?>">
            </label>
            <label>
                <span>New Password</span>
                <input
                    type="password"
                    name="password"
                    minlength="6"
                    autocomplete="new-password">
                <small>
                    Leave blank if you do not want to change it.
                </small>
            </label>
            <label>
                <span>Confirm New Password</span>
                <input
                    type="password"
                    name="confirm_password"
                    minlength="6"
                    autocomplete="new-password">
            </label>
            <label>
                <span>Phone Number</span>
                <input
                    type="tel"
                    name="phonenumber"
                    inputmode="tel"
                    pattern="\+?[0-9]{9,11}"
                    maxlength="12"
                    title="Enter 9 to 11 numbers, with an optional + at the beginning."
                    oninput="this.value = this.value.replace(/[^0-9+]/g, '').replace(/(?!^)\+/g, '').slice(0, this.value.startsWith('+') ? 12 : 11);"
                    value="<?php echo htmlspecialchars($currentUser["phonenumber"]); ?>">
            </label>
            <fieldset class="gender-field">
                <legend>Gender</legend>
                <div class="gender-options">
                    <label class="gender-option">
                        <input
                            type="radio"
                            name="gender"
                            value="male"
                            <?php
                            if ($currentUser["gender"] == "male") {
                                echo "checked";
                            }
                            ?>
                            >
                        <span>Male</span>
                    </label>
                    <label class="gender-option">
                        <input
                            type="radio"
                            name="gender"
                            value="female"
                            <?php
                            if ($currentUser["gender"] == "female") {
                                echo "checked";
                            }
                            ?>
                            >
                        <span>Female</span>
                    </label>
                </div>
            </fieldset>
            <p
                id="profile-form-message"
                class="profile-form-message"
                role="alert"
                aria-live="polite"></p>
            <input
                class="profile-button"
                type="submit"
                value="Save Changes">
        </form>
    </section>
</section>
<script>
    const profileUpdateForm = document.getElementById("profile-update-form");
    const profileFormMessage = document.getElementById("profile-form-message");
    const profileImageInput = document.getElementById("profileimage");
    const profileImagePreview = document.getElementById("profile-image-preview");
    function showProfileWarning(message, field) {
        profileFormMessage.textContent = message;
        profileFormMessage.classList.add("is-visible");
        if (field) {
            field.focus();
        }
    }
    function clearProfileWarning() {
        profileFormMessage.textContent = "";
        profileFormMessage.classList.remove("is-visible");
    }
    profileUpdateForm.addEventListener("submit", function(event) {
        const usernameField = this.elements.username;
        const emailField = this.elements.email;
        const passwordField = this.elements.password;
        const confirmPasswordField = this.elements.confirm_password;
        const phoneField = this.elements.phonenumber;
        const genderField = this.querySelector('input[name="gender"]:checked');
        clearProfileWarning();
        if (!usernameField.value.trim() || !emailField.value.trim() || !phoneField.value.trim() || !genderField) {
            event.preventDefault();
            showProfileWarning("Please fill in all fields.", !usernameField.value.trim() ? usernameField : !emailField.value.trim() ? emailField : !phoneField.value.trim() ? phoneField : null);
            return;
        }
        if (!emailField.validity.valid) {
            event.preventDefault();
            showProfileWarning("Email format is incorrect.", emailField);
            return;
        }
        if (!/^\+?[0-9]{9,11}$/.test(phoneField.value.trim())) {
            event.preventDefault();
            showProfileWarning("Phone Number must contain 9 to 11 numbers, with an optional + at the beginning.", phoneField);
            return;
        }
        if (passwordField.value && passwordField.value.length < 6) {
            event.preventDefault();
            showProfileWarning("New Password must contain at least 6 characters.", passwordField);
            return;
        }
        if (passwordField.value !== confirmPasswordField.value) {
            event.preventDefault();
            showProfileWarning("Password and Confirm Password do not match.", confirmPasswordField);
        }
    });
    profileUpdateForm.addEventListener("input", clearProfileWarning);
    profileImageInput.addEventListener("change", function() {
        const imageFile = this.files[0];
        if (!imageFile) {
            return;
        }
        const allowedTypes = [
            "image/jpeg",
            "image/png",
            "image/webp"
        ];
        if (
            !allowedTypes.includes(imageFile.type) ||
            imageFile.size > 2 * 1024 * 1024
        ) {
            this.value = "";
            showProfileWarning(
                "Please select a JPG, PNG or WEBP image within 2MB.",
                this
            );
            return;
        }
        clearProfileWarning();
        profileImagePreview.src = URL.createObjectURL(imageFile);
    });
</script>
<?php
$conn->close();
require "includes/footer.php";
