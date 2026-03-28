<?php
$conn = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
$stmt = $conn->query('SHOW TABLES');
while($row = $stmt->fetch()) {
    $table = $row[0];
    echo "Table: $table\n";
    $cstmt = $conn->query("DESCRIBE $table");
    while($crow = $cstmt->fetch()) {
        echo "  " . $crow['Field'] . " (" . $crow['Type'] . ")\n";
    }
}
?>
