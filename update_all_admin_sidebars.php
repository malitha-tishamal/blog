<?php
$admin_dir = 'e:\wamp\www\blog\admin\\';
$files = [
    'about.php',
    'certifications.php',
    'events.php',
    'index.php',
    'messages.php',
    'portfolio.php',
    'resume.php',
    'services.php',
    'settings.php',
    'testimonials.php'
];

foreach ($files as $file_name) {
    $file = $admin_dir . $file_name;
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    
    // Check if skills link already exists
    if (strpos($content, 'href="skills.php"') !== false) continue;

    // Pattern to find the resume link and its class (active or not)
    // <a href="resume.php" class="active"><i class="bi bi-file-earmark-person me-2"></i> Resume</a>
    // We want to insert Skills after Resume
    $search_pattern = '/<a href="resume\.php"(.*?)>(.*?)<\/a>/i';
    
    $replacement = '$0' . "\n            " . '<a href="skills.php"><i class="bi bi-stars me-2"></i> Skills</a>';
    
    $new_content = preg_replace($search_pattern, $replacement, $content);
    
    if ($new_content !== $content) {
        file_put_contents($file, $new_content);
        echo "Updated sidebar in $file_name\n";
    } else {
        echo "Could not find resume link in $file_name\n";
    }
}
?>
