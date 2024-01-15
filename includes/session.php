<?php

$timeout_duration = 60000;

if (isset($_SESSION['user_id'])) {
    // Check if last activity time is set
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) {
        // User has been inactive for too long, log them out
        session_unset();
        session_destroy();
        header("Location: ../auth/login.php"); // Redirect to login page
        exit();
    }

    // Update last activity time
    $_SESSION['last_activity'] = time();
} else {
    // User is not logged in, redirect to login page
    header("Location: ../auth/login.php");
    exit();
}
