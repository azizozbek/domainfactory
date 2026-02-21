<?php

namespace App;

class View {
    private string $path;
    private array $data = [];

    public function __construct($fileName) {
        $this->path = __DIR__ . '/Views/' . $fileName . '.php';

        if (!file_exists($this->path)) {
            throw new \Exception("View not found: " . $this->path);
        }

    }

    public function with($key): View
    {
        $this->data = array_merge($this->data, $key);
        return $this;
    }

    public function render(): false|string
    {
        extract($this->data);
        ob_start();

        include $this->path;

        $output = ob_get_clean();

        return $output;
    }

    public function __toString() {
        return $this->render();
    }
}