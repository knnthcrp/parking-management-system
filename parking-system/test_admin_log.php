<?php

session_start();

require '../config/database.php';
require '../config/activity_log.php';

if (!isset($_SESSION['id'])) {
    die("Not logged in.");
}

logActivity(
    $conn,
    $_SESSION['id'],
    $_SESSION['username'],
    $_SESSION['role'],
    "Admin log test"
);

echo "Admin log test successful!";

?>