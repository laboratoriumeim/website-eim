<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

if ($method === 'GET') {
    $stmt = $pdo->query("SELECT * FROM events ORDER BY id DESC");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($events);
} 
elseif ($method === 'POST') {
    if (!isAdmin()) { http_response_code(403); echo json_encode(['error' => 'Unauthorized']); exit; }
    
    $data = json_decode(file_get_contents("php://input"), true);
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
        'benefits' => isset($data['benefits']) ? json_encode($data['benefits']) : null,
        'requirements' => isset($data['requirements']) ? json_encode($data['requirements']) : null
    ]);
    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
} 
elseif ($method === 'PUT') {
    if (!isAdmin()) { http_response_code(403); echo json_encode(['error' => 'Unauthorized']); exit; }

    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("UPDATE events SET title=:title, category=:category, status=:status, event_date=:event_date, description=:description, link=:link, image=:image, icon=:icon, organizer=:organizer, benefits=:benefits, requirements=:requirements WHERE id=:id");
    $stmt->execute([
        'id' => $data['id'],
        'title' => $data['title'],
        'category' => $data['category'],
        'status' => $data['status'],
        'event_date' => $data['event_date'],
        'description' => $data['description'],
        'link' => $data['link'],
        'image' => $data['image'],
        'icon' => $data['icon'],
        'organizer' => $data['organizer'] ?? null,
        'benefits' => isset($data['benefits']) ? json_encode($data['benefits']) : null,
        'requirements' => isset($data['requirements']) ? json_encode($data['requirements']) : null
    ]);
    echo json_encode(['success' => true]);
} 
elseif ($method === 'DELETE') {
    if (!isAdmin()) { http_response_code(403); echo json_encode(['error' => 'Unauthorized']); exit; }

    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("DELETE FROM events WHERE id=:id");
    $stmt->execute(['id' => $data['id']]);
    echo json_encode(['success' => true]);
}
?>
