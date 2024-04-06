<?php

namespace App\Services;

use Resend;

class EmailService
{
    public function sendResetTokenEmail($userEmail, $token)
    {
        $resend = Resend::client('re_DF4R1gUB_CFNiNU9FrxGhNdDUCFxaK6NN');

        $resend->emails->send([
            'from' => 'onboarding@resend.dev',
            'to' => '695344@student.inholland.nl',
            'subject' => 'Token reset',
            'html' => '<p>Your token is: <a href="http://localhost/changepassword?email=' . $userEmail . '&token=' . $token . '">Reset Password</a></p>'
        ]);
    }
}