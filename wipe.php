<?php
define('ENVIRONMENT', 'development');
require 'vendor/autoload.php';
require 'system/bootstrap.php';

$db = \Config\Database::connect();
$forge = \Config\Database::forge();

$tables = $db->listTables();
$db->query('SET FOREIGN_KEY_CHECKS = 0');
foreach ($tables as $table) {
    $forge->dropTable($table, true);
    echo "Dropped table $table\n";
}
$db->query('SET FOREIGN_KEY_CHECKS = 1');
echo "All tables dropped successfully!\n";
