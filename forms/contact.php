<?php
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

  // Replace contact@example.com with your real receiving email address
  $receiving_email_address = 'malithatishamal@gmail.com';

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    die( 'Unable to load the "PHP Email Form" Library!');
  }

  // ==== Database Logging ====
  require_once '../includes/db-conn.php';
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $subject = $_POST['subject'] ?? 'Website Contact';
  $msg = $_POST['message'] ?? '';
  
  $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
  try {
      $stmt->execute([$name, $email, $subject, $msg]);
  } catch (PDOException $e) {
      // Log error if needed, but don't stop the flow
  }

  // WhatsApp Notification (Dynamic from database)
  $settings_stmt = $conn->query("SELECT whatsapp_number, whatsapp_apikey, whatsapp_enabled FROM site_settings WHERE id = 1");
  $ws = $settings_stmt->fetch();

  if($ws && $ws['whatsapp_enabled'] == 1 && !empty($ws['whatsapp_apikey']) && !empty($ws['whatsapp_number'])) {
      $wp_phone = $ws['whatsapp_number'];
      $wp_apikey = $ws['whatsapp_apikey'];
      
      // Prepend 94 if it starts with 07 (for convenience)
      if(strpos($wp_phone, '07') === 0 && strlen($wp_phone) == 10) {
          $wp_phone = '94' . substr($wp_phone, 1);
      }

      $wp_text = urlencode("🚀 *New Website Message*\n\n*From:* $name\n*Email:* $email\n*Subject:* $subject\n\n*Message:*\n$msg");
      $wp_url = "https://api.callmebot.com/whatsapp.php?phone=$wp_phone&text=$wp_text&apikey=$wp_apikey";
      @file_get_contents($wp_url); // Silent call
  }

  echo "OK"; 
?>
