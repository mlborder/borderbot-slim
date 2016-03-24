<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
define('SLIM_DB_HOST', getenv('SLIM_DB_HOST'));
define('SLIM_DB_NAME', getenv('SLIM_DB_NAME'));
define('SLIM_DB_PORT', getenv('SLIM_DB_PORT'));
define('SLIM_DB_USER', getenv('SLIM_DB_USER'));
define('SLIM_DB_PASS', getenv('SLIM_DB_PASS'));
define('SLIM_DB_TABLE', 'event_records');
ORM::configure([
    'connection_string' => sprintf('mysql:host=%s;dbname=%s;port=%d', SLIM_DB_HOST, SLIM_DB_NAME, SLIM_DB_PORT),
    'username' => SLIM_DB_USER,
    'password' => SLIM_DB_PASS
]);

require __DIR__ . '/models/event_record.php';
require __DIR__ . '/models/player.php';
require __DIR__ . '/models/week_record.php';
