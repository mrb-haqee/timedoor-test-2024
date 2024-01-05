<?php
define('ROOT_DIR', __DIR__);


require_once(ROOT_DIR . '/vendor/autoload.php');
require_once(ROOT_DIR . '/database/Connect.php');

use Dotenv\Dotenv;
use Faker\Factory;

// Load .env
$dotenv = Dotenv::createImmutable(ROOT_DIR);
$dotenv->load();

$host = $_ENV['DB_HOST'] ?? '';
$database = $_ENV['DB_DATABASE'] ?? '';
$username = $_ENV['DB_USERNAME'] ?? '';
$password = $_ENV['DB_PASSWORD'] ?? '';

$pdo = Connect($host, $database, $username, $password, True);
require_once(ROOT_DIR . '/database/MakeTable.php');

// make fake data
$faker = Factory::create();
require_once(ROOT_DIR . '/database/MakeFakeData.php');
