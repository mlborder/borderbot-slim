<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/j4mie/idiorm/idiorm.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

ORM::configure([
    'connection_string' => sprintf('mysql:host=%s;dbname=%s;port=%d', getenv('SLIM_DB_HOST'), getenv('SLIM_DB_NAME'), getenv('SLIM_DB_PORT')),
    'username' => getenv('SLIM_DB_USER'),
    'password' => getenv('SLIM_DB_PASS')
]);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
