<?php

// Functions file


// Application Name
$app_name = 'airlines';

require_once __DIR__ . '/config.php';

// Database connection data (same source as PDO / config)
$host_name  = DB_HOST;
$username   = DB_USER;
$password   = DB_PASSWORD;
$db_name    = DB_NAME;
$db_port    = DB_PORT;

// Connect to database (database name in connect avoids extra USE query)
$db_connection = mysqli_connect($host_name, $username, $password, $db_name, $db_port);

if (!$db_connection) {
    echo 'يرجى تعديل معلومات الاتصال بقاعدة البيانات: ' . htmlspecialchars(mysqli_connect_error());
    die();
}

mysqli_set_charset($db_connection, 'utf8mb4');

// Table creation is handled by install_database.php (run once on Railway).

//----------------------------------------------
