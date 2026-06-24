<?php
require 'db.php';
try {
    $stmt = $pdo->prepare("INSERT INTO events (title, category, status, event_date, description, link, image, icon) VALUES ('test', 'test', 'upcoming', 'today', 'desc', '#', '[]', 'fa-calendar')");
    $stmt->execute();
    echo "Success: Inserted test event.";
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
