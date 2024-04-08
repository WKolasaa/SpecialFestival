<?php

namespace App\Services;

use App\Repositories\TokenRepository;

class TokenService
{
    public function storeOrUpdateToken($email, $tokenString)
    {
        $tokenrepository = new TokenRepository();
        $tokenrepository->storeOrUpdateToken($email, $tokenString);
    }

    public function generateRandomToken()
    {
        return bin2hex(random_bytes(16));
    }

    public function checkToken($email, $token)
    {
        $tokenrepository = new TokenRepository();
        return $tokenrepository->checkToken($email, $token);
    }
}