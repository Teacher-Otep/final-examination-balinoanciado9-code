<?php
$host = '127.0.0.1'; 
$db   = 'dbstudents';  // Aligned perfectly to your database schema name
$user = 'root';        
$pass = '';            
$port = '3308';        // Set to your local 3308 port. Change to '3306' before uploading to GitHub!
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     die("Connection failed: " . $e->getMessage());
}
?>
