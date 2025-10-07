<?php
include('db_connect.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $roll_no = htmlspecialchars(trim($_POST['roll_no']));
    $email = htmlspecialchars(trim($_POST['email']));
    $course = htmlspecialchars(trim($_POST['course']));

    $stmt = $conn->prepare("INSERT INTO students (name, roll_no, email, course) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $roll_no, $email, $course);

    if ($stmt->execute()) {
        $message = "Student added successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<html>
<head>
    <title>Add Student</title>
<style>
     body {
            background-image: url("bg1.jpg");
            background-size: 1550px 1300px;
            background-color: rgb(163, 179, 180);
        }
</style>
</head>
<body>
<h2>Add New Student</h2>
<?php if ($message) echo "<p>$message</p>"; ?>
<form method="post" action="">
    Name: <input type="text" name="name" required><br><br>
    Roll No: <input type="text" name="roll_no" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Course: <input type="text" name="course" required><br><br>
    <input type="submit" value="Add Student">
</form>
<a href="view_students.php">View All Students</a>
</body>
</html>
