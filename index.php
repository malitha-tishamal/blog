<?php
require_once 'includes/db-conn.php';
$site_settings = $conn->query("SELECT * FROM site_settings WHERE id=1")->fetch_assoc();
$about_settings = $conn->query("SELECT * FROM about_section WHERE id=1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, shrink-to-fit=no">
  
  <!-- Primary Title with Focus Keywords -->
  <title>Malitha Tishamal – Full Stack Developer & DevOps Engineer | AI & Cybersecurity Specialist</title>
  
  <!-- Comprehensive Meta Description -->
  <meta name="description" content="Malitha Tishamal: Expert Full Stack Developer & DevOps Engineer specializing in React, Node.js, Python, cloud solutions, AI integration, and cybersecurity. Building scalable web and mobile applications with modern technologies.">
  
  <!-- Semantic Keywords Structure -->
  <meta name="keywords" content="
    Malitha Tishamal, 
    Full Stack Developer Sri Lanka, 
    DevOps Engineer, 
    Cybersecurity Expert, 
    AI Developer, 
    Web Developer Colombo, 
    React Developer, 
    Node.js Developer, 
    Python Developer, 
    Cloud Solutions, 
    API Development, 
    Software Engineer Sri Lanka, 
    Freelance Developer,
    Mobile App Development,
    System Security,
    Machine Learning,
    Docker, Kubernetes,
    CI/CD Pipelines,
    Microservices
  ">
  
  <!-- Author with Credentials -->
  <meta name="author" content="Malitha Tishamal - Full Stack Developer & DevOps Engineer">
  
  <!-- Advanced Robots Directives -->
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  
  <!-- Canonical URL with your actual domain -->
  <link rel="canonical" href="https://malithatishamal.42web.io/">
  
  <!-- Comprehensive Open Graph Protocol -->
  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_LK">
  <meta property="og:site_name" content="Malitha Tishamal - Developer Portfolio">
  <meta property="og:title" content="Malitha Tishamal – Full Stack Developer | DevOps | AI & Cybersecurity">
  <meta property="og:description" content="Professional Full Stack Developer & DevOps Engineer creating secure, scalable applications with React, Node.js, Python, cloud infrastructure, and AI integration.">
  <meta property="og:image" content="https://malithatishamal.42web.io/assets/img/profile/profile-malitha.jpg">
  <meta property="og:image:alt" content="Malitha Tishamal - Full Stack Developer & DevOps Engineer">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:url" content="https://malithatishamal.42web.io/">
  
  <!-- Enhanced Twitter Cards -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@malithatishamal">
  <meta name="twitter:creator" content="@malithatishamal">
  <meta name="twitter:title" content="Malitha Tishamal – Full Stack & DevOps Engineer">
  <meta name="twitter:description" content="Building secure, scalable web applications with expertise in Full Stack Development, DevOps, AI integration, and cybersecurity.">
  <meta name="twitter:image" content="https://malithatishamal.42web.io/assets/img/profile/profile-malitha.jpg">
  <meta name="twitter:image:alt" content="Portfolio of Malitha Tishamal - Developer & Engineer">
  
  <!-- Additional SEO Meta Tags -->
  <meta name="subject" content="Full Stack Development, DevOps Engineering, Cybersecurity, Web Development">
  <meta name="classification" content="Technology, Software Development, IT Services">
  <meta name="language" content="en">
  <meta name="coverage" content="Worldwide">
  <meta name="distribution" content="global">
  <meta name="rating" content="General">
  <meta name="revisit-after" content="15 days">
  <meta name="theme-color" content="#2563eb">
  
  <!-- Mobile Optimization -->
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  
  
  
  <!-- PWA Manifest -->
  <link rel="manifest" href="/site.webmanifest">
  
  <!-- Structured Data / JSON-LD for Rich Results -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Person",
    "@id": "https://malithatishamal.42web.io/#person",
    "name": "Malitha Tishamal",
    "url": "https://malithatishamal.42web.io",
    "image": "https://malithatishamal.42web.io/assets/img/profile/profile-malitha.jpg",
    "jobTitle": "Full Stack Developer & DevOps Engineer",
    "worksFor": {
      "@type": "Organization",
      "name": "Freelance Developer"
    },
    "description": "Expert Full Stack Developer and DevOps Engineer specializing in secure web applications, AI integration, and cybersecurity solutions.",
    "address": {
      "@type": "PostalAddress",
      "addressCountry": "Sri Lanka"
    },
    "sameAs": [
      "https://github.com/malitha-tishamal",
      "https://www.linkedin.com/in/malitha-tishamal/",
      "https://twitter.com/malithatishamal"
    ],
    "knowsAbout": [
      "Full Stack Development",
      "DevOps Engineering",
      "Cybersecurity",
      "AI and Machine Learning",
      "Web Application Development",
      "Cloud Computing",
      "React.js",
      "Node.js",
      "Python",
      "Docker",
      "Kubernetes",
      "API Development"
    ],
    "offers": {
      "@type": "Service",
      "serviceType": "Web Development",
      "description": "Custom web application development with focus on security, scalability, and performance"
    }
  }
  </script>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Combined CSS Bundle -->
  <link rel="preload" href="assets/css/bundle.min.css" as="style">
  <link href="assets/css/bundle.min.css" rel="stylesheet">

  <?php
  // HTML Minification
  function minify_html($buffer) { return $buffer;
      $search = array(
          '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
          '/[^\S ]+\</s',     // strip whitespaces before tags, except space
          '/(\s)+/s',         // shorten multiple whitespace sequences
          '/<!--(.|\s)*?-->/' // Remove HTML comments
      );
      $replace = array(
          '>',
          '<',
          '\\1',
          ''
      );
      $buffer = preg_replace($search, $replace, $buffer);
      return $buffer;
  }
  ob_start("minify_html");
  ?>

