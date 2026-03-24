<?php
$filepath = 'e:\wamp\www\blog\index.php';
$content = file_get_contents($filepath);

// 1. Replace Skills Grid (Services)
$start_skills = strpos($content, '<div class="skills-grid">');
$end_skills = strpos($content, '<div class="journey-timeline"');

if ($start_skills !== false && $end_skills !== false && $start_skills < $end_skills) {
    $skills_replacement = '<div class="skills-grid">
                    <?php 
                    $service_res = $conn->query("SELECT * FROM services ORDER BY display_order ASC");
                    $delay = 400;
                    if($service_res->num_rows > 0) {
                        while($s = $service_res->fetch_assoc()): 
                    ?>
                    <div class="skill-item" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>">
                      <div class="skill-icon">
                        <i class="<?php echo htmlspecialchars($s[\'icon_class\']); ?>"></i>
                      </div>
                      <h4><?php echo htmlspecialchars($s[\'title\']); ?></h4>
                      <p><?php echo htmlspecialchars($s[\'description\']); ?></p>
                    </div>
                    <?php 
                            $delay += 50;
                        endwhile; 
                    } else {
                        echo "<p class=\'text-muted\'>No services added yet.</p>";
                    }
                    ?>
                  </div>
                  ';
                  
    $content = substr_replace($content, $skills_replacement, $start_skills, $end_skills - $start_skills);
}

// Reload file content lengths
$start_journey = strpos($content, '<div class="journey-timeline"');
$end_journey = strpos($content, '<div class="cta-section"');

// Wait, between journey-timeline and cta-section there is a closing </div> for the col-lg-7
// Let's find exactly how many </div> are between journey-timeline block end and cta-section
if ($start_journey !== false && $end_journey !== false && $start_journey < $end_journey) {
    $journey_block = substr($content, $start_journey, $end_journey - $start_journey);
    // There are two </div> before cta-section in the original HTML.
    // The original html:
    // </div> (end of journey-timeline)
    // </div> (end of intro maybe?) Wait, looking at the previous view_file, journey timeline is inside col-lg-7 but intro and skills-grid are siblings.
    
    $journey_replacement = '<div class="journey-timeline" data-aos="fade-up" data-aos-delay="300">
                    <?php 
                    $resume_res = $conn->query("SELECT * FROM resume_entries ORDER BY display_order ASC");
                    if($resume_res->num_rows > 0) {
                        while($r = $resume_res->fetch_assoc()): 
                    ?>
                   <div class="timeline-item">
                    <div class="year"><?php echo htmlspecialchars($r[\'duration\']); ?></div>
                    <div class="description">
                        <strong><?php echo htmlspecialchars($r[\'organization\']); ?></strong> - <?php echo htmlspecialchars($r[\'title\']); ?>
                        <?php if(!empty($r[\'description\'])): ?>
                            <br><?php echo htmlspecialchars($r[\'description\']); ?>
                        <?php endif; ?>
                    </div>
                  </div>
                    <?php 
                        endwhile; 
                    } else {
                        echo "<p class=\'text-muted\'>No timeline entries found.</p>";
                    }
                    ?>
                </div>
                
                ';
                
    // We only replace up to the last </div> of the journey-timeline. Let's find the position of the last </div> before cta-section.
    $last_div_before_cta = strrpos(substr($content, 0, $end_journey), '</div>');
    // Replace from $start_journey to $last_div_before_cta + 6
    $content = substr_replace($content, $journey_replacement, $start_journey, ($last_div_before_cta + 6) - $start_journey);
}

file_put_contents($filepath, $content);
echo "Frontend migration passed for Skills and Timeline.\n";
?>
