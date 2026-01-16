  <?php
ob_start();
include "db-conn.php";

// Increase total website views
mysqli_query($conn, "UPDATE site_views SET total_views = total_views + 1 WHERE id = 1");

// Get total views
$res = mysqli_query($conn, "SELECT total_views FROM site_views WHERE id = 1");
$row = mysqli_fetch_assoc($res);
$totalViews = $row['total_views'];
?>


  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.webp" alt=""> -->
        <!-- Uncomment the line below if you also wish to use an text logo -->
        <!-- <h1 class="sitename">Style</h1>  -->
      </a>

      <nav id="navmenu" class="navmenu">

        <div class="profile-img">
          <img src="assets/img/profile/profile-malitha.jpg" alt="" class="img-fluid rounded-circle">
        </div>

        <a href="index.php" class="logo d-flex align-items-center justify-content-center active">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.webp" alt=""> -->
          <h1 class="sitename">Malitha Tishamal</h1>
        </a>

        <div class="d-flex" style="gap: 8px;"> <!-- adjust 8px as needed -->
  <a href="https://x.com/MalithaTishamal" target="_blank" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
  <a href="https://www.linkedin.com/in/malitha-tishamal" target="_blank" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
  <a href="https://github.com/malitha-tishamal" target="_blank" aria-label="GitHub"><i class="bi bi-github"></i></a>
  <a href="https://www.instagram.com/malithatishamal" target="_blank" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
  <a href="https://www.facebook.com/malitha.tishamal" target="_blank" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
</div>


        <ul>
          <li><a href="index.php#hero">Home</a></li>
          <li><a href="index.php#about">About</a></li>
          <li><a href="index.php#resume">Resume</a></li>
          <li><a href="index.php#portfolio">Portfolio</a></li>
          <li><a href="index.php#portfolio2">Projects</a></li>
          <!--li><a href="#services">Services</a></li-->
          <!--li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
            </ul>
          </li-->
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>