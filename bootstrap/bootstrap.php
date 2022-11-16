<?php

use Aditya\DetikTest\Config\Database;
use Aditya\DetikTest\Config\DotEnv;

require __DIR__ . '/../vendor/autoload.php';

(new DotEnv(__DIR__.'/../.env'))->load();

$dbConnection = (new Database())->connection();