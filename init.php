<?php

require __DIR__.'/vendor/autoload.php';

use Aditya\DetikTest\Config\Database;
use Aditya\DetikTest\Config\DotEnv;

(new DotEnv(__DIR__.'/.env'))->load();

$db = new Database();
$conn = $db->initDB();
