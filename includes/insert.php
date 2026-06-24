<?php
// Look for db.php in the immediate directory first, then fallback to sibling folder
if (file_exists(__DIR__ . '/db.php')) {
    require_once __DIR__ . '/db.php';
} else {
    require_once __DIR__ . '/../includes/db.php';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $middlename = $_POST['middlename'] ?? '';
    $address = $_POST['address'] ?? '';
    $contact = $_POST['contact'] ?? '';

    try {
        $sql = "INSERT INTO students (name, surname, middlename, address, contact_number) 
                VALUES (:name, :surname, :middlename, :address, :contact)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name'       => $name,
            ':surname'    => $surname,
            ':middlename' => $middlename,
            ':address'    => $address,
            ':contact'    => $contact
        ]);

        // Smart redirect back to index.php where it resides
        if (file_exists(__DIR__ . '/../index.php')) {
            header("Location: ../index.php?status=success");
        } else {
            header("Location: index.php?status=success");
        }
        exit();
        
    } catch (PDOException $e) {
        die("Database Insertion Error: " . $e->getMessage());
    }
}
?>