</head>

<body class="index-page">

 <?php include_once ("includes/header.php") ?>

 <main class="main">

  <!-- Hero Section -->
  <section id="hero" class="hero section">

    <div class="container">
      <div class="row g-0 align-items-center">
        <div class="col-lg-6 hero-content" data-aos="fade-right" data-aos-delay="100">
          <div class="content-wrapper">
            <h1 class="hero-title"><?php echo htmlspecialchars($site_settings['site_name']); ?> - <span class="typed" data-typed-items="<?php echo htmlspecialchars($site_settings['hero_title']); ?>"></span></h1>
            <p class="lead"><?php echo htmlspecialchars($site_settings['hero_description']); ?></p>

            <div class="hero-stats" data-aos="fade-up" data-aos-delay="200">
              <div class="stat-item">
                <span class="purecounter" data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="2">0</span>
                <span class="stat-label">Projects Completed</span>
              </div>
              <div class="stat-item">
                <span class="purecounter" data-purecounter-start="0" data-purecounter-end="2" data-purecounter-duration="2">0</span>
                <span class="stat-label">Years Experience</span>
              </div>
                <!--div class="stat-item">
                  <span class="purecounter" data-purecounter-start="0" data-purecounter-end="98" data-purecounter-duration="2">0</span>
                  <span class="stat-label">Happy Clients</span>
                </div-->
              </div>

              <div class="hero-actions" data-aos="fade-up" data-aos-delay="300">
                <a href="#portfolio2" class="btn btn-primary">View My Work</a>
                <a href="#contact" class="btn btn-outline">Get In Touch</a>
              </div>

              <div class="social-links" data-aos="fade-up" data-aos-delay="400">
                <a href="https://x.com/MalithaTishamal" target="_blank" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="https://www.linkedin.com/in/malitha-tishamal" target="_blank" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                <a href="https://github.com/malitha-tishamal" target="_blank" aria-label="GitHub"><i class="bi bi-github"></i></a>
                <a href="https://www.instagram.com/malithatishamal" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                <a href="https://www.facebook.com/malitha.tishamal" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-6 hero-image" data-aos="fade-left" data-aos-delay="200">
           <!-- Updated HTML: 6 floating cards -->
<div class="image-container">
  <div class="floating-elements" aria-hidden="true">
    <div class="floating-card card-1" data-aos="zoom-in" data-aos-delay="300">
      <i class="bi bi-palette"></i>
      <span>UI/UX Design</span>
    </div>

    <div class="floating-card card-2" data-aos="zoom-in" data-aos-delay="400">
      <i class="bi bi-code-slash"></i>
      <span>Fullstack Development & DevOps</span>
    </div>

    <div class="floating-card card-3" data-aos="zoom-in" data-aos-delay="500">
      <i class="bi bi-lightning"></i>
      <span>Creative Ideas</span>
    </div>

    <div class="floating-card card-5" data-aos="zoom-in" data-aos-delay="700">
      <i class="bi bi-shield-lock"></i>
      <span>Cybersecurity & AI ML</span>
    </div>
  </div>

  <img src="assets/img/profile/profile-malitha.jpg" alt="Malitha Tishamal - Full Stack Developer & DevOps Engineer" class="img-fluid hero-main-image" width="1000" height="1000" loading="eager" fetchpriority="high">
  <div class="image-overlay"></div>
