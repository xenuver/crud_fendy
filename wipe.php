<?php
$host = getenv('database.default.hostname') ?: 'db';
$user = getenv('database.default.username') ?: getenv('DB_USERNAME') ?: 'root';
$pass = getenv('database.default.password') ?: getenv('DB_PASSWORD') ?: '';
$db   = getenv('database.default.database') ?: getenv('DB_DATABASE') ?: 'db_kreator';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    $stmt = $pdo->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $table = $row[0];
        $pdo->exec("DROP TABLE `$table`");
        echo "Dropped table: $table\n";
    }
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    echo "All tables dropped successfully!\n";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}
