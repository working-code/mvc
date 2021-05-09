<?php

namespace App\Core;

class MainView
{
    private $data = [];
    private $pathTemplate;

    public function __construct()
    {
        $this->pathTemplate = APP_ROOT_DIR . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Views';
    }

    public function render(string $pathTemplate, $data = [])
    {
        $this->data = array_merge($this->data, $data);
        ob_start();
        require_once $this->pathTemplate . DIRECTORY_SEPARATOR . $pathTemplate;
        return ob_get_clean();
    }

    public function addData(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($varName)
    {
        return $this->data[$varName] ?? null;
    }
}
