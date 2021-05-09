<?php

namespace App\Core;

use App\Models\User;

abstract class MainController
{
    /** @var MainView */
    protected $view;

    /** @var User */
    protected $user;

    /** @var Session */
    protected $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    public function setView(MainView $view): void
    {
        $this->view = $view;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    protected function redirect(string $url)
    {
        throw new RedirectException($url);
    }
}
