<?php
require_once 'db.php';

try {
    // 1. Create Users Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(255) NOT NULL,
        nim VARCHAR(50) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        telp VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') DEFAULT 'user'
    )");

    // 2. Create Events Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        category VARCHAR(100) NOT NULL,
        status VARCHAR(50) NOT NULL,
        event_date VARCHAR(100) NOT NULL,
        description TEXT NOT NULL,
        link VARCHAR(255) NOT NULL,
        image LONGTEXT NOT NULL,
        icon VARCHAR(50) NOT NULL
    )");

    // 3. Create News Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS news (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        category VARCHAR(100) NOT NULL,
        author VARCHAR(100) NOT NULL,
        news_date DATE NOT NULL,
        content TEXT NOT NULL,
        image LONGTEXT NOT NULL
    )");

    // 4. Create default admin if not exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = 'admin@eim.com'");
    $stmt->execute();
    if ($stmt->rowCount() == 0) {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $insertAdmin = $pdo->prepare("INSERT INTO users (nama, nim, email, telp, password, role) VALUES ('Administrator', '000000', 'admin@eim.com', '08123456789', :password, 'admin')");
        $insertAdmin->execute(['password' => $password]);
        echo "Default admin created (admin@eim.com / admin123).<br>";
    }

    echo "Database tables setup successfully.";

} catch (PDOException $e) {
    die("ERROR: Could not setup database. " . $e->getMessage());
}
?>
