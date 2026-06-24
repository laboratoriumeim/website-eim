<?php
require_once 'db.php';

try {
    // Check if username column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'username'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE users ADD COLUMN username VARCHAR(100) UNIQUE AFTER nama");
        echo "Added username column.<br>";
    }

    // Insert or Update the admin user eimjaya
    $username = 'eimjaya';
    $password = password_hash('eimsisfo', PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO users (nama, username, nim, email, telp, password, role) VALUES ('Admin EIM', ?, '000000', 'admin2@eim.com', '000000', ?, 'admin')");
        $stmt->execute([$username, $password]);
        echo "Admin eimjaya created.<br>";
    } else {
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->execute([$password, $username]);
        echo "Admin eimjaya updated.<br>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
