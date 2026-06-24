<?php
/* ==========================================================================
   LABEL: INTELLIGENT AUTO-FALLBACK DATABASE ENGINE
   Checks 3306 first for the grading server environment, then falls back to 3308.
   ========================================================================== */
$host = '127.0.0.1'; 
$db   = 'dbstudents';  // Aligned perfectly with your schema database initialization tag
$user = 'root';        
$pass = '';            
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Attempt 1: Connect using port 3306 (Teacher Environment Server Standard)
    $dsn = "mysql:host=$host;port=3306;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    try {
        // Attempt 2: Connect using port 3308 (Your local system environment alternative configuration)
        $dsn = "mysql:host=$host;port=3308;dbname=$db;charset=$charset";
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e2) {
        die("System Critical Error: Database Connection Instance Offline. " . $e2->getMessage());
    }
}
?>
