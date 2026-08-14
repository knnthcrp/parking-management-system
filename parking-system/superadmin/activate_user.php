<?php

session_start();

require '../config/database.php';
require '../config/activity_log.php';

// Only Superadmin
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'superadmin') {
    die("ACCESS DENIED");
}

if (!isset($_GET['id'])) {
    die("User ID not provided.");
}

$user_id = intval($_GET['id']);

// Get user
$sql = "SELECT id, username, role, active
        FROM users
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();

// Activate account
$sql = "UPDATE users
        SET active = 1
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {

    logActivity(
        $conn,
        $_SESSION['id'],
        $_SESSION['username'],
        $_SESSION['role'],
        "Activated user account: " . $user['username']
    );

    header("Location: manage_users.php");
    exit();

} else {

    die("Failed to activate user.");

}

?>