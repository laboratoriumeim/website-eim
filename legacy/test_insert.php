<?php
require 'db.php';
$data = [
    'title' => 'Test',
    'category' => 'Test',
    'status' => 'Test',
    'event_date' => 'Test',
    'description' => 'Test',
    'link' => 'Test',
    'image' => 'Test',
    'icon' => 'Test',
    'organizer' => 'Test',
    'benefits' => ['A', 'B'],
    'requirements' => ['C', 'D']
];

try {
    $stmt = $pdo->prepare("INSERT INTO events (title, category, status, event_date, description, link, image, icon, organizer, benefits, requirements) VALUES (:title, :category, :status, :event_date, :description, :link, :image, :icon, :organizer, :benefits, :requirements)");
    $stmt->execute([
        'title' => $data['title'],
        'category' => $data['category'],
        'status' => $data['status'],
        'event_date' => $data['event_date'],
        'description' => $data['description'],
        'link' => $data['link'],
        'image' => $data['image'],
        'icon' => $data['icon'],
        'organizer' => $data['organizer'] ?? null,
        'benefits' => isset($data['benefits']) ? json_encode($data['benefits']) : null, // Wait, I didn't do this in the actual code!
        'requirements' => isset($data['requirements']) ? json_encode($data['requirements']) : null // And I didn't do this either!
    ]);
    echo "Success!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
