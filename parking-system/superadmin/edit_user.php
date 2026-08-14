<?php

session_start();

require '../config/database.php';

// Check if logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

// Only Superadmin can edit users
if ($_SESSION['role'] != 'superadmin') {
    die("ACCESS DENIED");
}

// Check if user ID was provided
if (!isset($_GET['id'])) {
    die("User ID not provided.");
}

$user_id = intval($_GET['id']);

// Get the user's information
$sql = "SELECT id, username, role FROM users WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit User</title>

    <link rel="stylesheet" href="../css/dashboard.css">

</head>

<body>

<div class="dashboard">

    <h1>Edit User</h1>

    <hr>

    <form action="edit_user_process.php" method="POST">

        <!-- Hidden user ID -->
        <input
            type="hidden"
            name="id"
            value="<?php echo $user['id']; ?>"
        >

        <label>Username</label>
        <br>

        <input
            type="text"
            name="username"
            value="<?php echo htmlspecialchars($user['username']); ?>"
            required
        >

        <br><br>

        <label>Role</label>
        <br>

        <?php if ($user['role'] == 'superadmin') { ?>

            <!-- Superadmin role cannot be changed -->
            <input type="text" value="superadmin" disabled>

            <input
                type="hidden"
                name="role"
                value="superadmin"
            >

        <?php } else { ?>

            <select name="role">

                <option
                    value="admin"
                    <?php if ($user['role'] == 'admin') echo 'selected'; ?>
                >
                    Admin
                </option>

                <option
                    value="staff"
                    <?php if ($user['role'] == 'staff') echo 'selected'; ?>
                >
                    Staff
                </option>

            </select>

        <?php } ?>

        <br><br>

        <label>New Password</label>
        <br>

        <input
            type="password"
            name="password"
            placeholder="Leave blank to keep current password"
        >

        <br><br>

        <button type="submit">
            Update User
        </button>

    </form>

    <br>

    <a href="manage_users.php">
        ← Back to Manage Users
    </a>

</div>

</body>

</html>