<?php
include('db_connect.php');
$result = $conn->query("SELECT * FROM students ORDER BY created_at DESC");
?>
<html>
<head>
    <title>Student List</title>
    <style>
     body {
            background-image: url("bg1.jpg");
            background-size: 1550px 1300px;
            background-color: rgb(163, 179, 180);
        }
</style>
</head>
<body>
<h2>All Students</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Roll No</th>
        <th>Email</th>
        <th>Course</th>
        <th>Added On</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".htmlspecialchars($row['id'])."</td>
                    <td>".htmlspecialchars($row['name'])."</td>
                    <td>".htmlspecialchars($row['roll_no'])."</td>
                    <td>".htmlspecialchars($row['email'])."</td>
                    <td>".htmlspecialchars($row['course'])."</td>
                    <td>".htmlspecialchars($row['created_at'])."</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No students found.</td></tr>";
    }
    ?>
</table>
<a href="student_form.php">Add New Student</a>
</body>
</html>
