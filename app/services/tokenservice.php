<?php

namespace App\Services;

use App\Repositories\tokenrepository;

class tokenservice
{
    public function storeOrUpdateToken($email, $tokenString) {
        $tokenrepository = new tokenrepository();
        $tokenrepository->storeOrUpdateToken($email, $tokenString);
    }

    public function generateRandomToken(){
        return bin2hex(random_bytes(16));
    }

    public function checkToken($email, $token){
        $tokenrepository = new tokenrepository();
        return $tokenrepository->checkToken($email, $token);
    }
}