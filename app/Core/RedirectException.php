<?php

namespace App\Core;

use Throwable;

class RedirectException extends \Exception
{
    private string $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
