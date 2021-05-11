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
        $data = $this->getData();

        if (RENDER_TYPE === 2) {
            $loader = new \Twig\Loader\FilesystemLoader($this->pathTemplate . DIRECTORY_SEPARATOR);
            if (RENDER_TWIG_CACHE) {
                $twig = new \Twig\Environment($loader, [
                    'cache' => $this->pathTemplate . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR
                ]);
            } else {
                $twig = new \Twig\Environment($loader);
            }
            return $twig->render($pathTemplate . '.twig', $data);
        }

        ob_start();
        require_once $this->pathTemplate . DIRECTORY_SEPARATOR . $pathTemplate . '.phtml';
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

    public function getData(): array
    {
        return $this->data;
    }
}
