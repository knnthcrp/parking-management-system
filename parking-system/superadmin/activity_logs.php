<?php

session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

require '../config/database.php';

// Only Superadmin can view activity logs
if (!isset($_SESSION['id']) || $_SESSION['role'] != 'superadmin') {
    die("ACCESS DENIED");
}

// Get all activity logs
$sql = "SELECT id, user_id, username, role, action, created_at
        FROM activity_logs
        ORDER BY id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Activity Logs</title>

    <link rel="stylesheet" href="../css/dashboard.css">

</head>

<body>

<div class="dashboard">

    <h1>Activity Logs</h1>

    <p>
        Welcome,
        <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
    </p>

    <hr>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">

        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
            <th>Date & Time</th>
        </tr>

        <?php

        if ($result->num_rows > 0) {

            while ($log = $result->fetch_assoc()) {

        ?>

        <tr>

            <td>
                <?php echo $log['id']; ?>
            </td>

            <td>
                <?php echo $log['user_id']; ?>
            </td>

            <td>
                <?php echo htmlspecialchars($log['username']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($log['role']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($log['action']); ?>
            </td>

            <td>
                <?php echo $log['created_at']; ?>
            </td>

        </tr>

        <?php

            }

        } else {

        ?>

        <tr>

            <td colspan="6">
                No activity logs found.
            </td>

        </tr>

        <?php } ?>

    </table>

    <br>

    <a href="dashboard.php">
        ← Back to Dashboard
    </a>

</div>

</body>

</html>