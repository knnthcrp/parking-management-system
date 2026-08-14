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


$username = trim($_POST['username']);
$password = $_POST['password'];



$sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    die("Username already exists!");

}



$hashedPassword = password_hash($password, PASSWORD_DEFAULT);



$role = "admin";



$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $hashedPassword, $role);

if ($stmt->execute()) {

logActivity(
    $conn,
    $_SESSION['id'],
    $_SESSION['username'],
    $_SESSION['role'],
    "Created admin account: " . $username
);

    echo "Admin account created successfully!";

} else {

    echo "Error creating Admin account.";

}

?>