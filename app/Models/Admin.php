<?php

namespace App\Models;

class Admin extends User
{
    public function isAdmin()
    {
        return $this->getId() === USER_ADMIN_ID;
    }

    public function getName(): string
    {
        if ($this->isAdmin()) {
            return 'admin ' . parent::getName();
        }
        return parent::getName();
    }
}
