<?php
include('db_connect.php');

if(!isset($_GET['id'])) {
    die("Event ID is required.");
}

$id = intval($_GET['id']);
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $date = $_POST['date'];

    $stmt = $conn->prepare("UPDATE events SET title=?, description=?, date=? WHERE id=?");
    $stmt->bind_param("sssi", $title, $description, $date, $id);

    if ($stmt->execute()) {
        $message = "Event updated successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM events WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
$stmt->close();
?>
<html>
<head><title>Edit Event</title>
<style>
    body {
            background-image: url("bg1.jpg");
            background-size: 1550px 1300px;
            background-color: rgb(163, 179, 180);
        }
    </style>
</head>

<body>
<h2>Edit Event</h2>
<?php if($message) echo "<p>$message</p>"; ?>
<form method="post" action="">
    Title: <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required><br>
    Description: <textarea name="description" required><?php echo htmlspecialchars($event['description']); ?></textarea><br>
    Date: <input type="date" name="date" value="<?php echo $event['date']; ?>" required><br>
    <input type="submit" value="Update Event">
</form>
<a href="view_events.php">Back to Events List</a>
</body>
</html>
