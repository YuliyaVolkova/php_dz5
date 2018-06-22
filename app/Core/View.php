<?php

namespace App\Core;

class View
{
    public function render(string $filename, array $data)
    {
        extract($data);
        require_once __DIR__. "/../views/" . $filename . ".php";
    }
}
