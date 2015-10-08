<?php

namespace Toolz;

class Parser implements Templating {

    private $paths;
    private $vars;
    private $extensions = [
        ".php",
        ".html"
    ];

    public function __construct(array $paths = [],array $vars = []) {
        $this->paths = $paths;
        $this->vars = $vars;
    }

    public function render($template,array $values = []) {
        extract($this->vars);
        if (count($values) > 0) extract($values);
        ob_start();
        $fullPath = $this->findPath($template);
        include $fullPath;
        return ob_get_clean();
    }

    private function findPath($template) {
        $tries = [];
        foreach ($this->paths as $path) {
            foreach ($this->extensions as $extension) {
                $fullPath = "$path$template$extension";
                if (file_exists($fullPath)) {
                    return $fullPath;
                }
                $tries[] = $fullPath;
            }
        }
        throw new \Exception("templates not found: [ ".implode(" ; ",$tries)." ]");
    }

}