<?php

/**
 * MySQL connection من متغيرات البيئة (Railway أو أي استضافة).
 * الأولوية: MYSQL_URL ثم MYSQLHOST و MYSQLPORT و MYSQLUSER و MYSQLPASSWORD و MYSQL_DATABASE / MYSQLDATABASE
 *
 * على Railway: اربط خدمة MySQL بالتطبيق أو انسخ المتغيرات إلى خدمة الويب حتى تُقرأ هنا عبر getenv().
 * محلياً: عرّف نفس المتغيرات في .env أو إعدادات السيرفر، أو استخدم القيم الاحتياطية أدناه (بدون كلمات مرور حقيقية في الكود).
 */
function resolve_railway_db_config(): array
{
    $mysqlUrl = getenv('MYSQL_URL');
    if ($mysqlUrl !== false && $mysqlUrl !== '') {
        $parts = parse_url($mysqlUrl);
        if ($parts !== false && isset($parts['scheme']) && $parts['scheme'] === 'mysql') {
            return [
                'host' => $parts['host'] ?? '127.0.0.1',
                'port' => isset($parts['port']) ? (int) $parts['port'] : 3306,
                'user' => isset($parts['user']) ? rawurldecode($parts['user']) : 'root',
                'pass' => isset($parts['pass']) ? rawurldecode($parts['pass']) : '',
                'name' => isset($parts['path']) ? trim(rawurldecode($parts['path']), '/') : 'railway',
            ];
        }
    }

    // قيم احتياطية للتطوير المحلي فقط — لا تُستخدم في الإنتاج بدون تعريف المتغيرات
    $localHost = '127.0.0.1';
    $localUser = 'root';
    $localPass = '';
    $localName = 'railway';

    $host = getenv('MYSQLHOST');
    if ($host === false || $host === '') {
        $host = getenv('DB_HOST');
    }
    if ($host === false || $host === '') {
        $host = $localHost;
    }

    $port = getenv('MYSQLPORT');
    if ($port === false || $port === '') {
        $port = getenv('DB_PORT');
    }
    $port = ($port !== false && $port !== '') ? (int) $port : 3306;

    $user = getenv('MYSQLUSER');
    if ($user === false || $user === '') {
        $user = getenv('DB_USER');
    }
    if ($user === false || $user === '') {
        $user = $localUser;
    }

    $pass = getenv('MYSQLPASSWORD');
    if ($pass === false || $pass === '') {
        $pass = getenv('MYSQL_ROOT_PASSWORD');
    }
    if ($pass === false || $pass === '') {
        $pass = getenv('DB_PASSWORD');
    }
    if ($pass === false || $pass === '') {
        $pass = $localPass;
    }

    $name = getenv('MYSQL_DATABASE');
    if ($name === false || $name === '') {
        $name = getenv('MYSQLDATABASE');
    }
    if ($name === false || $name === '') {
        $name = getenv('DB_NAME');
    }
    if ($name === false || $name === '') {
        $name = $localName;
    }

    return [
        'host' => $host,
        'port' => $port,
        'user' => $user,
        'pass' => $pass,
        'name' => $name,
    ];
}
