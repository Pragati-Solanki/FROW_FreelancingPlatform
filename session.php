<?php
session_start();
include('db_connect.php'); // Make sure this file sets up $conn properly

// Auto-login via cookie if session not set
if (!isset($_SESSION['username']) && isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
}

// Block access if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

// Fetch user details from database
$username = $_SESSION['username'];
$email = "Not Available";

if ($stmt = $conn->prepare("SELECT email FROM users WHERE username = ?")) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user) {
        $email = $user['email'];
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        a:link, a:visited { color: rgb(0,0,0); text-decoration: none; }
        a:hover { color: rgb(255,255,255); }
        .button {
            background-color: white; color: black; border: 2px solid #059b8c;
            padding: 15px 32px; border-radius: 4px; text-align: center;
            display: inline-block; opacity: 0.7; font-size: 12px;
            margin: 4px 2px; cursor: pointer;
        }
        .button:hover {
            background-color: rgb(103,21,117); color: #ffffff;
            box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
            opacity: 1;
        }
        .card { box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); max-width: 300px; margin: auto; text-align: center; font-family: arial; }
        .title { color: grey; font-size: 18px; }
        .user {
            border: none; outline: 0; display: inline-block; padding: 8px;
            color: white; background-color: #000; text-align: center;
            cursor: pointer; width: 100%; font-size: 18px;
        }
        .user:hover { opacity: 0.7; }
        body { background-image: url("bg1.jpg"); background-size: 1550px 1300px; background-color: rgb(163,179,180); }
    </style>
</head>
<body>
<center>
    <font size="7" color="#eeeeee">FROW</font>
    <hr>
    <font size="5">
        <button class="button"><a href="Homepage.html">Homepage</a></button>
        <button class="button"><a href="explore.html">Explore</a></button>
        <button class="button"><a href="freelancers.html">Top Freelancers</a></button>
        <button class="button"><a href="jobs.html">Top Jobs</a></button>
        <button class="button"><a href="saved.html">Saved</a></button>
        <button class="button"><a href="session.php">Dashboard</a></button>
        <button class="button"><a href="settings.html">Settings</a></button>
        <button class="button"><a href="info.html">AboutUs</a></button>
        <button class="button"><a href="help.html">Help/FAQs</a></button>
        <button class="button"><a href="logout.php">Logout</a></button>
    </font>
</center>
<hr>

<br><br>
<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
<p>Email: abc@xyz.com </p>
<h2 style="color: green;">This is your protected dashboard</h2>

<center>
    <h2 style="text-align:center">User Profile Card</h2>
    <div class="card">
        <img src="img1.jpg" alt="USER" style="width:100%">
        <h1><?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <p class="title">Working on Freelancing website</p>
        <p>Frow user</p><br><br>
        <p><button class="user">Progress Board</button></p>
    </div>

    <br><br><br><br><br><br><br>
    <small>
        <center>
            <font>Explore new opportunities, build your skills <br> Grow Your Experience</font>
            <hr>
            <font>copyright@1234 | </font>
            <font>contact us | </font>
            <font>help/FAQ</font>
        </center>
    </small>
</center>
</body>
</html>
