<?php

use App\Core\Application;

require_once '../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL | E_NOTICE);

$app = new Application();
$app->run();
