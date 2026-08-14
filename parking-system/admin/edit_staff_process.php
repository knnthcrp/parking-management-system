<?php

session_start();

require '../config/database.php';
require '../config/activity_log.php';

// Only Admin can edit Staff
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    die("ACCESS DENIED");
}

$id = intval($_POST['id']);
$username = trim($_POST['username']);
$password = $_POST['password'];

// Make sure the account is actually STAFF
$sql = "SELECT id FROM users WHERE id = ? AND role = 'staff'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Staff account not found.");
}

// Check duplicate username
$sql = "SELECT id
        FROM users
        WHERE username = ?
        AND id != ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $username, $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Username already exists!");
}

// Update username
$sql = "UPDATE users
        SET username = ?
        WHERE id = ?
        AND role = 'staff'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $username, $id);
$stmt->execute();

// Update password if entered
if (!empty($password)) {

    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $sql = "UPDATE users
            SET password = ?
            WHERE id = ?
            AND role = 'staff'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $hashedPassword, $id);
    $stmt->execute();
}
logActivity(
    $conn,
    $_SESSION['id'],
    $_SESSION['username'],
    $_SESSION['role'],
    "Edited staff account: " . $username
);
header("Location: manage_staff.php");
exit();

?>