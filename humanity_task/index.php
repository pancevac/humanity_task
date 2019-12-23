<?php

use App\Application;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader as TwigLoader;

require_once __DIR__ . '/vendor/autoload.php';

// Load env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Init twig template instance
$twig = new Environment(new TwigLoader(__DIR__ . '/resources/views'), [
    // 'cache' => __DIR__ . '/resources/cache',
]);

$app = new Application($twig);
echo $app->boot();