</div>

          </div>

        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title">
        <h2>About</h2>
        <p>
          Hi, I'm Malitha – a Fullstack Developer, DevOps Engineer, and AI & Cybersecurity Enthusiast. I’m passionate about creating modern, responsive, and secure applications that solve real-world problems. I love turning ideas into real projects, continuously learning new technologies, and tackling complex challenges with clean, efficient, and innovative code.
        </p>

      </div><!-- End Section Title -->
      <div class="about-section-wrapper" style="display:flex; align-content: center;">


        <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
          <div class="profile-image-wrapper">
            <div class="profile-image">
              <img src="assets/img/profile/profile-malitha.jpg" alt="Malitha Tishamal Profile" class="img-fluid" loading="lazy" width="280" height="280">
            </div>
            <div class="signature-section">
              <img src="assets/img/misc/signature-1.png" width="300px" alt="Signature" class="signature">
              <p class="quote">
                Building meaningful, secure, and innovative digital experiences through creative code.
              </p>
            </div>

          </div>
        </div>

        <div>
          <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center">



              <div class="col-lg-7" data-aos="fade-left" data-aos-delay="300">
                <div class="about-content">
                  <div class="intro">
                    <h2>Hi, I'm Malitha – Fullstack Developer | DevOps | AI & Cybersecurity Enthusiast</h2>

                    <!--p>Hi, I'm Malitha – a Fullstack Developer passionate about creating modern, responsive, and user-friendly Applications. I love turning ideas into real projects, continuously learning new technologies, and solving complex problems with clean, efficient code.</p-->
                  </div>

                  <div class="skills-grid">
                    <?php 
                    $service_res = $conn->query("SELECT * FROM services ORDER BY display_order ASC");
                    $delay = 400;
                    if($service_res->num_rows > 0) {
                        while($s = $service_res->fetch_assoc()): 
                    ?>
                    <div class="skill-item" data-aos="zoom-in" data-aos-delay="<?php echo $delay; ?>">
                      <div class="skill-icon">
                        <i class="<?php echo htmlspecialchars($s['icon_class']); ?>"></i>
                      </div>
                      <h4><?php echo htmlspecialchars($s['title']); ?></h4>
                      <p><?php echo htmlspecialchars($s['description']); ?></p>
                    </div>
                    <?php 
                            $delay += 50;
                        endwhile; 
                    } else {
                        echo "<p class='text-muted'>No services added yet.</p>";
                    }
                    ?>
                  </div>
                  <div class="journey-timeline" data-aos="fade-up" data-aos-delay="300">
                    <?php 
                    $resume_res = $conn->query("SELECT * FROM resume_entries ORDER BY display_order ASC");
                    if($resume_res->num_rows > 0) {
                        while($r = $resume_res->fetch_assoc()): 
                    ?>
                   <div class="timeline-item">
                    <div class="year"><?php echo htmlspecialchars($r['duration']); ?></div>
                    <div class="description">
                        <strong><span style="color:blue"><?php echo htmlspecialchars($r['organization']); ?></strong> <br><?php echo htmlspecialchars($r['title']); ?>
                        <?php if(!empty($r['description'])): ?>
                            <br><?php echo htmlspecialchars($r['description']); ?>
                        <?php endif; ?>
                    </div>
                  </div>
                    <?php 
                        endwhile; 
                    } else {
                        echo "<p class='text-muted'>No timeline entries found.</p>";
                    }
                    ?>
                </div>
                
                

                <div class="cta-section" data-aos="fade-up" data-aos-delay="400">
                  <div class="fun-fact">
                    <span class="emoji">💻</span>
                    <span class="text">“Building Secure, Innovative, and User-Centric Digital Experiences.”</span>

                  </div>
                  <div class="action-buttons">
                    <a href="#portfolio" class="btn btn-primary">View My Work</a>
                    <a href="#" class="btn btn-outline">Download Resume</a>
                  </div>
                </div>

              </div>
            </div>

          </div>

        </div>
      </div>
    </div>

  </section><!-- /About Section -->

