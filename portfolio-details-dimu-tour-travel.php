<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=5.0" name="viewport">
  
  <title>Dimu Tour & Traveling – Custom Tourism Website | PHP MySQL Project | Malitha Tishamal</title>
  <meta name="description" content="Complete detailed report of Dimu Tour & Traveling – a modern, database-driven travel website with an intuitive admin dashboard. Built with PHP, MySQL, Bootstrap, and AJAX for seamless user experience.">
  <meta name="keywords" content="Dimu Tour, Travel Website, PHP MySQL Project, Tourism Website, Admin Dashboard, Travel Booking System, Wildlife Safaris Sri Lanka, Custom Tour Packages, Malitha Tishamal Portfolio">
  <meta name="author" content="Malitha Tishamal - Full Stack Developer">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://malithatishamal.42web.io/portfolio-details-dimu-tour-travel.php">
  
  <!-- Open Graph -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="Dimu Tour & Traveling – Complete Project Report">
  <meta property="og:description" content="Modern travel website with full admin control, tour booking, and dynamic content management.">
  <meta property="og:image" content="https://malithatishamal.42web.io/assets/img/portfolio/dimu-tour/1.png">
  <meta property="og:url" content="https://malithatishamal.42web.io/portfolio-details-dimu-tour-travel.php">
  
  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Dimu Tour & Traveling – Project Report">
  <meta name="twitter:description" content="Complete technical report of a custom tourism website with admin dashboard.">
  
  <!-- Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Dimu Tour & Traveling",
    "description": "Modern travel website with full admin dashboard, tour booking system, and dynamic content management.",
    "version": "1.0",
    "url": "https://malithatishamal.42web.io/portfolio/dimu-tour-traveling",
    "applicationCategory": "TravelApplication",
    "operatingSystem": "Web",
    "author": {
      "@type": "Person",
      "name": "Malitha Tishamal",
      "url": "https://malithatishamal.42web.io"
    },
    "featureList": [
      "Dynamic Hero Slider",
      "Tour & Safari Management",
      "Booking System (Tour & Taxi)",
      "Guest Reviews",
      "Travel Memories Gallery",
      "Admin Dashboard (Full CRUD)",
      "SEO Optimized",
      "Responsive Design"
    ],
    "softwareRequirements": "PHP 8, MySQL, Bootstrap 5, AJAX",
    "keywords": "travel website, php, mysql, admin panel, tour booking"
  }
  </script>

  <!-- Favicons & Fonts -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="assets/css/bundle.min.css" rel="stylesheet">
  
  <style>
    /* Additional custom styles */
    .report-header { background: linear-gradient(135deg, #2764E7 0%, #869AEC 100%); padding: 20px; border-radius: 10px; color: white; margin-bottom: 20px; }
    .tech-badge { display: inline-block; padding: 5px 12px; margin: 3px; background: #e9ecef; border-radius: 20px; font-size: 0.85rem; color: #495057; border: 1px solid #dee2e6; transition: all 0.3s ease; }
    .tech-badge:hover { background: #2764E7; color: white; transform: translateY(-2px); }
    .demo-card { background: white; padding: 20px; border-radius: 10px; text-align: center; border: 1px solid #e0e7ff; transition: all 0.3s ease; height: 100%; }
    .demo-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(39,100,231,0.1); border-color: #2764E7; }
    .btn-demo { display: inline-block; padding: 8px 20px; background: #2764E7; color: white; border-radius: 5px; text-decoration: none; width: 100%; }
    .btn-demo:hover { background: #1a4fc4; color: white; }
    .collection-item { display: flex; align-items: center; gap: 15px; padding: 10px; border-bottom: 1px solid #eee; }
    .code-path { background: #f5f5f5; padding: 5px 10px; border-radius: 5px; border-left: 3px solid #2764E7; font-family: monospace; margin: 5px 0; }

    /* Testimonial style */
    .testimonial-card {
      background: #f8faff;
      border-left: 4px solid #2764E7;
      padding: 25px;
      border-radius: 12px;
      margin: 20px 0;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .testimonial-card i.bi-quote {
      font-size: 2rem;
      color: #2764E7;
      opacity: 0.3;
      margin-bottom: 10px;
      display: block;
    }
    .testimonial-card p {
      font-size: 1rem;
      line-height: 1.6;
      font-style: italic;
      color: #2c3e50;
    }
    .testimonial-card footer {
      margin-top: 15px;
      font-weight: 600;
      color: #2764E7;
    }
  </style>
</head>

<body class="portfolio-details-page">

  <?php include_once ("includes/header.php") ?>

  <main class="main">
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Dimu Tour & Traveling – Complete Project Report</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Dimu Tour & Traveling</li>
          </ol>
        </nav>
      </div>
    </div>

    <section id="portfolio-details" class="portfolio-details section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <!-- Left Column: Images & Tech -->
          <div class="col-lg-6" data-aos="fade-right">
            <!-- Slider -->
            <div class="portfolio-details-slider swiper init-swiper" data-aos="zoom-in">
              <script type="application/json" class="swiper-config">
                {
                  "loop": true, "speed": 1000, "autoplay": { "delay": 2000 },
                  "effect": "creative", "creativeEffect": { "prev": { "shadow": true, "translate": [0,0,-400] }, "next": { "translate": ["100%",0,0] } },
                  "slidesPerView": 1, "navigation": { "nextEl": ".swiper-button-next", "prevEl": ".swiper-button-prev" }
                }
              </script>
              <div class="swiper-wrapper">
                <!-- Slides 1-31 -->
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/1.png" class="img-fluid" alt="Dimu Tour Homepage" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/2.png" class="img-fluid" alt="Tour Packages" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/3.png" class="img-fluid" alt="Admin Dashboard" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/4.png" class="img-fluid" alt="Booking Form" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/5.png" class="img-fluid" alt="Travel Memories Gallery" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/6.png" class="img-fluid" alt="Safari Listings" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/7.png" class="img-fluid" alt="Vehicle Fleet" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/8.png" class="img-fluid" alt="Guest Reviews" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/9.png" class="img-fluid" alt="Contact Page" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/10.png" class="img-fluid" alt="About Us" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/11.png" class="img-fluid" alt="Tour Itinerary" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/12.png" class="img-fluid" alt="Taxi Booking" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/13.png" class="img-fluid" alt="Gallery" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/14.png" class="img-fluid" alt="Blog" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/15.png" class="img-fluid" alt="Testimonials" width="800" height="600"></div>
                <div class="swiper-slide"><img src="assets/img/portfolio/dimu-tour/16.png" class="img-fluid" alt="Footer" width="800" height="600"></div>
              </div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>

            <!-- Thumbnail Grid -->
            <div class="thumbnail-grid mt-4">
              <h5>📸 Application Screens</h5>
              <div class="row g-2">
                <!-- 31 thumbnails -->
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/1.png" class="img-fluid glightbox" alt="Thumbnail 1"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/2.png" class="img-fluid glightbox" alt="Thumbnail 2"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/3.png" class="img-fluid glightbox" alt="Thumbnail 3"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/4.png" class="img-fluid glightbox" alt="Thumbnail 4"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/5.png" class="img-fluid glightbox" alt="Thumbnail 5"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/6.png" class="img-fluid glightbox" alt="Thumbnail 6"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/7.png" class="img-fluid glightbox" alt="Thumbnail 7"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/8.png" class="img-fluid glightbox" alt="Thumbnail 8"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/9.png" class="img-fluid glightbox" alt="Thumbnail 9"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/10.png" class="img-fluid glightbox" alt="Thumbnail 10"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/11.png" class="img-fluid glightbox" alt="Thumbnail 11"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/12.png" class="img-fluid glightbox" alt="Thumbnail 12"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/13.png" class="img-fluid glightbox" alt="Thumbnail 13"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/14.png" class="img-fluid glightbox" alt="Thumbnail 14"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/15.png" class="img-fluid glightbox" alt="Thumbnail 15"></div>
                <div class="col-4"><img src="assets/img/portfolio/dimu-tour/16.png" class="img-fluid glightbox" alt="Thumbnail 15"></div>
              </div>
            </div>

            <!-- Tech Stack -->
            <div class="tech-stack-section mt-4">
              <h5>🛠️ Technology Stack</h5>
              <div>
                <span class="tech-badge">PHP 8 (PDO)</span>
                <span class="tech-badge">MySQL</span>
                <span class="tech-badge">HTML5 / CSS3</span>
                <span class="tech-badge">JavaScript (ES6+)</span>
                <span class="tech-badge">Bootstrap 5</span>
                <span class="tech-badge">AJAX</span>
                <span class="tech-badge">FontAwesome 6</span>
                <span class="tech-badge">Google Fonts</span>
                <span class="tech-badge">WhatsApp API</span>
                <span class="tech-badge">Open Graph / Twitter Cards</span>
              </div>
              <div class="mt-3">
                <h6>Architecture: Database-driven, Admin Panel with Full CRUD</h6>
                <p>100% responsive, SEO-optimized, and mobile-first design.</p>
              </div>
            </div>

            <!-- Database Tables Summary -->
            <div class="database-section mt-4">
              <h5>🗄️ MySQL Database Tables</h5>
              <div class="collection-item"><i class="bi bi-shield-lock"></i><div><strong>admins</strong><small> – Dashboard authentication</small></div></div>
              <div class="collection-item"><i class="bi bi-map"></i><div><strong>tours & tour_days</strong><small> – Packages with daily itineraries</small></div></div>
              <div class="collection-item"><i class="bi bi-tree"></i><div><strong>safari_destinations</strong><small> – Wildlife safari details</small></div></div>
              <div class="collection-item"><i class="bi bi-calendar-check"></i><div><strong>bookings & taxi_bookings</strong><small> – Customer inquiries</small></div></div>
              <div class="collection-item"><i class="bi bi-star"></i><div><strong>reviews</strong><small> – Guest feedback with ratings</small></div></div>
              <div class="collection-item"><i class="bi bi-images"></i><div><strong>travel_memories & memory_images</strong><small> – Stories and galleries</small></div></div>
              <div class="collection-item"><i class="bi bi-truck"></i><div><strong>vehicles & vehicle_images</strong><small> – Fleet management</small></div></div>
              <div class="collection-item"><i class="bi bi-sliders2"></i><div><strong>hero_slides & site_settings</strong><small> – Dynamic content control</small></div></div>
            </div>
          </div>

          <!-- Right Column: Content -->
          <div class="col-lg-6" data-aos="fade-left">
            <div class="portfolio-details-content">
              <div class="project-meta">
                <span class="project-badge completed">Completed Project</span>
                <span class="project-badge">Travel Website</span>
                <span class="project-badge">PHP MySQL</span>
                <span class="project-badge">Admin Dashboard</span>
              </div>
              <h2 class="project-title">Dimu Tour & Traveling</h2>
              <p class="project-subtitle">Modern, fully manageable travel website with complete backend control</p>
              
              <!-- CUSTOMER TESTIMONIAL (MOVED TO TOP) -->
              <div class="testimonial-card mt-3" data-aos="fade-up">
                <i class="bi bi-quote"></i>
                <p>“Hi Malitha, I just wanted to take a moment to sincerely thank you for the amazing work you did on my website for Dimu Tour & Travel. You understood exactly what I needed and delivered it in a very attractive and professional way, and that too in such a short time. I truly appreciate your creativity, effort, and dedication. The website looks exactly how I imagined it — even better! I’m really happy with your service and would highly recommend you to anyone looking for quality web design. Thank you again for your great work!”</p>
                <footer>— Dimuthu Weerasinghe, Owner of Dimu Tour & Travel</footer>
              </div>
              
              <div class="project-overview">
                <div class="project-intro mt-4">
                  <h4>🌏 A Complete Digital Solution for Tour Operators</h4>
                  <p>Dimu Tour & Traveling is a premium tourism website built to offer travelers an effortless booking experience while giving the client full autonomy over all content. From dynamic tour packages and safari listings to a powerful admin dashboard, every piece of content is database‑driven and instantly updatable.</p>
                </div>

                <!-- Problem & Solution Cards -->
                <div class="row g-3 mt-4">
                  <div class="col-md-6">
                    <div class="problem-card p-3 border rounded">
                      <h5><i class="bi bi-exclamation-triangle"></i> Traditional Challenges</h5>
                      <ul><li>Static websites with no content control</li><li>Manual booking management</li><li>No guest review system</li><li>Difficult to update tours or images</li></ul>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="solution-card p-3 border rounded">
                      <h5><i class="bi bi-lightbulb"></i> Digital Solutions</h5>
                      <ul><li>Full admin panel (CRUD for all content)</li><li>Automated booking storage</li><li>Moderated review section</li><li>Media manager for tours & memories</li></ul>
                    </div>
                  </div>
                </div>

                <!-- Accordion with Detailed Report -->
                <div class="accordion project-accordion mt-4" id="portfolio-details-projectAccordion">
                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTech" aria-expanded="true">
                        <i class="bi bi-stack me-2"></i> 1. Technology Stack & Architecture
                      </button>
                    </h2>
                    <div id="collapseTech" class="accordion-collapse collapse show" data-bs-parent="#portfolio-details-projectAccordion">
                      <div class="accordion-body">
                        <ul>
                          <li><strong>Frontend:</strong> HTML5, Vanilla CSS3, JavaScript (ES6+), Bootstrap 5 – fully responsive and mobile‑optimized.</li>
                          <li><strong>Backend:</strong> PHP 8 with PDO for secure, prepared statements to prevent SQL injection.</li>
                          <li><strong>Database:</strong> MySQL with normalized tables for tours, bookings, reviews, and site settings.</li>
                          <li><strong>AJAX:</strong> Seamless form submissions without page reloads for booking forms.</li>
                          <li><strong>Third‑Party Integrations:</strong> WhatsApp API for instant booking notifications, Google Maps for location, and FontAwesome for icons.</li>
                          <li><strong>SEO:</strong> Custom meta tags, Open Graph, Twitter Cards, and developer credit for brand visibility.</li>
                        </ul>
                        <div class="code-path mt-2"><i class="bi bi-folder"></i> Core folders: /admin (dashboard), /includes (config & functions), /assets (CSS, JS, images)</div>
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFeatures">
                        <i class="bi bi-list-check me-2"></i> 2. Detailed Feature Breakdown
                      </button>
                    </h2>
                    <div id="collapseFeatures" class="accordion-collapse collapse" data-bs-parent="#portfolio-details-projectAccordion">
                      <div class="accordion-body">
                        <h5>🌍 Frontend User Experience</h5>
                        <ul>
                          <li><strong>Dynamic Hero Slider:</strong> Manageable titles/subtitles from database.</li>
                          <li><strong>Tour & Safari Listings:</strong> Interactive cards with day‑by‑day itineraries; fully editable via admin.</li>
                          <li><strong>Vehicle Fleet:</strong> Displays transport options with capacities and image galleries.</li>
                          <li><strong>Booking System (Tour & Taxi):</strong> AJAX‑powered forms that store data and trigger WhatsApp alerts.</li>
                          <li><strong>Guest Reviews:</strong> Public testimonials with star ratings – admin can approve, edit, or delete.</li>
                          <li><strong>Travel Memories Gallery:</strong> Multiple images per memory; fully manageable.</li>
                          <li><strong>Contact & About:</strong> Google Maps integration and editable contact info from admin panel.</li>
                        </ul>
                        <h5 class="mt-3">🛡️ Admin Dashboard Capabilities</h5>
                        <ul>
                          <li><strong>Dashboard Overview:</strong> Real‑time counts of tours, safaris, bookings, and reviews.</li>
                          <li><strong>Full CRUD for Tours & Itineraries:</strong> Add, edit, delete tours and their daily schedules.</li>
                          <li><strong>Manage Safaris, Vehicles, and Travel Memories:</strong> Upload images, descriptions, and pricing.</li>
                          <li><strong>Booking Management:</strong> View all tour and taxi bookings in one place.</li>
                          <li><strong>Review Moderation:</strong> Enable/disable or edit guest feedback.</li>
                          <li><strong>Site Settings:</strong> Centralized control over contact details, social links, and hero slider content.</li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDB">
                        <i class="bi bi-database me-2"></i> 3. Database Architecture
                      </button>
                    </h2>
                    <div id="collapseDB" class="accordion-collapse collapse" data-bs-parent="#portfolio-details-projectAccordion">
                      <div class="accordion-body">
                        <p>The MySQL database is structured for scalability and efficient queries. Key tables include:</p>
                        <ul>
                          <li><code>admins</code> – Stores hashed passwords for dashboard access.</li>
                          <li><code>tours</code> & <code>tour_days</code> – One‑to‑many relationship for detailed itineraries.</li>
                          <li><code>safari_destinations</code> – Dedicated table for wildlife safari content.</li>
                          <li><code>bookings</code> / <code>taxi_bookings</code> – Separate tables to distinguish service types.</li>
                          <li><code>reviews</code> – Includes rating, feedback, and moderation flags.</li>
                          <li><code>travel_memories</code> & <code>memory_images</code> – Supports multiple images per memory.</li>
                          <li><code>vehicles</code> & <code>vehicle_images</code> – Manages fleet with photo galleries.</li>
                          <li><code>hero_slides</code> – Controls homepage slider images and captions.</li>
                          <li><code>site_settings</code> – Key‑value store for global configuration (phone, email, social links).</li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDesign">
                        <i class="bi bi-palette me-2"></i> 4. Design & Aesthetics
                      </button>
                    </h2>
                    <div id="collapseDesign" class="accordion-collapse collapse" data-bs-parent="#portfolio-details-projectAccordion">
                      <div class="accordion-body">
                        <ul>
                          <li><strong>Color Palette:</strong> Calming blues and earthy greens inspired by Sri Lankan landscapes, with clean white backgrounds for readability.</li>
                          <li><strong>Typography:</strong> Inter (sans‑serif) for body text, Playfair Display for headings – elegant and modern.</li>
                          <li><strong>Layout:</strong> Bootstrap 5 grid ensures perfect responsiveness on desktops, tablets, and mobiles.</li>
                          <li><strong>Interactive Elements:</strong> Hover effects on cards, smooth scrolling, and subtle shadows to enhance depth.</li>
                          <li><strong>Admin Dashboard:</strong> Custom‑styled with intuitive icons, data tables, and real‑time statistics.</li>
                        </ul>
                      </div>
                    </div>
                  </div>

                  <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSEO">
                        <i class="bi bi-graph-up me-2"></i> 5. SEO & Performance Optimizations
                      </button>
                    </h2>
                    <div id="collapseSEO" class="accordion-collapse collapse" data-bs-parent="#portfolio-details-projectAccordion">
                      <div class="accordion-body">
                        <ul>
                          <li><strong>Meta Tags:</strong> Unique title, description, and keywords for every page.</li>
                          <li><strong>Open Graph & Twitter Cards:</strong> Ensures rich previews when shared on social media.</li>
                          <li><strong>Structured Data:</strong> JSON‑LD markup for better search engine understanding.</li>
                          <li><strong>Fast Loading:</strong> Optimized images, minified CSS/JS, and AJAX submissions prevent full page reloads.</li>
                          <li><strong>Developer Branding:</strong> “Developed by Malitha Tishamal” strategically placed for portfolio visibility.</li>
                          <li><strong>Mobile‑First:</strong> Fully tested on all device sizes for Core Web Vitals readiness.</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Implementation Highlights -->
                <div class="challenges-section mt-4">
                  <h4><i class="bi bi-tools"></i> Implementation Highlights</h4>
                  <div class="row g-3">
                    <div class="col-md-6"><div class="p-3 border rounded"><i class="bi bi-shield-check"></i> <strong>Secure Admin Authentication</strong> – Password hashing and session management.</div></div>
                    <div class="col-md-6"><div class="p-3 border rounded"><i class="bi bi-cloud-arrow-up"></i> <strong>AJAX Booking System</strong> – Smooth user experience without reloads.</div></div>
                    <div class="col-md-6"><div class="p-3 border rounded"><i class="bi bi-images"></i> <strong>Media Management</strong> – Upload and delete images for tours, vehicles, and memories.</div></div>
                    <div class="col-md-6"><div class="p-3 border rounded"><i class="bi bi-whatsapp"></i> <strong>WhatsApp Integration</strong> – Instant notification for new bookings.</div></div>
                  </div>
                </div>

                <!-- Demo Videos -->
                <div class="demo-section mt-4">
                  <h4><i class="bi bi-play-btn"></i> Live Demos</h4>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="demo-card">
                        <div class="demo-icon"><i class="bi bi-house-door"></i></div>
                        <h6>User View – Front End</h6>
                        <p>Explore the complete frontend experience: tour listings, booking forms, travel memories, and more.</p>
                        <!-- ↓ Replace with your actual video URL -->
                        <a href="https://shorturl.at/demo1" target="_blank" class="btn-demo">Watch Demo</a>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="demo-card">
                        <div class="demo-icon"><i class="bi bi-speedometer2"></i></div>
                        <h6>User View – Admin Panel</h6>
                        <p>Full admin dashboard: manage tours, safaris, bookings, site settings, and reviews.</p>
                        <!-- ↓ Replace with your actual video URL -->
                        <a href="https://shorturl.at/demo2" target="_blank" class="btn-demo">Watch Demo</a>
                      </div>
                    </div>
                  </div>
                  <!-- TODO: Replace the two demo URLs above with your actual video links -->
                </div>

                <!-- Next Project Button -->
                <div class="cta-buttons mt-4">
                  <a href="https://malithatishamal.42web.io/portfolio-details%20-mediq-app.php" class="btn btn-outline-primary">Next Project <i class="bi bi-arrow-right ms-2"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include_once ("includes/footer.php") ?>

  <script>
    const lightbox = GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true });
    console.log('Dimu Tour & Traveling report loaded.');
  </script>
</body>
</html>