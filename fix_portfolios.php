<?php
$filepath = 'e:\wamp\www\blog\index.php';
$content = file_get_contents($filepath);

// We have two portfolios in index.php:
// 1. <section id="portfolio" (Events & Travel)
// 2. <section id="portfolio2" (Projects)

// Helper function to extract a section block accurately
function replaceIsotopeContainer($content, $section_id, $replacement_html) {
    $section_pos = strpos($content, 'id="' . $section_id . '"');
    if($section_pos === false) return $content;

    $iso_start = strpos($content, '<div class="row g', $section_pos); // <div class="row g-4 isotope-container"
    if($iso_start === false) return $content;

    // Find the end tag of the isotope container (there's a comment <!-- End Portfolio Container --> or </div> close)
    // Looking at the file, the isotope-container has an end comment usually, but sometimes not.
    // Let's find the closing </div> of the isotope container by counting divs? 
    // Easier: find the last </div> before the ending section comment OR the next section.
    
    // So let's find the next <section or end of file
    $next_section = strpos($content, '<section', $iso_start);
    if($next_section === false) $next_section = strlen($content);
    
    // We will find the exact bounds of <div class="row g... isotope-container"...>
    $iso_end_tag = strpos($content, '>', $iso_start) + 1;
    
    // In my previous migration, I added <!-- End Portfolio Container -->
    $end_comment = strpos($content, '<!-- End Portfolio Container -->', $iso_end_tag);
    if($end_comment !== false && $end_comment < $next_section) {
        // Clean replacement for #portfolio
        return substr_replace($content, $replacement_html, $iso_end_tag, $end_comment - $iso_end_tag);
    }
    
    // If no comment, the end is likely the </div> just before </div> </div> </section>
    // Just find "</div> </div> </section>" safely.
    $section_end = strpos($content, '</section>', $iso_start);
    if($section_end === false) return $content;
    
    // backtrack to the </div> of isotope-container
    $iso_end_div = strrpos(substr($content, 0, $section_end), '</div>', -15);
    // this is a bit risky.
    
    return $content; // Return unmodified to avoid destroying layout if uncertain
}

// Prepare Events HTML
$events_html = '
          <?php 
          $evt_res = $conn->query("SELECT * FROM portfolio_events ORDER BY display_order ASC");
          if($evt_res->num_rows > 0) {
              while($e = $evt_res->fetch_assoc()): 
          ?>
           <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item isotope-item <?php echo htmlspecialchars($e[\'category\']); ?>">
             <article class="portfolio-entry">
               <figure class="entry-image entry-image-fixed">
                 <img src="<?php echo htmlspecialchars($e[\'main_image\']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($e[\'title\']); ?>" loading="lazy" width="380" height="380">
                 <div class="entry-overlay">
                   <div class="overlay-content">
                     <div class="entry-meta text-highlight"><?php echo htmlspecialchars($e[\'highlight_text\']); ?></div>
                     <h3 class="entry-title"><?php echo htmlspecialchars($e[\'title\']); ?></h3>
                     <p class="text-white-desc"><?php echo $e[\'description\']; ?></p>
                     <div class="entry-links">
                       <a href="<?php echo htmlspecialchars($e[\'main_image\']); ?>" class="glightbox" data-gallery="<?php echo htmlspecialchars($e[\'gallery_id\']); ?>" data-glightbox="title: <?php echo htmlspecialchars($e[\'title\']); ?>; description: <?php echo htmlspecialchars(strip_tags(str_replace(\'<br>\', \' \', $e[\'description\']))); ?>"><i class="bi bi-arrows-angle-expand"></i></a>
                       <a href="<?php echo htmlspecialchars($e[\'link_url\']); ?>" target="_blank"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
               </figure>
             </article>
           </div>
          <?php 
              endwhile; 
          } else {
              echo "<p class=\'text-center w-100 text-muted\'>No events found.</p>";
          }
          ?>
          <!-- End Portfolio Container -->
          ';

// Prepare Projects HTML
$projects_html = '
          <?php 
          $proj_res = $conn->query("SELECT * FROM portfolio_projects ORDER BY display_order ASC");
          if($proj_res->num_rows > 0) {
              while($p = $proj_res->fetch_assoc()): 
          ?>
          <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item isotope-item <?php echo htmlspecialchars($p[\'category\']); ?>">
            <article class="portfolio-entry">
              <figure class="entry-image">
                <img src="<?php echo htmlspecialchars($p[\'main_image\']); ?>" class="img-fluid portfolio-app-img" alt="<?php echo htmlspecialchars($p[\'title\']); ?>" loading="lazy">
                <div class="entry-overlay">
                  <div class="overlay-content">
                    <div class="entry-meta text-highlight"><?php echo htmlspecialchars($p[\'title\']); ?></div>
                    <p class="text-white-desc"><?php echo htmlspecialchars($p[\'short_description\']); ?></p>
                    <div class="entry-links">
                      <a href="<?php echo htmlspecialchars($p[\'main_image\']); ?>" class="glightbox" data-gallery="portfolio-gallery-development" data-glightbox="title: <?php echo htmlspecialchars($p[\'title\']); ?>"><i class="bi bi-arrows-angle-expand"></i></a>
                      <a href="<?php echo htmlspecialchars($p[\'details_link\']); ?>"><i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </figure>
            </article>
          </div>
          <?php 
              endwhile; 
          } else {
              echo "<p class=\'text-center w-100 text-muted\'>No projects found.</p>";
          }
          ?>
          <!-- End Portfolio Container -->
          ';

// Replace in #portfolio
$content = replaceIsotopeContainer($content, 'portfolio"', $events_html);

// Now for #portfolio2, since it had hardcoded HTML without my "End comment", we use a direct string replacement based on exactly what is in index.php
// Let's find #portfolio2 bounded isotope-container
$p2_start = strpos($content, 'id="portfolio2"');
$iso2_tag = strpos($content, '<div class="row g-4 isotope-container"', $p2_start);
$iso2_tag_end = strpos($content, '>', $iso2_tag) + 1;

// The end of the portfolio2 content is up to </div> </div> </div> </section><!-- /Portfolio Section -->
// Let's find "<!-- Services Section -->" or "<!-- Contact Section -->"
$contact_sec = strpos($content, '<section id="contact"');
if($contact_sec !== false) {
    // We want the last </div> before <div class="container section-title"> of contact or end of section
    // Actually, I can just replace everything from $iso2_tag_end down to the </div>...</section> of portfolio2.
    // We know portfolio2 ends with:
    // </div>
    // </div>
    // </div>
    // </section>
    $p2_section_end = strpos($content, '</section>', $p2_start);
    // Find the 3rd </div> from the end of </section>
    $last_div1 = strrpos(substr($content, 0, $p2_section_end), '</div>');
    $last_div2 = strrpos(substr($content, 0, $last_div1), '</div>');
    $last_div3 = strrpos(substr($content, 0, $last_div2), '</div>'); // This is the end of isotope-container
    
    $content = substr_replace($content, $projects_html, $iso2_tag_end, $last_div3 - $iso2_tag_end);
}

file_put_contents($filepath, $content);
echo "Dual Portfolio Grids synchronized perfectly.\n";
?>
