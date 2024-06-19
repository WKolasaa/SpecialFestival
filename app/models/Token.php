<?php

namespace App\Models;

class token
{
    private $tokenId;
    private $userEmail;
    private $token;
    private $createdAt;
    private $expiresAt;

    public function getUserEmail()
    {
        return $this->userEmail;
    }

    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    public function getTokenId()
    {
        return $this->tokenId;
    }

    public function setTokenId($tokenId)
    {
        $this->tokenId = $tokenId;
    }
}