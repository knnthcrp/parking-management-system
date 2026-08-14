<?php

session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

require '../config/database.php';

// Check if logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

// Only Superadmin can access this page
if ($_SESSION['role'] != 'superadmin') {
    die("ACCESS DENIED");
}

// Get all users
$sql = "SELECT id, username, role, active FROM users ORDER BY id ASC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Users</title>

    <link rel="stylesheet" href="../css/dashboard.css">

</head>

<body>

<div class="dashboard">

    <h1>Manage Users</h1>

    <p>
        Welcome,
        <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
    </p>

    <hr>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">

        <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Status</th>
        <th>Action</th>
        </tr>

        <?php

        if ($result->num_rows > 0) {

            while ($user = $result->fetch_assoc()) {

        ?>

        <tr>

            <!-- ID -->
            <td>
                <?php echo $user['id']; ?>
            </td>

            <!-- Username -->
            <td>
                <?php echo htmlspecialchars($user['username']); ?>
            </td>

            <!-- Role -->
            <td>
                <?php echo htmlspecialchars($user['role']); ?>
            </td>

            <!-- Status -->
            <td>
                <?php
                if ($user['active'] == 1) {
                    echo "Active";
                } else {
                    echo "Deactivated";
                }
                ?>
            </td>

            <!-- Action -->
            <td>

                <?php if ($user['id'] != $_SESSION['id']) { ?>

                    <a href="edit_user.php?id=<?php echo $user['id']; ?>">
                        Edit
                    </a>

                    |

                    <?php if ($user['active'] == 1) { ?>

                        <a href="deactivate_user.php?id=<?php echo $user['id']; ?>"
                        onclick="return confirm('Are you sure you want to deactivate this account?');">
                            Deactivate
                        </a>

                    <?php } else { ?>

                        <a href="activate_user.php?id=<?php echo $user['id']; ?>"
                        onclick="return confirm('Are you sure you want to activate this account?');">
                            Activate
                        </a>

                    <?php } ?>

                <?php } ?>

            </td>

        </tr>

        <?php

            }

        } else {

        ?>

        <tr>
            <td colspan="4">No users found.</td>
        </tr>

        <?php } ?>

    </table>

    <br>

    <a href="dashboard.php">← Back to Dashboard</a>

</div>

</body>

</html>