<!-- Skills Section -->
<section id="skills" class="skills section">

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row">
      <!-- LEFT SIDE: Skills Grid -->
      <div class="col-lg-8">
        <div class="skills-grid">
          <div class="row g-4">

            <!-- Frontend Development -->
            <div class="col-md-6" data-aos="flip-left" data-aos-delay="200">
              <div class="skill-card">
                <div class="skill-header">
                  <i class="bi bi-code-slash"></i>
                  <h3>Frontend Development</h3>
                </div>
                <div class="skills-animation">
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">HTML / CSS / Bootstrap</span>
                      <span class="skill-percentage">95%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:95%"></div>
                    </div>
                  </div>
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">JavaScript</span>
                      <span class="skill-percentage">90%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:90%"></div>
                    </div>
                  </div>
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">React.js</span>
                      <span class="skill-percentage">85%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:85%"></div>
                    </div>
                  </div>
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">Flutter</span>
                      <span class="skill-percentage">82%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:82%"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Backend Development -->
            <div class="col-md-6" data-aos="flip-left" data-aos-delay="300">
              <div class="skill-card">
                <div class="skill-header">
                  <i class="bi bi-server"></i>
                  <h3>Backend Development</h3>
                </div>
                <div class="skills-animation">
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">Java</span>
                      <span class="skill-percentage">85%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:85%"></div>
                    </div>
                  </div>
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">Python</span>
                      <span class="skill-percentage">55%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:55%"></div>
                    </div>
                  </div>
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">PHP / Laravel</span>
                      <span class="skill-percentage">78%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:78%"></div>
                    </div>
                  </div>
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">MySQL</span>
                      <span class="skill-percentage">72%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:72%"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Design & Tools -->
            <div class="col-md-6" data-aos="flip-left" data-aos-delay="400">
              <div class="skill-card">
                <div class="skill-header">
                  <i class="bi bi-palette"></i>
                  <h3>Design & Tools</h3>
                </div>
                <div class="skills-animation">
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">Figma</span>
                      <span class="skill-percentage">85%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:85%"></div>
                    </div>
                  </div>
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">Photoshop / Illustrator</span>
                      <span class="skill-percentage">70%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:70%"></div>
                    </div>
                  </div>
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">Adobe XD / Canva</span>
                      <span class="skill-percentage">80%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:80%"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Cloud & DevOps -->
            <div class="col-md-6" data-aos="flip-left" data-aos-delay="500">
              <div class="skill-card">
                <div class="skill-header">
                  <i class="bi bi-cloud"></i>
                  <h3>Cloud & DevOps</h3>
                </div>
                <div class="skills-animation">
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">AWS</span>
                      <span class="skill-percentage">90%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:90%"></div>
                    </div>
                  </div>
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">Git / CI-CD</span>
                      <span class="skill-percentage">90%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:90%"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- AI & Cybersecurity -->
            <div class="col-md-6" data-aos="flip-left" data-aos-delay="600">
              <div class="skill-card">
                <div class="skill-header">
                  <i class="bi bi-cpu-fill"></i>
                  <h3>AI & Cybersecurity</h3>
                </div>
                <div class="skills-animation">
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">Python / TensorFlow / PyTorch</span>
                      <span class="skill-percentage">70%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:70%"></div>
                    </div>
                  </div>
                  <div class="skill-item">
                    <div class="skill-info">
                      <span class="skill-name">Secure Coding / Pen Testing</span>
                      <span class="skill-percentage">65%</span>
                    </div>
                    <div class="skill-bar progress">
                      <div class="progress-bar" style="width:65%"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- RIGHT SIDE: Expertise Summary -->
      <div class="col-lg-4">
        <div class="skills-summary" data-aos="fade-left" data-aos-delay="200">
          <h3>Core Technologies & Expertise</h3>
          <p>I craft scalable, modern, and visually engaging applications using a blend of mobile, web, cloud, AI, and cybersecurity technologies — bridging creativity with functionality.</p>

          <ul class="list-unstyled expertise-list mt-3">
            <li>🔹 <b>Flutter & Dart</b> — Cross-platform app development</li>
            <li>🔹 <b>Firebase</b> — Auth, Firestore, Storage, Hosting & Functions</li>
            <li>🔹 <b>Frontend:</b> HTML / CSS / Bootstrap / JS / React.js</li>
            <li>🔹 <b>Backend:</b> PHP / Laravel / MySQL / Java / Python</li>
            <li>🔹 <b>DevOps:</b> AWS / Git / CI-CD Pipelines</li>
            <li>🔹 <b>AI & ML:</b> Python, TensorFlow, PyTorch</li>
            <li>🔹 <b>Cybersecurity:</b> Secure Coding, Pen Testing</li>
          </ul>

          <div class="summary-stats mt-4">
            <div class="stat-item" data-aos="zoom-in" data-aos-delay="300">
              <div class="stat-circle"><i class="bi bi-trophy"></i></div>
              <div class="stat-info">
                <span class="stat-number">2+</span>
                <span class="stat-label">Years Experience</span>
              </div>
            </div>
            <div class="stat-item" data-aos="zoom-in" data-aos-delay="400">
              <div class="stat-circle"><i class="bi bi-diagram-3"></i></div>
              <div class="stat-info">
                <span class="stat-number">15+</span>
                <span class="stat-label">Projects Completed</span>
              </div>
            </div>
          </div>

          <div class="skills-badges" data-aos="fade-up" data-aos-delay="600">
            <div class="badge-list">
              <div class="skill-badge">Flutter</div>
              <div class="skill-badge">Firebase</div>
              <div class="skill-badge">React.js</div>
              <div class="skill-badge">Laravel</div>
              <div class="skill-badge">AWS</div>
              <div class="skill-badge">AI/ML</div>
              <div class="skill-badge">Cybersecurity</div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Expertise Summary -->
    </div>
  </div>


</section>

