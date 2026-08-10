<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] != 'staff') {
    echo "Access Denied!";
    exit();
}

?>

<h1>Superadmin Dashboard</h1>

<p>Welcome <?php echo $_SESSION['username']; ?></p>