<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected function setPassword(string $password)
    {
        $this->attributes['password'] = password_hash($password, PASSWORD_BCRYPT);
    }

    protected function setConfirmPassword(string $password)
    {
        unset($this->attributes['confirm-password']);
    }

    public function getAttributes()
    {
        return $this->attributes;
    }
}