<!-- Resume Section -->
<section id="resume" class="resume section">

  <!-- Section Title -->
  <!-- Section Title -->
  <div class="container section-title">
    <h2>Resume</h2>
    <p>Tracking my professional journey, achievements, and skills over the years.</p>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row">
      <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
        <div class="experience-section">
          <div class="section-header">
            <h2><i class="bi bi-briefcase"></i> Professional Journey</h2>
            <p class="section-subtitle">A brief overview of my experiences, milestones, and accomplishments in the tech industry.</p>
          </div>

          <div class="experience-cards">
            <?php
            $exp_res = $conn->query("SELECT * FROM resume_experience ORDER BY display_order ASC, id DESC");
            if($exp_res && $exp_res->num_rows > 0):
                while($exp = $exp_res->fetch_assoc()):
            ?>
            <div class="experience-card" data-aos="zoom-in" data-aos-delay="300">
              <div class="card-header border-0 pb-0">
                <div class="role-info">
                  <h3 class="mb-1 fw-bold text-dark"><?php echo htmlspecialchars($exp['role']); ?></h3>
                  <h4 class="text-primary mb-0"><?php echo htmlspecialchars($exp['organization']); ?></h4>
                </div>
                <span class="duration badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill"><?php echo htmlspecialchars($exp['duration']); ?></span>
              </div>
              <div class="card-body">
                <p class="text-muted mb-3"><?php echo htmlspecialchars($exp['description']); ?></p>
                <?php if(!empty($exp['achievements'])): ?>
                <ul class="achievements list-unstyled">
                  <?php 
                  $ach_arr = explode("\n", $exp['achievements']);
                  foreach($ach_arr as $ach): if(trim($ach) == '') continue;
                  ?>
                    <li class="mb-2 d-flex align-items-start">
                      <i class="bi bi-check2-circle text-primary me-2 mt-1"></i>
                      <span><?php echo htmlspecialchars(trim($ach)); ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
                <?php endif; ?>
              </div>
            </div>
            <?php endwhile; else: ?>
            <p class="text-muted">No experience entries found.</p>
            <?php endif; ?>
          </div>
            </div>
          </div>

          <!-- Education Section -->
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
            <div class="education-section">
              <div class="section-header">
                <h2><i class="bi bi-mortarboard"></i> Academic Excellence</h2>
                <p class="section-subtitle">A summary of my academic achievements, certifications, and ongoing studies.</p>
              </div>

              <div class="education-timeline p-0">
                <div class="timeline-track"></div>
                <?php
                $edu_res = $conn->query("SELECT * FROM resume_education ORDER BY display_order ASC, id DESC");
                if($edu_res && $edu_res->num_rows > 0):
                    while($edu = $edu_res->fetch_assoc()):
                ?>
                <div class="education-item mb-4" data-aos="slide-up">
                  <div class="timeline-marker"></div>
                  <div class="education-content p-4 shadow-sm border-0 rounded-4 bg-white">
                    <div class="degree-header d-flex justify-content-between align-items-center mb-2">
                      <h3 class="h5 fw-bold text-dark mb-0"><?php echo htmlspecialchars($edu['degree']); ?></h3>
                      <span class="year badge bg-dark px-3 py-2 rounded-pill"><?php echo htmlspecialchars($edu['year']); ?></span>
                    </div>
                    <h4 class="institution text-primary h6 mb-3"><?php echo htmlspecialchars($edu['institution']); ?></h4>
                    <p class="small text-muted mb-3"><?php echo htmlspecialchars($edu['description']); ?></p>
                    <?php if(!empty($edu['details'])): ?>
                    <ul class="list-unstyled small">
                      <?php 
                      $det_arr = explode("\n", $edu['details']);
                      foreach($det_arr as $det): if(trim($det) == '') continue;
                      ?>
                        <li class="mb-2 d-flex align-items-start">
                          <i class="bi bi-dot text-primary fs-4 lh-1"></i>
                          <span><?php echo htmlspecialchars(trim($det)); ?></span>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                  </div>
                </div>
                <?php endwhile; else: ?>
                <p class="text-muted ps-4">No education entries found.</p>
                <?php endif; ?>
              </div>

</div>

</section>

