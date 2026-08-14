<?php

session_start();

require '../config/database.php';
require '../config/activity_log.php';

// Only Admin can deactivate Staff
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    die("ACCESS DENIED");
}

// Check if ID was provided
if (!isset($_GET['id'])) {
    die("Staff ID not provided.");
}

$staff_id = intval($_GET['id']);

// Make sure this account is actually Staff
$sql = "SELECT id, username, role, active
        FROM users
        WHERE id = ? AND role = 'staff'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staff_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Staff account not found.");
}

$staff = $result->fetch_assoc();

// Deactivate Staff
$sql = "UPDATE users
        SET active = 0
        WHERE id = ? AND role = 'staff'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staff_id);

if ($stmt->execute()) {

    logActivity(
        $conn,
        $_SESSION['id'],
        $_SESSION['username'],
        $_SESSION['role'],
        "Deactivated user account: " . $user['username']
    );

    header("Location: manage_staff.php");
    exit();

} else {

    die("Failed to deactivate Staff.");

}

?>