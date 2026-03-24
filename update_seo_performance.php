<?php
$directory = 'e:\wamp\www\blog';
$files = glob($directory . '/*.php');

foreach ($files as $filepath) {
    if (basename($filepath) == 'update_seo_performance.php') continue;
    
    $content = file_get_contents($filepath);
    $modified = false;
    
    // 1. Bypass minify_html
    $search1 = "function minify_html(\$buffer) {\n      \$search = array(";
    $replace1 = "function minify_html(\$buffer) { return \$buffer;\n      \$search = array(";
    if (strpos($content, $search1) !== false) {
        $content = str_replace($search1, $replace1, $content);
        $modified = true;
    } else {
        $search2 = "function minify_html(\$buffer) {";
        $replace2 = "function minify_html(\$buffer) { return \$buffer;";
        if (strpos($content, $search2) !== false && strpos($content, $replace2) === false) {
            $content = str_replace($search2, $replace2, $content);
            $modified = true;
        }
    }

    // 2. Fix Canonical and OG domains to malithatishamal.42web.io
    $new_content = preg_replace('/https:\/\/(?:www\.)?(?:edulk|mediq|eduwide|malithatishamal)\.42web\.io/', 'https://malithatishamal.42web.io', $content);
    if ($new_content !== null && $new_content !== $content) {
        $content = $new_content;
        $modified = true;
    }
    
    // 3. Add preload for CSS if not present
    $preload_tag = '<link rel="preload" href="assets/css/bundle.min.css" as="style">';
    $stylesheet_tag = '<link href="assets/css/bundle.min.css" rel="stylesheet">';
    if (strpos($content, $preload_tag) === false && strpos($content, $stylesheet_tag) !== false) {
        $content = str_replace($stylesheet_tag, $preload_tag . "\n  " . $stylesheet_tag, $content);
        $modified = true;
    }
    
    if ($modified) {
        file_put_contents($filepath, $content);
        echo "Updated " . basename($filepath) . "\n";
    }
}

// 4. Defer bundle.min.js in footer.php
$footer_path = $directory . '/includes/footer.php';
$footer_content = file_get_contents($footer_path);
$new_footer = str_replace('<script src="assets/js/bundle.min.js"></script>', '<script src="assets/js/bundle.min.js" defer></script>', $footer_content);
if ($new_footer !== $footer_content) {
    file_put_contents($footer_path, $new_footer);
    echo "Updated footer.php with defer.\n";
}

echo "All updates processed.\n";
?>
