<?php

session_start();

require '../config/database.php';
require '../config/activity_log.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] != 'superadmin') {
    die("ACCESS DENIED");
}


$id = intval($_POST['id']);
$username = trim($_POST['username']);
$role = $_POST['role'];
$password = $_POST['password'];


if ($role != 'admin' && $role != 'staff' && $role != 'superadmin') {
    die("Invalid role.");
}


$sql = "SELECT id FROM users WHERE username = ? AND id != ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $username, $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Username already exists!");
}


$sql = "UPDATE users SET username = ?, role = ? WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $username, $role, $id);

$stmt->execute();


if (!empty($password)) {

    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    $sql = "UPDATE users SET password = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $hashedPassword, $id);

    $stmt->execute();
}

logActivity(
    $conn,
    $_SESSION['id'],
    $_SESSION['username'],
    $_SESSION['role'],
    "Edited user account: " . $username
);

header("Location: manage_users.php");
exit();

echo "User updated successfully!";

?>