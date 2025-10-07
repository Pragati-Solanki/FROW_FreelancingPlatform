<?php
include('db_connect.php');

$result = $conn->query("SELECT * FROM events ORDER BY date ASC");
?>
<html>
<head><title>Events List</title></head>
<style>
    body {
            background-image: url("bg1.jpg");
            background-size: 1550px 1300px;
            background-color: rgb(163, 179, 180);
        }
    </style>
<body>
<h2>All Events</h2>
<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Date</th>
    <th>Actions</th>
</tr>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".htmlspecialchars($row['id'])."</td>
                <td>".htmlspecialchars($row['title'])."</td>
                <td>".htmlspecialchars($row['description'])."</td>
                <td>".htmlspecialchars($row['date'])."</td>
                <td>
                    <a href='edit_event.php?id=".$row['id']."'>Edit</a> |
                    <a href='delete_event.php?id=".$row['id']."' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No events found.</td></tr>";
}
?>
</table>
<a href="add_event.php">Add New Event</a>
</body>
</html>
