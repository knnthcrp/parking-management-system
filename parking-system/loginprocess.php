<?php

session_start();
require 'config/database.php';
require 'config/activity_log.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ? AND active = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        logActivity(
            $conn,
            $_SESSION['id'],
            $_SESSION['username'],
            $_SESSION['role'],
            "Logged in"
        );

       if ($_SESSION['role'] == 'superadmin') {

    header("Location: superadmin/dashboard.php");

    } elseif ($_SESSION['role'] == 'admin') {

    header("Location: admin/dashboard.php");

    } elseif ($_SESSION['role'] == 'staff') {

    header("Location: staff/dashboard.php");

    }

exit();


    } else {

        logActivity(
        $conn,
        $user['id'],
        $user['username'],
        $user['role'],
        "Failed login attempt"
    );

    echo "Incorrect Password!";

    }

} else {

    logActivity(
        $conn,
        NULL,
        $username,
        "unknown",
        "Failed login attempt"
    );

    echo "User does not exist.";
}

?>