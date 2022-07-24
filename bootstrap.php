<?php

use Illuminate\Database\Capsule\Manager;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/sysconfig.inc.php';

$manager = new Manager;
$manager->addConnection([
    "driver" => "mysql",
    "host" => DB_HOST,
    "port" => DB_PORT,
    "database" => DB_NAME,
    "username" => DB_USERNAME,
    "password" => DB_PASSWORD
]);
$manager->setAsGlobal();
$manager->bootEloquent();