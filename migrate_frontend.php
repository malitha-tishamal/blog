<?php
$filepath = 'e:\wamp\www\blog\index.php';
$content = file_get_contents($filepath);

// 1. Add DB connection at top
if (strpos($content, "require_once 'includes/db-conn.php';") === false) {
    $db_code = "<?php\nrequire_once 'includes/db-conn.php';\n\$site_settings = \$conn->query(\"SELECT * FROM site_settings WHERE id=1\")->fetch_assoc();\n\$about_settings = \$conn->query(\"SELECT * FROM about_section WHERE id=1\")->fetch_assoc();\n?>\n<!DOCTYPE html>";
    $content = preg_replace('/<!DOCTYPE html>/i', $db_code, $content, 1);
}

// 2. Replace Hero Title & Description
$hero_search = '/<h1 class="hero-title">Malitha Tishamal - <span class="typed" data-typed-items="[^"]+"><\/span><\/h1>/';
$hero_replace = '<h1 class="hero-title"><?php echo htmlspecialchars($site_settings[\'site_name\']); ?> - <span class="typed" data-typed-items="<?php echo htmlspecialchars($site_settings[\'hero_title\']); ?>"></span></h1>';
$content = preg_replace($hero_search, $hero_replace, $content);

$desc_search = '/<p class="lead">I create digital experiences that inspire and engage\..*?<\/p>/s';
$desc_replace = '<p class="lead"><?php echo htmlspecialchars($site_settings[\'hero_description\']); ?></p>';
$content = preg_replace($desc_search, $desc_replace, $content);

// 3. Update Contact Emails
// In the contact section, let's find the email displays
$email_search = '/<p>malithatishamal@gmail\.com<\/p>/';
$email_replace = '<p><?php echo htmlspecialchars($site_settings[\'contact_email\']); ?></p>';
$content = preg_replace($email_search, $email_replace, $content);

// 4. About Me Bio
$about_search = '/<p class="fst-italic">\s*Hello! I’m Malitha Tishamal, a passionate developer based in Sri Lanka\..*?<\/p>/s';
$about_replace = '<p class="fst-italic"><?php echo htmlspecialchars($about_settings[\'bio\']); ?></p>';
$content = preg_replace($about_search, $about_replace, $content);

// Write changes
file_put_contents($filepath, $content);
echo "Frontend migration passed for basic elements.\n";
?>
