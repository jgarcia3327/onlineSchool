<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{

  public function static sendMail($to, $subject, $message) {
    $headers = 'From: info@englishhours.net' . "\r\n" .
      'Reply-To: webmaster@englishhours.net' . "\r\n" .
      'X-Mailer: PHP/' . phpversion();

    return mail($to, $subject, $message, $headers);
  }
}
