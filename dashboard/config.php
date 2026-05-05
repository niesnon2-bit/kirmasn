<?php

require_once __DIR__ . '/db-config.php';

$dbConfig = resolve_railway_db_config();

/** MySQL hostname (use mysql.railway.internal when both app and DB run on Railway). */
define('DB_HOST', $dbConfig['host']);

/** MySQL port */
define('DB_PORT', $dbConfig['port']);

/** MySQL database username */
define('DB_USER', $dbConfig['user']);

/** MySQL database password */
define('DB_PASSWORD', $dbConfig['pass']);

/** MySQL database name */
define('DB_NAME', $dbConfig['name']);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('CAN_REGISTER', 'none');
define('DEFAULT_ROLE', 'member');

// For development only!!
define('SECURE', false);

define('DEBUG', true);


?>
