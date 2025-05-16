<?php

namespace Framework;

class Viewer
{
    public function render(string $template, array $data = []): string
    {
        
        $data['base_url'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

        extract($data, EXTR_SKIP);

        ob_start();

        require "views/$template";

        return ob_get_clean();
    }
}