<!-- Licenses & Certifications Section -->
<section id="certifications" class="certifications section light-background">
  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Licenses & certifications</h2>
    <p>Professional certifications and credentials verifying my expertise and continuous learning.</p>
  </div><!-- End Section Title -->

  <div class="container">
    <div class="row gy-4">
      <?php
      $cert_res = $conn->query("SELECT * FROM certifications ORDER BY display_order ASC, issue_year DESC, id DESC");
      if($cert_res && $cert_res->num_rows > 0):
          while($cert = $cert_res->fetch_assoc()):
      ?>
      <div class="col-lg-4 col-md-6" data-aos="fade-up">
        <div class="cert-card card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
          <div class="card-header bg-white border-bottom-0 pb-0 pt-3 px-3 d-flex align-items-center">
            <div class="cert-logo-small me-3">
              <?php if(!empty($cert['logo'])): ?>
                <img src="<?php echo htmlspecialchars($cert['logo']); ?>" alt="Org Logo" style="width: 45px; height: 45px; object-fit: contain;">
              <?php else: ?>
                <div class="bg-light rounded p-2"><i class="bi bi-award fs-3 text-muted"></i></div>
              <?php endif; ?>
            </div>
            <div class="cert-meta">
              <h6 class="mb-0 fw-bold text-dark"><?php echo htmlspecialchars($cert['organization']); ?></h6>
              <small class="text-muted">Issued <?php echo htmlspecialchars($cert['issue_month']); ?> <?php echo htmlspecialchars($cert['issue_year']); ?></small>
            </div>
          </div>
          <div class="card-body px-3 pt-3">
            <h5 class="card-title fw-bold" style="font-size: 1.05rem; min-height: 2.6rem;"><?php echo htmlspecialchars($cert['title']); ?></h5>
            <?php if(!empty($cert['skills'])): ?>
              <div class="cert-skills-small mb-3">
                 <?php 
                  $skills_arr = explode(',', $cert['skills']);
                  foreach($skills_arr as $skill): 
                  ?>
                    <span class="badge bg-light text-dark fw-normal border me-1 small mb-1" style="font-size: 0.75rem;">
                      <i class="bi bi-diamond text-primary"></i> <?php echo htmlspecialchars(trim($skill)); ?>
                    </span>
                  <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
          <?php if(!empty($cert['media_image'])): ?>
            <div class="cert-media-thumb">
              <a href="<?php echo htmlspecialchars($cert['media_image']); ?>" class="glightbox">
                 <img src="<?php echo htmlspecialchars($cert['media_image']); ?>" alt="Certificate Preview" class="w-100" style="height: 180px; object-fit: cover; border-top: 1px solid #f0f0f0;">
              </a>
            </div>
          <?php endif; ?>
          <div class="card-footer bg-white border-top-0 px-3 pb-3 pt-2">
            <?php if(!empty($cert['credential_url'])): ?>
              <a href="<?php echo htmlspecialchars($cert['credential_url']); ?>" target="_blank" class="btn btn-outline-primary btn-sm w-100 rounded-pill py-1">
                <i class="bi bi-patch-check-fill me-1"></i> Show credential <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.7rem;"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endwhile; else: ?>
      <div class="col-12 text-center py-5">
        <p class="text-muted">No certifications added yet. Manage them from the admin panel.</p>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">
      <?php
      // Fetch testimonials
      $testi_res = $conn->query("SELECT * FROM testimonials ORDER BY display_order ASC, id DESC");
      $testimonials = [];
      $total_rating = 0;
      if($testi_res && $testi_res->num_rows > 0) {
          while($row = $testi_res->fetch_assoc()) {
              $testimonials[] = $row;
              $total_rating += $row['rating'];
          }
      }
      $num_testi = count($testimonials);
      $avg_rating = $num_testi > 0 ? round($total_rating / $num_testi, 1) : 0;
      ?>
      <!-- Section Title -->
      <div class="container section-title">
        <h2>Testimonials</h2>
        <p>What my clients and partners say about our collaboration and results.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <?php if($num_testi > 0): ?>
        <div class="row">
          <div class="col-12">
            <!-- Optional: You can keep critic reviews or hide them if not needed. 
                 Since the user asked for customer reviews specifically, I'll focus on the slider. -->
            
            <div class="testimonials-container">
              <div class="swiper testimonials-slider init-swiper" data-aos="fade-up" data-aos-delay="400">
                <script type="application/json" class="swiper-config">
                  {
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                      "delay": 5000
                    },
                    "slidesPerView": 1,
                    "spaceBetween": 30,
                    "pagination": {
                      "el": ".swiper-pagination",
                      "type": "bullets",
                      "clickable": true
                    },
                    "breakpoints": {
                      "768": {
                        "slidesPerView": 2
                      },
                      "992": {
                        "slidesPerView": 3
                      }
                    }
                  }
                </script>

                <div class="swiper-wrapper">
                  <?php foreach($testimonials as $testi): ?>
                  <div class="swiper-slide">
                    <div class="testimonial-item">
                      <div class="stars">
                        <?php 
                        $stars = floor($testi['rating']);
                        $has_half = ($testi['rating'] - $stars) >= 0.5;
                        for($i=1; $i<=5; $i++) {
                            if($i <= $stars) echo '<i class="bi bi-star-fill"></i>';
                            elseif($has_half && $i == $stars + 1) {
                                echo '<i class="bi bi-star-half"></i>';
                                $has_half = false;
                            }
                            else echo '<i class="bi bi-star"></i>';
                        }
                        ?>
                      </div>
                      <p>
                        <?php echo htmlspecialchars($testi['message']); ?>
                      </p>
                      <div class="testimonial-profile">
                        <img src="<?php echo htmlspecialchars($testi['profile_pic']); ?>" alt="<?php echo htmlspecialchars($testi['name']); ?>" class="img-fluid rounded-circle">
                        <div>
                          <h3><?php echo htmlspecialchars($testi['name']); ?></h3>
                          <h4><?php echo htmlspecialchars($testi['role']); ?></h4>
                        </div>
                      </div>
                    </div>
                  </div><!-- End testimonial item -->
                  <?php endforeach; ?>

                </div>
                <div class="swiper-pagination"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 text-center" data-aos="fade-up">
            <div class="overall-rating">
              <div class="rating-number"><?php echo $avg_rating; ?></div>
              <div class="rating-stars">
                <?php 
                $stars = floor($avg_rating);
                $has_half = ($avg_rating - $stars) >= 0.5;
                for($i=1; $i<=5; $i++) {
                    if($i <= $stars) echo '<i class="bi bi-star-fill"></i>';
                    elseif($has_half && $i == $stars + 1) {
                        echo '<i class="bi bi-star-half"></i>';
                        $has_half = false;
                    }
                    else echo '<i class="bi bi-star"></i>';
                }
                ?>
              </div>
              <p>Based on <?php echo $num_testi; ?>+ reviews</p>
              <div class="rating-platforms">
                <span>Verified Clients</span>
              </div>
            </div>
          </div>
        </div>
        <?php else: ?>
        <p class="text-center text-muted">No testimonials found. Add some from the admin panel!</p>
        <?php endif; ?>
      </div>
    </section><!-- /Testimonials Section -->


