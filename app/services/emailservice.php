<?php

namespace App\Services;

class emailservice
{
    public function sendResetTokenEmail($userEmail, $token)
    {
        $to = $userEmail;
        $subject = 'Password Reset Token';
        $message = "Your password reset token is: $token";

        // TODO Change that!
        $headers = "From: localhost.com" . "\r\n" .
            "Reply-To: localhost.com" . "\r\n" .
            "X-Mailer: PHP/" . phpversion();

        echo $to;
        echo $subject;
        echo $message;
        echo $headers;

        if (mail($userEmail, $subject, $message, $headers)) {
            return true;
        } else {
            $error = error_get_last();
            echo "Error sending email: " . $error;
            return false;
        }
    }
}