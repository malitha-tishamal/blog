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
  if($stmt) {
      $stmt->bind_param("ssss", $name, $email, $subject, $msg);
      $stmt->execute();
  }
  // ==========================

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address;
  $contact->from_name = $name;
  $contact->from_email = $email;
  $contact->subject = $subject;

  $contact->add_message( $name, 'From');
  $contact->add_message( $email, 'Email');
  isset($_POST['phone']) && $contact->add_message($_POST['phone'], 'Phone');
  $contact->add_message( $msg, 'Message', 10);

  echo $contact->send();
?>
