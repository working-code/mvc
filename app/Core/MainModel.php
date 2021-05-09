<?php

namespace App\Core;

use PDO;

abstract class MainModel
{
    /** @var PDO */
    private static $db;

    public static function setDb(PDO $db)
    {
        self::$db = $db;
    }

    protected function getDb(): PDO
    {
        return self::$db;
    }
}
