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

// Only Admin can access this page
if ($_SESSION['role'] != 'admin') {
    die("ACCESS DENIED");
}

// Get all staff accounts
$sql = "SELECT id, username, role, active
        FROM users
        WHERE role = 'staff'
        ORDER BY id ASC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Staff</title>

    <link rel="stylesheet" href="../css/dashboard.css">

</head>

<body>

<div class="dashboard">

    <h1>Manage Staff</h1>

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

            <td>
                <?php echo $user['id']; ?>
            </td>

            <td>
                <?php echo htmlspecialchars($user['username']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($user['role']); ?>
            </td>

            <td>

                <?php

                if ($user['active'] == 1) {
                    echo "Active";
                } else {
                    echo "Deactivated";
                }

                ?>

            </td>

            <td>

                <?php if ($user['active'] == 1) { ?>

                    <a href="edit_staff.php?id=<?php echo $user['id']; ?>">
                        Edit
                    </a>

                    |

                    <a href="deactivate_staff.php?id=<?php echo $user['id']; ?>"
                    onclick="return confirm('Are you sure you want to deactivate this staff account?');">
                        Deactivate
                    </a>

                <?php } else { ?>

                    Deactivated

                <?php } ?>

            </td>

        </tr>

        <?php

            }

        } else {

        ?>

        <tr>
            <td colspan="5">
                No staff accounts found.
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