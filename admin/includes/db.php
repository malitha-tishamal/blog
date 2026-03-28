<?php
// admin/includes/db.php
session_start();

// Security: Regenerate session ID to prevent session fixation
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 1800) { // regenerate every 30 mins
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");

// Use the main site's database connection
require_once __DIR__ . '/../../includes/db-conn.php';

// Function to check if admin is logged in
function check_admin_auth() {
    if (!isset($_SESSION['admin_id']) || empty($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit();
    }
}
?>
