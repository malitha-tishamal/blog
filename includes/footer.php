  <footer id="footer" class="footer dark-background">

   <div class="container">

    <!-- Top -->
    <div class="footer-top text-center">
      <h3 class="footer-name">Malitha Tishamal</h3>
      <p class="footer-role">Fullstack Developer • DevOps • AI & Cybersecurity Enthusiast</p>

      <!-- Social Icons -->
      <div class="footer-social-links">
        <a href="https://x.com/MalithaTishamal" target="_blank" class="social-icon"><i class="bi bi-twitter-x"></i></a>
        <a href="https://www.linkedin.com/in/malitha-tishamal" target="_blank" class="social-icon"><i class="bi bi-linkedin"></i></a>
        <a href="https://github.com/malitha-tishamal" target="_blank" class="social-icon"><i class="bi bi-github"></i></a>
        <a href="https://www.instagram.com/malithatishamal" target="_blank" class="social-icon"><i class="bi bi-instagram"></i></a>
        <a href="https://www.facebook.com/malitha.tishamal" target="_blank" class="social-icon"><i class="bi bi-facebook"></i></a>
      </div>
    </div>

    <!-- Line -->
    <div class="footer-divider"></div>

    <!-- Bottom -->
    <div class="footer-bottom text-center">
      <p>© <span id="year"></span> <strong>Malitha Tishamal</strong> — All Rights Reserved</p>
      <p class="footer-credit">Designed & Developed by Malitha Tishamal</p>
      <div class="footer-views">
        <i class="bi bi-globe"></i>
        <span><?php echo number_format($totalViews); ?> Website Visits</span>
      </div>
    </div>
  </div>
</footer>

<script>
  document.getElementById("year").innerText = new Date().getFullYear();
</script>
<style>
  .footer-views {
  margin-top: 12px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 16px;
  font-size: 13px;
  border-radius: 20px;
  background: rgba(108, 99, 255, 0.15);
  border: 1px solid rgba(108, 99, 255, 0.35);
  color: #cfcfff;
}

  .footer-section {
  background: linear-gradient(110deg, #0a0a0f, #11121a, #0d0f14);
  padding: 60px 0 30px;
  color: #ffffffcc;
  position: relative;
}

.footer-name {
  font-size: 28px;
  font-weight: 700;
  color: #fff;
}

.footer-role {
  font-size: 15px;
  margin-bottom: 20px;
  opacity: 0.85;
}

.footer-social-links {
  margin-top: 15px;
  display: flex;
  gap: 15px;
  justify-content: center;
}

.social-icon {
  color: #ffffffcc;
  font-size: 20px;
  border: 1px solid #ffffff22;
  width: 42px;
  height: 42px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  transition: 0.3s ease-in-out;
}

.social-icon:hover {
  color: #fff;
  border-color: #6c63ff;
  background: #6c63ff;
  transform: translateY(-4px) scale(1.07);
  box-shadow: 0 8px 20px rgba(108, 99, 255, 0.4);
}

.footer-divider {
  width: 100%;
  height: 1px;
  background: #ffffff22;
  margin: 25px 0;
}

.footer-bottom p {
  margin: 5px 0;
  font-size: 14px;
  opacity: 0.8;
}

.footer-credit a {
  color: #6c63ff;
  text-decoration: none;
  transition: 0.3s;
}

.footer-credit a:hover {
  color: #8b84ff;
}

</style>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Combined JS Bundle -->
  <script src="assets/js/bundle.min.js"></script>
<?php ob_end_flush(); ?>