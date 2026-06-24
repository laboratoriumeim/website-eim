<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

if ($method === 'GET') {
    $stmt = $pdo->query("SELECT * FROM news ORDER BY news_date DESC");
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Format variables to match frontend structure (e.g., date vs news_date)
    $formatted_news = [];
    foreach ($news as $n) {
        $n['date'] = $n['news_date']; 
        $formatted_news[] = $n;
    }
    echo json_encode($formatted_news);
} 
elseif ($method === 'POST') {
    if (!isAdmin()) { http_response_code(403); echo json_encode(['error' => 'Unauthorized']); exit; }
    
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO news (title, category, author, news_date, content, image) VALUES (:title, :category, :author, :news_date, :content, :image)");
    $stmt->execute([
        'title' => $data['title'],
        'category' => $data['category'],
        'author' => $data['author'],
        'news_date' => $data['date'],
        'content' => $data['content'],
        'image' => $data['image']
    ]);
    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
} 
elseif ($method === 'PUT') {
    if (!isAdmin()) { http_response_code(403); echo json_encode(['error' => 'Unauthorized']); exit; }

    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("UPDATE news SET title=:title, category=:category, author=:author, news_date=:news_date, content=:content, image=:image WHERE id=:id");
    $stmt->execute([
        'id' => $data['id'],
        'title' => $data['title'],
        'category' => $data['category'],
        'author' => $data['author'],
        'news_date' => $data['date'],
        'content' => $data['content'],
        'image' => $data['image']
    ]);
    echo json_encode(['success' => true]);
} 
elseif ($method === 'DELETE') {
    if (!isAdmin()) { http_response_code(403); echo json_encode(['error' => 'Unauthorized']); exit; }

    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("DELETE FROM news WHERE id=:id");
    $stmt->execute(['id' => $data['id']]);
    echo json_encode(['success' => true]);
}
?>
