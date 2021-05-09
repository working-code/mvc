<?php

namespace App\Core;

class Session
{
    const USER_ID = 'user_id_lkjhfewkljhfdiuqw8ed6t8qw756763t673vxeeg67';

    public function setUserId(int $id)
    {
        $_SESSION[self::USER_ID] = $id;
    }

    public function getUserId(): ?int
    {
        if (isset($_SESSION[self::USER_ID])) {
            return $_SESSION[self::USER_ID];
        }
        return null;
    }

    public function unsetUserId()
    {
        unset($_SESSION[self::USER_ID]);
    }
}
