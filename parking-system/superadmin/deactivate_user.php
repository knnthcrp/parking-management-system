<?php

session_start();

require '../config/database.php';
require '../config/activity_log.php';

// Check if logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

// Only Superadmin can deactivate users
if ($_SESSION['role'] != 'superadmin') {
    die("ACCESS DENIED");
}

// Check if user ID was provided
if (!isset($_GET['id'])) {
    die("User ID not provided.");
}

$user_id = intval($_GET['id']);

// Prevent Superadmin from deactivating themselves
if ($user_id == $_SESSION['id']) {
    die("You cannot deactivate your own account.");
}

// Check if user exists
$sql = "SELECT id, username, role, active FROM users WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();

// Deactivate the account
$sql = "UPDATE users SET active = 0 WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {

    logActivity(
        $conn,
        $_SESSION['id'],
        $_SESSION['username'],
        $_SESSION['role'],
        "Deactivated user account: " . $user['username']
    );

    header("Location: manage_users.php");
    exit();

} else {

    die("Failed to deactivate user.");

}

?>