<!-- /Resume Section -->

<!-- Services Section -->
    <!--section id="services" class="services section">

      <!-- Section Title -->
      <!--div class="container section-title">
        <h2>Services</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <!--div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">

          <!-- Card 1 -->
          <!--div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item">
              <div class="icon">
                <i class="bi bi-stack"></i>
              </div>
              <h3>Digital Solutions</h3>
              <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium totam rem aperiam eaque ipsa.</p>
              <div class="card-links">
                <a href="#" class="link-item">
                  Learn More
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Card 2 -->
          <!--div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item">
              <div class="icon">
                <i class="bi bi-shield-check"></i>
              </div>
              <h3>Secure Systems</h3>
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur excepteur sint occaecat cupidatat.</p>
              <div class="card-links">
                <a href="#" class="link-item">
                  Learn More
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Card 3 -->
          <!--div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item">
              <div class="icon">
                <i class="bi bi-graph-up"></i>
              </div>
              <h3>Growth Strategy</h3>
              <p>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur vel illum qui dolorem.</p>
              <div class="card-links">
                <a href="#" class="link-item">
                  Learn More
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Card 4 -->
          <!--div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item">
              <div class="icon">
                <i class="bi bi-cpu"></i>
              </div>
              <h3>AI Integration</h3>
              <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione.</p>
              <div class="card-links">
                <a href="#" class="link-item">
                  Learn More
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Card 5 -->
          <!--div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item">
              <div class="icon">
                <i class="bi bi-cloud-arrow-up"></i>
              </div>
              <h3>Cloud Services</h3>
              <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos.</p>
              <div class="card-links">
                <a href="#" class="link-item">
                  Learn More
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Card 6 -->
          <!--div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item">
              <div class="icon">
                <i class="bi bi-gear"></i>
              </div>
              <h3>Process Automation</h3>
              <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus.</p>
              <div class="card-links">
                <a href="#" class="link-item">
                  Learn More
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div><!-- End Service Item -->

        <!--/div>

      </div>

    </section><!-- /Services Section -->

    <section id="portfolio" class="portfolio section">



      <!-- Section Title -->
      <div class="container section-title">
        <h2>Portfolio</h2>
        <p>
Explore a diverse portfolio capturing professional events and achievements, office environments, training programs, and travel experiences—showcasing growth, collaboration, and real-world exposure.
</p>


      </div><!-- End Section Title -->

      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="200">
            <li data-filter="*" class="filter-active">
              <i class="bi bi-grid-3x3"></i> All Photos
            </li>
            <li data-filter=".filter-events">
              Events & wins
            </li>
            <li data-filter=".filter-office">
              Office
            </li>
            <li data-filter=".filter-traning">
              Traning Programs
            </li>

            <li data-filter=".filter-travel">
              Travel
            </li>
          </ul>

          <div class="row g-4 isotope-container" data-aos="fade-up" data-aos-delay="300">
          <?php 
          $evt_res = $conn->query("SELECT * FROM portfolio_events ORDER BY display_order ASC");
          if($evt_res->num_rows > 0) {
              while($e = $evt_res->fetch_assoc()): 
          ?>
           <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item isotope-item <?php echo htmlspecialchars($e['category']); ?>">
             <article class="portfolio-entry">
               <figure class="entry-image entry-image-fixed">
                 <img src="<?php echo htmlspecialchars($e['main_image']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($e['title']); ?>" loading="lazy" width="380" height="380">
                 <div class="entry-overlay">
                   <div class="overlay-content">
                     <div class="entry-meta text-highlight"><?php echo htmlspecialchars($e['highlight_text']); ?></div>
                     <h3 class="entry-title"><?php echo htmlspecialchars($e['title']); ?></h3>
                     <p class="text-white-desc"><?php echo $e['description']; ?></p>
                     <div class="entry-links">
                       <a href="<?php echo htmlspecialchars($e['main_image']); ?>" class="glightbox" data-gallery="<?php echo htmlspecialchars($e['gallery_id']); ?>" data-glightbox="title: <?php echo htmlspecialchars($e['title']); ?>; description: <?php echo htmlspecialchars(strip_tags(str_replace('<br>', ' ', $e['description']))); ?>"><i class="bi bi-arrows-angle-expand"></i></a>
                       <a href="<?php echo htmlspecialchars($e['link_url']); ?>" target="_blank"><i class="bi bi-arrow-right"></i></a>
                     </div>
                   </div>
                 </div>
               </figure>
             </article>
           </div>
          <?php 
              endwhile; 
          } else {
              echo "<p class='text-center w-100 text-muted'>No events found.</p>";
          }
          ?>
          <!-- End Portfolio Container -->

