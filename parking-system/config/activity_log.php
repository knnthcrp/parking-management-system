<?php

function logActivity($conn, $user_id, $username, $role, $action)
{
    $sql = "INSERT INTO activity_logs
            (user_id, username, role, action)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "isss",
        $user_id,
        $username,
        $role,
        $action
    );

    $stmt->execute();
}

?>