<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['DB_HOST'] ?? 'sql12.freesqldatabase.com';
$dbname = $_ENV['DB_NAME'] ?? 'sql12760672';
$username = $_ENV['DB_USER'] ?? 'sql12760672';
$password = $_ENV['DB_PASS'] ?? 'Mx8srXdpka';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>