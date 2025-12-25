<?php

class PHP_Email_Form {
  public $to = '';
  public $from_name = '';
  public $from_email = '';
  public $subject = '';
  public $smtp = false;
  public $ajax = false;

  private $messages = array();

  public function add_message($message, $label = '', $priority = 0) {
    $this->messages[] = array(
      'message' => $message,
      'label' => $label,
      'priority' => $priority
    );
  }

  public function send() {

    if (empty($this->to)) {
      return $this->error("Recipient email address is missing!");
    }

    if (!filter_var($this->from_email, FILTER_VALIDATE_EMAIL)) {
      return $this->error("Invalid sender email!");
    }

    $email_content = "You have received a new message:\n\n";

    foreach ($this->messages as $msg) {
      $label = $msg['label'] ? $msg['label'] . ": " : "";
      $email_content .= $label . $msg['message'] . "\n";
    }

    $headers = "From: {$this->from_name} <{$this->from_email}>\r\n";
    $headers .= "Reply-To: {$this->from_email}\r\n";

    // If using SMTP
    if ($this->smtp && is_array($this->smtp)) {
      return $this->send_smtp($email_content);
    }

    // Default mail()
    if (mail($this->to, $this->subject, $email_content, $headers)) {
      return $this->success();
    }

    return $this->error("Unable to send email! Server mail() failed.");
  }

  private function send_smtp($email_content) {
    $host = $this->smtp['host'];
    $username = $this->smtp['username'];
    $password = $this->smtp['password'];
    $port = $this->smtp['port'];

    $transport = stream_socket_client("tcp://$host:$port", $errno, $errstr, 30);

    if (!$transport) {
      return $this->error("SMTP connection failed: $errstr");
    }

    // NOTE: This is a simplified SMTP implementation.
    // Not recommended for high-security emails.
    // Use PHPMailer if you need strong SMTP features.

    fwrite($transport, "HELO $host\r\n");
    fwrite($transport, "MAIL FROM:<{$this->from_email}>\r\n");
    fwrite($transport, "RCPT TO:<{$this->to}>\r\n");
    fwrite($transport, "DATA\r\n");
    fwrite($transport, "Subject: {$this->subject}\r\n");
    fwrite($transport, "From: {$this->from_name} <{$this->from_email}>\r\n\r\n");
    fwrite($transport, $email_content . "\r\n.\r\n");
    fwrite($transport, "QUIT\r\n");

    fclose($transport);

    return $this->success();
  }

  private function success() {
    if ($this->ajax) {
      return "OK";
    }
    return true;
  }

  private function error($message) {
    if ($this->ajax) {
      return "Error: $message";
    }
    return false;
  }
}

?>
