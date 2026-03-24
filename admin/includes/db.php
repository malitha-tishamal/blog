<?php
// admin/includes/db.php
session_start();

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
