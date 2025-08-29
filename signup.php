<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['pswd']);
    $confirmPassword = htmlspecialchars($_POST['pswd_re']);

    if ($password !== $confirmPassword) {
        echo "<h3 style='color:red;'>Passwords do not match. Please try again.</h3>";
        exit;
    }

    $data = "Username: $username | Email: $email | Password: $password" . PHP_EOL;

    if (file_put_contents("users.txt", $data, FILE_APPEND | LOCK_EX)) {
        echo "<h2>Registration Successful!</h2>";
        echo "<p>Welcome, <strong>$username</strong>. Your details have been saved.</p>";
    } else {
        echo "<h3 style='color:red;'>Error saving your data. Please try again.</h3>";
    }
}
?>
