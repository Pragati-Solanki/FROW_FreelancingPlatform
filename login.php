<?php
session_start();

// Hardcoded username/password pairs
$users = [
    "alice" => "password123",
    "bob"   => "secure456",
    "admin" => "adminpass"
];

$username = $_POST['username'] ?? '';
$password = $_POST['pswd'] ?? '';

if (isset($users[$username]) && $users[$username] === $password) {
    $_SESSION['username'] = $username;

    // optional "remember me"
    if (!empty($_POST['remember'])) {
        setcookie("username", $username, time() + (7 * 24 * 60 * 60), "/");
    }

    header("Location: session.php");
    exit;
} else {
    echo "Invalid username or password.";
}
?>
