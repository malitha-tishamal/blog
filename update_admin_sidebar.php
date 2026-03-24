<?php
$files = [
    'e:\wamp\www\blog\admin\index.php',
    'e:\wamp\www\blog\admin\settings.php',
    'e:\wamp\www\blog\admin\about.php',
    'e:\wamp\www\blog\admin\resume.php',
    'e:\wamp\www\blog\admin\portfolio.php',
    'e:\wamp\www\blog\admin\services.php',
    'e:\wamp\www\blog\admin\messages.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // In portfolio.php, it's <a href="portfolio.php" class="active"><i class="bi bi-grid me-2"></i> Portfolio</a> OR bi bi-laptop
    // We'll just search for `<a href="portfolio.php"` up to `</a>`
    $search_pattern = '/<a href="portfolio\.php"(.*?)>.*?<\/a>/i';
    
    // We need to keep the matched portfolio link and append the events link if it doesn't already exist
    if (strpos($content, '<a href="events.php"') === false) {
        $replacement = '$0' . "\n            " . '<a href="events.php"><i class="bi bi-camera me-2"></i> Events Gallery</a>';
        $content = preg_replace($search_pattern, $replacement, $content);
        file_put_contents($file, $content);
        echo "Updated sidebar in " . basename($file) . "\n";
    }
}
?>
