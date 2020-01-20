<?php

if (php_sapi_name() !== 'cli') {
    exit;
}

require __DIR__ . '/../vendor/autoload.php';

// load config
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();