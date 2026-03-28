<?php
require_once 'includes/db-conn.php';
try {
    $stmt = $conn->query("DESCRIBE hero_cards");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($columns, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
