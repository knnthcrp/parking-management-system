<?php

session_start();
require 'config/database.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    if ($password == $user['password']) {

        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($_SESSION['role'] == 'superadmin') {

    header("Location: superadmin/dashboard.php");

} elseif ($_SESSION['role'] == 'admin') {

    header("Location: admin/dashboard.php");

} elseif ($_SESSION['role'] == 'staff') {

    header("Location: staff/dashboard.php");

}

exit();


    } else {

        echo "Incorrect Password!";

    }

} else {

    echo "User does not exist.";

}

?>