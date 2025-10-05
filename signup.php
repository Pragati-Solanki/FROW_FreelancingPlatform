<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['pswd'];
    $confirmPassword = $_POST['pswd_re'];

    // Password check
    if ($password !== $confirmPassword) {
        echo "<h3 style='color:red;'>Passwords do not match. Please try again.</h3>";
        exit;
    }

    // Format data neatly
    $data = "Username: $username" . PHP_EOL .
            "Email: $email" . PHP_EOL .
            "Password: $password" . PHP_EOL .
            "------------------------" . PHP_EOL;

    // Save to users.txt
    if (file_put_contents("users.txt", $data, FILE_APPEND | LOCK_EX)) {
        echo "<h2>Registration Successful!</h2>";
        echo "<p>Welcome, <strong>$username</strong>. Your details have been saved.</p>";
    } else {
        echo "<h3 style='color:red;'>Error saving your data. Please try again.</h3>";
    }
}
?>
