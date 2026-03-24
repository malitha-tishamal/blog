<?php
require_once 'includes/db-conn.php';

$res = $conn->query("SELECT COUNT(*) as c FROM portfolio_projects");
if($res) {
    $row = $res->fetch_assoc();
    echo "Projects count: " . $row['c'] . "\n";
} else {
    echo "Error projects: " . $conn->error . "\n";
}

$res = $conn->query("SELECT COUNT(*) as c FROM portfolio_events");
if($res) {
    $row = $res->fetch_assoc();
    echo "Events count: " . $row['c'] . "\n";
} else {
    echo "Error events: " . $conn->error . "\n";
}
?>
