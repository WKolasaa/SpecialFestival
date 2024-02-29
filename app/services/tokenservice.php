<?php

namespace App\Services;

use App\Repositories\tokenrepository;

class tokenservice
{
    public function updateResetToken($userId, $token) {
        $tokenrepository = new tokenrepository();
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);  // Hash the token for security
        $tokenrepository->updateResetToken($userId, $hashedToken);
    }
}