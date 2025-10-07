<?php
session_start();
include('db_connect.php');

// Only allow admin access
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>
