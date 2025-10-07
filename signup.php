<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['pswd'];
    $confirmPassword = $_POST['pswd_re'];

    // Basic validation
    if (!preg_match("/^[A-Za-z ]+$/", $username)) {
        die("Username can only contain letters and spaces.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }
    if (strlen($password) < 6 || !preg_match("/[0-9]/", $password) || !preg_match("/[A-Za-z]/", $password)) {
        die("Password must be at least 6 chars, include letters and numbers.");
    }
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Store in DB
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
