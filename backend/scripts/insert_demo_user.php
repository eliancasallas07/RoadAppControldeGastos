<?php
require dirname(__DIR__) . '/vendor/autoload.php';

use Doctrine\DBAL\DriverManager;

$databaseUrl = getenv('DATABASE_URL');
if (!$databaseUrl) {
    // fallback - adjust to your local credentials if needed
    $databaseUrl = 'mysql://root:root@127.0.0.1:3306/road_app';
}

$conn = DriverManager::getConnection(['url' => $databaseUrl]);

$sql = "INSERT INTO `user` (`nombre`,`email`,`roles`,`password`) VALUES ('Usuario Demo','demo@example.com','[\"ROLE_USER\"]','contraseña_demo') ON DUPLICATE KEY UPDATE `nombre`=VALUES(`nombre`), `roles`=VALUES(`roles`), `password`=VALUES(`password`)";

try {
    $conn->executeStatement($sql);
    echo "OK\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
