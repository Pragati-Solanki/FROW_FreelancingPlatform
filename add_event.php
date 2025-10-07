<?php
session_start();
include('db_connect.php');

// Only allow logged-in users
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $date = $_POST['date'];

    // Basic validation
    if (empty($title) || empty($description) || empty($date)) {
        $message = "All fields are required.";
    } elseif (!preg_match("/^[A-Za-z0-9 .,!?-]+$/", $title)) {
        $message = "Title contains invalid characters.";
    } else {
        // Insert event into DB
        $stmt = $conn->prepare("INSERT INTO events (title, description, date) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $description, $date);

        if ($stmt->execute()) {
            $message = "Event added successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("bg1.jpg");
            background-size: 1550px 1300px;
            background-color: rgb(163, 179, 180);
            padding: 20px;
        }
        h2 { color: #333; }
        form { background: #fff; padding: 20px; border-radius: 6px; max-width: 500px; margin: auto; }
        input[type=text], input[type=date], textarea { width: 100%; padding: 10px; margin: 6px 0; border-radius: 4px; border: 1px solid #ccc; }
        input[type=submit] { background-color: #21b57f; color: white; padding: 12px 20px; border: none; cursor: pointer; border-radius: 4px; }
        input[type=submit]:hover { background-color: #21e99f; }
        .message { text-align: center; margin: 10px 0; color: green; font-weight: bold; }
        .error { color: red; }
        a { text-decoration: none; color: #059b8c; }
        a:hover { color: #21b57f; }
    </style>
</head>
<body>

<h2>Add New Event</h2>

<?php if($message): ?>
    <p class="message <?php echo strpos($message,'Error')!==false ? 'error':''; ?>"><?php echo $message; ?></p>
<?php endif; ?>

<form method="post" action="">
    <label>Title:</label>
    <input type="text" name="title" required><br>

    <label>Description:</label>
    <textarea name="description" required></textarea><br>

    <label>Date:</label>
    <input type="date" name="date" required><br>

    <input type="submit" value="Add Event">
</form>

<p style="text-align:center;"><a href="view_events.php">View All Events</a></p>

</body>
</html>
