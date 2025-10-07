<?php
include('db_connect.php');

if(!isset($_GET['id'])) {
    die("Event ID is required.");
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM events WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: view_events.php");
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
?>
