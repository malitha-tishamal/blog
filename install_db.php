<?php
$conn = mysqli_connect("localhost", "root", "", "blog");
if (!$conn) {
    die("DB Connection Failed: " . mysqli_connect_error());
}
$sql = file_get_contents(__DIR__ . '/database/cms_schema.sql');
if (mysqli_multi_query($conn, $sql)) {
    echo "Database schema imported successfully.\n";
    do {
        if ($res = mysqli_store_result($conn)) {
            mysqli_free_result($res);
        }
    } while (mysqli_more_results($conn) && mysqli_next_result($conn));
} else {
    echo "Error importing database: " . mysqli_error($conn) . "\n";
}
?>
