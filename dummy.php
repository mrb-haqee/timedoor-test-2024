<?php
define('ROOT_DIR', __DIR__);

function generateEnvFile()
{
    $envExample = '.env.example';
    $envFile = '.env';

    if (file_exists($envExample)) {
        if (!file_exists($envFile)) {
            $content = file_get_contents($envExample);
            file_put_contents($envFile, $content);
            echo "The .env file was successfully created from .env.example\n";
        } else {
            echo "The .env file already exists, creation is canceled.\n";
        }
    }
}
echo "make .env file? [yes]\n=> ";
$input = trim(fgets(STDIN));
if ($input === "yes" || $input === "") {
    generateEnvFile();
}

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
