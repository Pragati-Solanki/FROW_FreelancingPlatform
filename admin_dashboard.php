<?php
session_start();
include('db_connect.php');

// Debug info
echo "<pre>Session data:\n";
print_r($_SESSION);
echo "</pre>";

// Check if logged in
if (!isset($_SESSION['username'])) {
    echo "<h2>Not logged in at all.</h2>";
    exit;
}

// Fetch role from DB
$stmt = $conn->prepare("SELECT role FROM users WHERE username=?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Debug role
echo "<pre>DB query result:\n";
print_r($user);
echo "</pre>";

if (!$user || $user['role'] !== 'admin') {
    echo "<h2>Access denied. Admins only.</h2>";
    exit;
}

echo "<h2>Access granted! You are admin.</h2>";
?>

<?php
include('db_connect.php');

// Check if admin
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Fetch role from DB
$stmt = $conn->prepare("SELECT role FROM users WHERE username=?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || $user['role'] !== 'admin') {
    echo "<h2>Access denied. Admins only.</h2>";
    exit;
}

// Fetch all users
$users = $conn->query("SELECT id, username, email, role FROM users");
?>

<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
<h2>Admin Dashboard - User Management</h2>
<a href="logout.php">Logout</a>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $users->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['id']); ?></td>
        <td><?php echo htmlspecialchars($row['username']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['role']); ?></td>
        <td>
            <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> | 
            <a href="delete_user.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this user?');">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
