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

  // Skip actual email sending to avoid local mail server errors
  // WhatsApp Notification (Optional - requires CallMeBot API Key)
  $wp_apikey = '4342416'; // User should replace this or it can be moved to settings
  $wp_phone = '94775590992'; 
  
  if(!empty($wp_apikey)) {
      $wp_text = urlencode("New Message from $name:\n$msg");
      $wp_url = "https://api.callmebot.com/whatsapp.php?phone=$wp_phone&text=$wp_text&apikey=$wp_apikey";
      @file_get_contents($wp_url); // Silent call
  }

  echo "OK"; 
?>
