<?php
define('MYSQL_HOST', getenv('MYSQL_HOST') ?: 'mysql');
define('MYSQL_PORT', getenv('MYSQL_PORT') ?: '3306');
define('MYSQL_USER', getenv('MYSQL_USER') ?: 'developer');
define('MYSQL_PASSWORD', getenv('MYSQL_PASSWORD') ?: '123');
define('MYSQL_DB', getenv('MYSQL_DB') ?: 'php_test');

try {
    $conn = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DB . ";charset=utf8mb4",
        MYSQL_USER,
        MYSQL_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
