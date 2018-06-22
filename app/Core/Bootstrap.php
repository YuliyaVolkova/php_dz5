<?php

namespace App\Core;

use Symfony\Component\Dotenv\Dotenv;

class Bootstrap
{
    public function __construct()
    {
        define('APPLICATION_PATH', getcwd() . '/../app/');
        define('PUBLIC_PATH', getcwd());
        require APPLICATION_PATH . '../vendor/autoload.php';
        $dotEnv = new Dotenv();
        $dotEnv->load(APPLICATION_PATH . '../.env');
    }
}