</div>

</div>

</section><!-- /Portfolio Section -->


<!-- Portfolio Section -->
<section id="portfolio2" class="portfolio section">

  <!-- Section Title -->
  <div class="container section-title">
    <h2>Projects Portfolio</h2>
    <p class="text-muted">Some featured projects showcasing innovation and excellence</p>
  </div><!-- End Section Title -->

  <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

      <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="200">
        <li data-filter="*" class="filter-active">
          <i class="bi bi-grid-3x3"></i> All Projects
        </li>

         <li data-filter=".filter-customer">
          Customers Projects
        </li>

        <li data-filter=".filter-hndit">
          HNDIT Projects
        </li>
        <li data-filter=".filter-personal">
          Personal Projects
        </li>

        <li data-filter=".filter-offcial">
          Goverment Projects
        </li>
      </ul>



      <div class="row g-4 isotope-container" data-aos="fade-up" data-aos-delay="300">
          <?php 
          $proj_res = $conn->query("SELECT * FROM portfolio_projects ORDER BY display_order ASC");
          if($proj_res->num_rows > 0) {
              while($p = $proj_res->fetch_assoc()): 
          ?>
          <div class="col-xl-3 col-lg-4 col-md-6 portfolio-item isotope-item <?php echo htmlspecialchars($p['category']); ?>">
            <article class="portfolio-entry">
              <figure class="entry-image">
                <img src="<?php echo htmlspecialchars($p['main_image']); ?>" class="img-fluid portfolio-app-img" alt="<?php echo htmlspecialchars($p['title']); ?>" loading="lazy">
                <div class="entry-overlay">
                  <div class="overlay-content">
                    <div class="entry-meta text-highlight"><?php echo htmlspecialchars($p['title']); ?></div>
                    <p class="text-white-desc"><?php echo htmlspecialchars($p['short_description']); ?></p>
                    <div class="entry-links">
                      <a href="<?php echo htmlspecialchars($p['main_image']); ?>" class="glightbox" data-gallery="portfolio-gallery-development" data-glightbox="title: <b><?php echo htmlspecialchars($p['title']); ?></b><br><br><?php echo htmlspecialchars($p['short_description']); ?>"><i class="bi bi-arrows-angle-expand"></i></a>
                      <a href="<?php echo htmlspecialchars($p['details_link']); ?>"><i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </figure>
            </article>
          </div>
          <?php 
              endwhile; 
          } else {
              echo "<p class='text-center w-100 text-muted'>No projects found.</p>";
          }
          ?>
          <!-- End Portfolio Container -->
          </div>


</div>

</div>

</section><!-- /Portfolio Section -->


    <!-- Contact Section -->
    <section id="contact" class="contact section light-background">

      <!-- Section Title -->
      <div class="container section-title">
        <h2>Contact</h2>
        <p>We’d love to hear from you! Whether you have questions, project inquiries, or just want to connect, reach out to us using the details below or the contact form.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4 g-lg-5">
          <div class="col-lg-5">
            <div class="info-box" data-aos="fade-up" data-aos-delay="200">
              <h3>Contact Info</h3>
              <p>Let’s Connect, Collaborate, and Build Something Amazing.</p>

              <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-box">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div class="content">
                  <h4>Location</h4>
                  <p>Denipitiya,</p>
                  <p>Weligama,</p>
                  <p>Sri Lanka</p>
                </div>
              </div>

              <div class="info-item" data-aos="fade-up" data-aos-delay="400">
                <div class="icon-box">
                  <i class="bi bi-telephone"></i>
                </div>
                <div class="content">
                  <h4>Phone Number</h4>
                  <p>+94 5590992</p>
                  <p>+94 1295976</p>
                </div>
              </div>

              <div class="info-item" data-aos="fade-up" data-aos-delay="500">
                <div class="icon-box">
                  <i class="bi bi-envelope"></i>
                </div>
                <div class="content">
                  <h4>Email Address</h4>
                  <p><?php echo htmlspecialchars($site_settings['contact_email']); ?></p>
                </div>
              </div>

              <div class="info-item" data-aos="fade-up" data-aos-delay="600">
                <div class="icon-box">
                  <i class="bi bi-whatsapp"></i>
                </div>
                <div class="content">
                  <h4>WhatsApp</h4>
                  <p><a href="https://wa.me/94775590992" target="_blank">+94 77 559 0992</a></p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
              <h3>Get In Touch</h3>
              <p>Let’s Connect, Collaborate, and Build Something Amazing.</p>

              <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                <div class="row gy-4">

                  <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                  </div>

                  <div class="col-md-6 ">
                    <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                  </div>

                  <div class="col-12">
                    <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                  </div>

                  <div class="col-12">
                    <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                  </div>

                  <div class="col-12 text-center">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div>

                    <button type="submit" class="btn">Send Message</button>
                  </div>

                </div>
              </form>

            </div>
          </div>

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <?php include_once ("includes/footer.php") ?>

</body>

</html>