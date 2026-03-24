<?php
$filepath = 'e:\wamp\www\blog\index.php';
$content = file_get_contents($filepath);

// We need to replace the inner content of <div class="isotope-container">
// We will search for '<div class="row gy-4 isotope-container"' and '</div><!-- End Portfolio Container -->'

$start_pos = strpos($content, '<div class="row gy-4 isotope-container"');
// Fallback if the class string differs slightly
if ($start_pos === false) {
    // try to find just isotope-container
    $start_pos = strpos($content, 'isotope-container"');
    if ($start_pos !== false) {
        // backtrack to <div
        $start_pos = strrpos(substr($content, 0, $start_pos), '<div');
    }
}

$end_pos = strpos($content, '<!-- End Portfolio Container -->');

if ($start_pos !== false && $end_pos !== false) {
    // include the opening tag
    $opening_tag_end = strpos($content, '>', $start_pos) + 1;
    
    $portfolio_replacement = '
          <?php 
          $proj_res = $conn->query("SELECT * FROM portfolio_projects ORDER BY display_order ASC");
          if($proj_res->num_rows > 0) {
              while($p = $proj_res->fetch_assoc()): 
          ?>
          <div class="col-lg-4 col-md-6 portfolio-item isotope-item <?php echo htmlspecialchars($p[\'category\']); ?>">
            <div class="portfolio-content h-100">
              <a href="<?php echo htmlspecialchars($p[\'main_image\']); ?>" data-gallery="portfolio-gallery-app" class="glightbox"><img src="<?php echo htmlspecialchars($p[\'main_image\']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($p[\'title\']); ?>" loading="lazy"></a>
              <div class="portfolio-info">
                <h4><a href="<?php echo htmlspecialchars($p[\'details_link\']); ?>" title="More Details"><?php echo htmlspecialchars($p[\'title\']); ?></a></h4>
                <p><?php echo htmlspecialchars($p[\'short_description\']); ?></p>
              </div>
            </div>
          </div><!-- End Portfolio Item -->
          <?php 
              endwhile; 
          } else {
              echo "<p class=\'text-center w-100 text-muted\'>No portfolio projects found.</p>";
          }
          ?>
          ';
          
    // Replace everything between opening tag end and closing tag comment
    $content = substr_replace($content, $portfolio_replacement, $opening_tag_end, $end_pos - $opening_tag_end);
    file_put_contents($filepath, $content);
    echo "Portfolio section migrated successfully.\n";
} else {
    echo "Could not find portfolio markers.\n";
}
?>
